<?php

namespace Overlander\General\Helper;

class General
{

  public static function getBaseUrl()
  {
    return url(config('system.storage.media.path'));
  }
}
