<?php

namespace App\Filament\Admin\Resources\Authorization\PermissionResource\RelationManagers;

use App\Filament\Admin\Resources\Authorization\Actions\AttachTeamsAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\DetachBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TeamsRelationManager extends RelationManager
{
    protected static string $relationship = 'teams';

    protected static ?string $title = 'Teams';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
            ->headerActions([
                AttachTeamsAction::make()
                    ->hidden(fn () => ! auth()->user()->can('authorization.permission.team.attach')),
            ])
            ->actions([
                ActionGroup::make([
                    DetachAction::make()
                        ->hidden(fn () => ! auth()->user()->can('authorization.permission.team.detach')),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DetachBulkAction::make()
                        ->hidden(fn () => ! auth()->user()->can('authorization.permission.team.detach')),
                ]),
            ]);
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->authorizationType->slug === 'team' && auth()->user()->can('authorization.permission.team.view');
    }
}