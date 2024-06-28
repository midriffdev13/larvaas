<?php

namespace App\Filament\Admin\Resources\Authorization\PermissionResource\RelationManagers;

use App\Filament\Admin\Resources\Authorization\Actions\AttachRolesAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\DetachBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class RolesRelationManager extends RelationManager
{
    protected static string $relationship = 'roles';

    protected static ?string $title = 'Roles';

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
                AttachRolesAction::make()
                    ->hidden(fn () => ! auth()->user()->can('authorization.permission.role.attach')),
            ])
            ->actions([
                ActionGroup::make([
                    DetachAction::make()
                        ->hidden(fn () => ! auth()->user()->can('authorization.permission.role.detach')),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DetachBulkAction::make()
                        ->hidden(fn () => ! auth()->user()->can('authorization.permission.role.detach')),
                ]),
            ]);
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return auth()->user()->can('authorization.permission.role.view');
    }
}