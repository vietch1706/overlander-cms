<?php

namespace Legato\Api\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use October\Rain\Support\Facades\Input;
use RainLab\Translate\Models\Locale;

class LangOverride
{
    const LANG = 'en';

    public function handle(Request $request, Closure $next)
    {
        $defaultLang = Locale::getDefault()->code;
        $lang = Input::get('lang', $defaultLang);

        if ($lang === $defaultLang && $defaultLang !== self::LANG) {
            App::setlocale(self::LANG);
        }

        return $next($request);
    }
}
