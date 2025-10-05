<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class SetLanguage
{
    public function handle(Request $request, Closure $next): Response
    {


       App::setLocale(getLangauge());

        return $next($request);

    }
    }
