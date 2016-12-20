<?php

namespace App;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Service
 *
 * @property integer $id
 * @property string $url
 * @property string $method
 * @property string $payload
 * @property string $name
 * @property string $description
 * @property boolean $active
 * @property integer $slow_threshold
 * @property integer $very_slow_threshold
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ServiceUpdate[] $service_updates
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ServiceHeader[] $service_headers
 * @method static \Illuminate\Database\Query\Builder|\App\Service whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Service whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Service whereMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Service wherePayload($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Service whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Service whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Service whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Service whereSlowThreshold($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Service whereVerySlowThreshold($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Service whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Service extends Model
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function service_updates()
    {
        return $this->hasMany(ServiceUpdate::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function service_headers()
    {
        return $this->hasMany(ServiceHeader::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function service_query_parameters()
    {
        return $this->hasMany(ServiceQueryParameter::class);
    }

    /**
     * Returns the last service update if it exists.
     * @return ServiceUpdate|null
     */
    public function last_update()
    {
        return $this->service_updates()->orderBy('updated_at', 'desc')->first();
    }

    /**
     * Returns the headers as an array.
     * @return array;
     */
    public function header_array()
    {
        $collection = [];
        foreach ($this->service_headers as $header) {
            $collection[$header->key] = $header->value;
        }
        return $collection;
    }

    /**
     * Returns the query parameters as an array.
     * @return array;
     */
    public function query_parameters_array()
    {
        $collection = [];
        foreach ($this->service_query_parameters as $header) {
            $collection[$header->key] = $header->value;
        }
        return $collection;
    }

    /**
     * Gets the status of the service, returns an unsaved ServiceUpdate
     * @return ServiceUpdate
     */
    public function determineServiceUpdate()
    {
        $update = new ServiceUpdate();
        $update->service()->associate($this);

        $options = [
            RequestOptions::HEADERS => $this->header_array(),
            RequestOptions::QUERY => $this->query_parameters_array(),
            RequestOptions::JSON => $this->payload,
            RequestOptions::ON_STATS => [$update, 'fillStatistics']
        ];

        $client = app()->make(ClientInterface::class);

        try {
            $promise = $client->requestAsync($this->method, $this->url, $options)->then([$update, 'fillResults']);
            $promise->wait();

            $status = ServiceStatus::STATUS_UP;

            if ($update->responseTime > $this->slow_threshold) {
                $status = ServiceStatus::STATUS_SLOW;
            }
            if ($update->responseTime > $this->very_slow_threshold) {
                $status = ServiceStatus::STATUS_VSLOW;
            }

            $update->setStatus($status);

        } catch (RequestException $e) {
            $update->setStatus(ServiceStatus::STATUS_DOWN);
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $log = 'Response code: ' . $response->getStatusCode() . PHP_EOL;
                $log .= 'Response reason: ' . $response->getReasonPhrase() . PHP_EOL;
                $log .= 'Body:' . PHP_EOL;
                $log .= $response->getBody()->getContents();
                $update->log = $log;
            } else {
                $update->log = 'Exception thrown: ' . $e->getMessage();
            }
        } catch (\Exception $e) {
            $update->setStatus(ServiceStatus::STATUS_DOWN);
            $update->log = 'Exception thrown: ' . $e->getMessage();
        }

        return $update;
    }

    /**
     * @return ServiceUpdate
     */
    public function createInitialUpdate()
    {
        $update = new ServiceUpdate();
        $update->service()->associate($this);
        $update->log = '';
        $update->responseTime = 0;
        $update->service_status()->associate(ServiceStatus::whereStatus(ServiceStatus::STATUS_UNKNOWN)->firstOrFail());
        $update->save();
        return $update;
    }

}
