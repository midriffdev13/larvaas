<?php

namespace App\Filament\Admin\Resources\Teams;

use App\Filament\Admin\Resources\Teams\TeamResource\Pages;
use App\Filament\Admin\Resources\Teams\TeamResource\RelationManagers;
use App\Models\Teams\Team;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    
    protected static ?string $navigationGroup = 'Users';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Members' => $record->members->count(),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeams::route('/'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\MembersRelationManager::class,
            RelationManagers\InvitationsRelationManager::class,
        ];
    }
}