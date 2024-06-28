<?php

namespace App\Traits\Users;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

trait UserFilament
{
    public function canAccessPanel(Panel $panel): bool
    {
        switch ($panel->getId()) {
            case 'admin':
                return $this->can('admin.panel.view');
            case 'app':
                return $this->can('app.panel.view');
            case 'profile':
                return $this->can('profile.panel.view');
            default:
                return false;
        }
    }
}