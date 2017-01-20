<?php

namespace App;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\TransferStats;
use Illuminate\Database\Eloquent\Model;

/**
 * App\ServiceUpdate
 *
 * @property integer $id
 * @property integer $service_id
 * @property integer $service_status_id
 * @property string $log
 * @property integer $response_time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Service $service
 * @property-read \App\ServiceStatus $service_status
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceUpdate whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceUpdate whereServiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceUpdate whereServiceStatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceUpdate whereLog($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceUpdate whereResponseTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceUpdate whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceUpdate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServiceUpdate extends Model
{
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function service_status()
    {
        return $this->belongsTo(ServiceStatus::class);
    }

    public function history()
    {
        return $this->hasMany(ServiceResponseHistory::class);
    }

    public function fillStatistics(TransferStats $stats)
    {
        $this->response_time = (int)round($stats->getTransferTime() * 1000, 0);
    }

    public function fillResults(Response $response)
    {
        $log = 'Response code: ' . $response->getStatusCode() . PHP_EOL;
        $log .= 'Response reason: ' . $response->getReasonPhrase() . PHP_EOL;
        $log .= 'Body:' . PHP_EOL;
        $log .= $response->getBody()->getContents();

        $this->log = $log;
    }

    public function setStatus($status)
    {
        $this->service_status()->associate(ServiceStatus::whereStatus($status)->firstOrFail());
    }
}
