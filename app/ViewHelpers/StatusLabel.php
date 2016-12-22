<?php


namespace App\ViewHelpers;


use App\ServiceStatus;

class StatusLabel
{
    public static function forStatus(ServiceStatus $status)
    {
        $label = self::getLabel($status->group);
        return self::labelFor($label, $status->status);
    }

    protected static function getLabel($group) {
        switch ($group) {
            case ServiceStatus::GROUP_GOOD:
                $label = 'success';
                break;
            case ServiceStatus::GROUP_BAD:
                $label = 'danger';
                break;
            case ServiceStatus::GROUP_WARNING:
                $label = 'warning';
                break;
            default:
                $label = 'default';
        }

        return $label;
    }

    public static function alertFor($status)
    {
        $label = self::getLabel($status['group']);
        return '<div class="alert alert-' . $label . '" role="alert"><strong>' . $status['name'] . "</strong> " . $status['status'] . '</div>';
    }

    protected static function labelFor($label, $status)
    {
        return '<span class="label label-' . $label . '">' . $status . '</span>';
    }
}