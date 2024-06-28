<?php

namespace App\Filament\Admin\Resources\Teams\TeamResource\Pages;

use App\Filament\Admin\Resources\Teams\TeamResource;
use App\Filament\Admin\Resources\Teams\Actions\CreateTeamAction;
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

class ListTeams extends ListRecords
{
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateTeamAction::make()
                ->hidden(fn () => ! auth()->user()->can('team.create')),
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
                TextColumn::make('guard_name')
                    ->label('Guard')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
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
                TextColumn::make('members_count')
                    ->label('Members')
                    ->sortable()
                    ->counts('members')
                    ->badge(),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->hidden(fn ($record) => $record->trashed() || ! auth()->user()->can('team.update')),
                    DeleteAction::make()
                        ->hidden(fn () => !auth()->user()->can('team.delete')),
                    RestoreAction::make()
                        ->hidden(fn () => !auth()->user()->can('team.restore')),
                    ForceDeleteAction::make()
                        ->hidden(fn () => !auth()->user()->can('team.delete.force')),
                ]),
            ]);
    }
}
