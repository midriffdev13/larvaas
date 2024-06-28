<?php

namespace App\Filament\Admin\Resources\Authorization;

use App\Filament\Admin\Resources\Authorization\RoleResource\Pages;
use App\Filament\Admin\Resources\Authorization\RoleResource\RelationManagers;
use App\Models\Authorization\Role;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationGroup = 'Authorization';

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Permissions' => $record->permissions->count(),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PermissionsRelationManager::class,
            RelationManagers\TeamMembersRelationManager::class,
            RelationManagers\TeamsRelationManager::class,
            RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
