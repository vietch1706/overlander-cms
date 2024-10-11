<?php

namespace Overlander\General\Helper;

use Carbon\Carbon;

class General
{
    public const LIMIT_DEFAULT = 10;
    public  const PAGE_DEFAULT = 1;
    public static function getCurrentDay()
    {
        return Carbon::now()->format('Y-m-d');
    }

    public static function getBaseUrl()
    {
        return url(config('system.storage.media.path'));
    }

    public static function generateRandomCode()
    {
        return str_pad(mt_rand(100000, 999999), 6, '0', STR_PAD_LEFT);
    }
}
