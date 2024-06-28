<?php

namespace App\Filament\Admin\Resources\Teams\TeamResource\RelationManagers;

use App\Filament\Admin\Resources\Teams\Actions\CreateTeamInvitationAction;
use App\Filament\Admin\Resources\Teams\Actions\SendTeamInvitationEmailAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class InvitationsRelationManager extends RelationManager
{
    protected static string $relationship = 'invitations';

    protected static ?string $title = 'Invitations';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
            ->headerActions([
                CreateTeamInvitationAction::make()
                    ->hidden(fn () => ! auth()->user()->can('team.invitation.create')),
            ])
            ->actions([
                ActionGroup::make([
                    SendTeamInvitationEmailAction::make()
                        ->hidden(fn () => ! auth()->user()->can('team.invitation.send')),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->hidden(fn () => ! auth()->user()->can('team.invitation.delete')),
                ]),
            ]);
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return auth()->user()->can('team.invitations.view');
    }
}
