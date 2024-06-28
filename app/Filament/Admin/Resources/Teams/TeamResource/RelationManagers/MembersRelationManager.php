<?php

namespace App\Filament\Admin\Resources\Teams\TeamResource\RelationManagers;

use App\Filament\Admin\Resources\Teams\Actions\AttachTeamMemberAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\DetachBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    protected static ?string $title = 'Members';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
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
                AttachTeamMemberAction::make()
                    ->hidden(fn () => ! auth()->user()->can('team.member.attach')),
            ])
            ->actions([
                ActionGroup::make([
                    DetachAction::make()
                        ->hidden(fn () => ! auth()->user()->can('team.member.detach')),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DetachBulkAction::make()
                        ->hidden(fn () => ! auth()->user()->can('team.member.detach')),
                ]),
            ]);
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return auth()->user()->can('team.member.view');
    }
}
