<?php

namespace Overlander\General\Helper;

use Carbon\Carbon;

class General
{

  public static function getCurrentDay()
  {
    return Carbon::now()->format('Y-m-d');
  }
  public static function getBaseUrl()
  {
    return url(config('system.storage.media.path'));
  }
}
