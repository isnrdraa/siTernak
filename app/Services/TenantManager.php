<?php

namespace App\Services;

use App\Models\Tenant;

class TenantManager
{
    private ?Tenant $tenant = null;

    public function set(Tenant $tenant): void
    {
        $this->tenant = $tenant;

        $this->setPermissionsTeamId($tenant->id);
    }

    public function get(): ?Tenant
    {
        return $this->tenant;
    }

    public function id(): ?int
    {
        return $this->tenant?->id;
    }

    public function clear(): void
    {
        $this->tenant = null;
    }

    /**
     * Sync Spatie Permission's team context with the current tenant.
     */
    private function setPermissionsTeamId(?int $tenantId): void
    {
        setPermissionsTeamId($tenantId);
    }
}
