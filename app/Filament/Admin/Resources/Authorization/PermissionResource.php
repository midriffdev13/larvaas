<?php

namespace App\Filament\Admin\Resources\Authorization;

use App\Filament\Admin\Resources\Authorization\PermissionResource\Pages;
use App\Filament\Admin\Resources\Authorization\PermissionResource\RelationManagers;
use App\Models\Authorization\Permission;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    protected static ?string $navigationGroup = 'Authorization';

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Roles' => $record->roles->count(),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\RolesRelationManager::class,
            RelationManagers\TeamMembersRelationManager::class,
            RelationManagers\TeamsRelationManager::class,
            RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            'edit' => Pages\EditPermission::route('/{record}/edit'),
        ];
    }
}
