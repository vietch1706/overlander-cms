<?php

namespace Legato\Api\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use October\Rain\Support\Facades\Input;
use RainLab\Translate\Models\Locale;

class Lang
{
    public function handle(Request $request, Closure $next)
    {
        $defaultLang = Locale::getDefault()->code;
        $lang = Input::get('lang', $defaultLang);

        if (!Locale::isValid($lang)) {
            $lang = $defaultLang;
        }

        App::setlocale($lang);

        return $next($request);
    }
}
