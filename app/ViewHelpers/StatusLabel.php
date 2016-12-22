<?php


namespace App\ViewHelpers;


use App\ServiceStatus;

class StatusLabel
{
    public static function forStatus(ServiceStatus $status)
    {
        switch ($status->group) {
            case ServiceStatus::GROUP_GOOD:
                return self::goodGroup($status->status);
            case ServiceStatus::GROUP_BAD:
                return self::badGroup($status->status);
            case ServiceStatus::GROUP_WARNING:
                return self::warningGroup($status->status);
            default:
                return self::neutralGroup($status->status);

        }
    }

    protected static function goodGroup($status)
    {
        return self::labelFor('success', $status);
    }

    protected static function badGroup($status)
    {
        return self::labelFor('danger', $status);
    }

    protected static function warningGroup($status)
    {
        return self::labelFor('warning', $status);
    }

    protected static function neutralGroup($status)
    {
        return self::labelFor('default', $status);
    }

    protected static function labelFor($label, $status)
    {
        return '<span class="label label-' . $label . '">' . $status . '</span>';
    }
}