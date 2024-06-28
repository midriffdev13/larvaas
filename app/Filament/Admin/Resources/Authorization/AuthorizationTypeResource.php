<?php

namespace App\Filament\Admin\Resources\Authorization;

use App\Filament\Admin\Resources\Authorization\AuthorizationTypeResource\Pages;
use App\Filament\Admin\Resources\Authorization\AuthorizationTypeResource\RelationManagers;
use App\Models\Authorization\AuthorizationType;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AuthorizationTypeResource extends Resource
{
    protected static ?string $model = AuthorizationType::class;

    protected static ?string $navigationGroup = 'Authorization';
    
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Permissions' => $record->permissions->count(),
            'Roles' => $record->roles->count(),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuthorizationTypes::route('/'),
            'create' => Pages\CreateAuthorizationType::route('/create'),
            'edit' => Pages\EditAuthorizationType::route('/{record}/edit'),
        ];
    }
}
