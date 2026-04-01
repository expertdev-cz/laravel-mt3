<?php

namespace App\Http\Middleware;

use App\Models\System\Language;
use App\Services\System\UrlService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguageSetter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $uriArr = explode('/',$request->getRequestUri());

        if (isset($uriArr[1])){
            if(in_array($uriArr[1],Language::getAllowedLanguageLocale())){
                app()->setLocale($uriArr[1]);
            }else{
                app()->setLocale(UrlService::defaultLang());
            }

            return $next($request);
        }

        $selLang = $request->session()->get('setLang');

        if ($selLang){
            app()->setLocale($selLang);
        }else{
            app()->setLocale(config('app.locale'));
        }

        return $next($request);
    }
}
