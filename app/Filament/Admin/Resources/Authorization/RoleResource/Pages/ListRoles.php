<?php

namespace App\Filament\Admin\Resources\Authorization\RoleResource\Pages;

use App\Filament\Admin\Resources\Authorization\RoleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ListRoles extends ListRecords
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->hidden(fn () => ! auth()->user()->can('authorization.role.create')),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->withTrashed()),
            'active' => Tab::make(),
            'inactive' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->onlyTrashed()),
        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'active';
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('authorizationType.name')
                    ->label('Type')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('team.name')
                    ->label('Team')
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->boolean(),
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
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->hidden(fn ($record) => $record->trashed() || ! auth()->user()->can('authorization.role.update')),
                    DeleteAction::make()
                        ->hidden(fn () => !auth()->user()->can('authorization.role.delete')),
                    RestoreAction::make()
                        ->hidden(fn () => !auth()->user()->can('authorization.role.restore')),
                    ForceDeleteAction::make()
                        ->hidden(fn () => !auth()->user()->can('authorization.role.delete.force')),
                ])
            ]);
    }
}
