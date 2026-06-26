<?php

namespace App\Support;

use Illuminate\Http\Request;

class ApiOperator
{
    public static function enabled(): bool
    {
        return (bool) config('api_operator.enabled');
    }

    public static function visibleOnRequest(?Request $request = null): bool
    {
        if (! self::enabled() || ! auth()->check()) {
            return false;
        }

        $request ??= request();
        $host = $request->getHost();
        $central = (string) config('app.central_domain');

        if (in_array($host, [$central, 'localhost', '127.0.0.1'], true)) {
            return true;
        }

        // demo.laravel-tenant-kit.test → hide; central root host → show
        if (str_ends_with($host, '.'.$central)) {
            return false;
        }

        return true;
    }
}
