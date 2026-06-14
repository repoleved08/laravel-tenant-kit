<?php

namespace App\Support;

use App\Models\Tenant;
use App\Services\UsageMeter;

class UsagePresenter
{
    /**
     * @return array<string, mixed>
     */
    public static function forTenant(Tenant $tenant): array
    {
        return app(UsageMeter::class)->summarize($tenant);
    }
}
