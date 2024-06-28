<?php

namespace App\Filament\Admin\Resources\Authorization\AuthorizationTypeResource\Pages;

use App\Filament\Admin\Resources\Authorization\AuthorizationTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ListAuthorizationTypes extends ListRecords
{
    protected static string $resource = AuthorizationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->hidden(fn () => ! auth()->user()->can('authorization.type.create')),
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
                        ->hidden(fn ($record) => $record->trashed() || ! auth()->user()->can('authorization.type.update')),
                    DeleteAction::make()
                        ->hidden(fn () => !auth()->user()->can('authorization.type.delete')),
                    RestoreAction::make()
                        ->hidden(fn () => !auth()->user()->can('authorization.type.restore')),
                    ForceDeleteAction::make()
                        ->hidden(fn () => !auth()->user()->can('authorization.type.delete.force')),
                ])
            ]);
    }
}
