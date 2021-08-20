<?php

namespace App\Enums;

class ActivityTypesEnum
{
    public const FLIGHT = 'flight';
    public const DO = 'DO';
    public const ESBY = 'Early Standby';
    public const CSBE = 'Crewing Standby Early';
    public const ADTY = 'Airport Duty on Standby';
    public const INTV = 'Interviews / Interviewing';

    public const DO_STATUS = 'DO';
    public const ESBY_STATUS = 'ESBY';
    public const CSBE_STATUS = 'CSBE';
    public const ADTY_STATUS = 'ADTY';
    public const INTV_STATUS = 'INTV';

    public static function getType(string $type): ?string
    {
        if ($type === self::DO_STATUS) {
            return self::DO;
        }

        if ($type === self::ESBY_STATUS) {
            return self::ESBY;
        }

        if ($type === self::CSBE_STATUS) {
            return self::CSBE;
        }

        if ($type === self::ADTY_STATUS) {
            return self::ADTY;
        }

        if ($type === self::INTV_STATUS) {
            return self::INTV;
        }

        return null;
    }
}
