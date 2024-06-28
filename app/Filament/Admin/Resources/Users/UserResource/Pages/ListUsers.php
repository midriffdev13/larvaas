<?php

namespace App\Filament\Admin\Resources\Users\UserResource\Pages;

use App\Filament\Admin\Resources\Users\UserResource;
//use App\Filament\Admin\Resources\Users\Actions\CreateUserAction;
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

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateUserAction::make()
            //     ->hidden(fn () => ! auth()->user()->can('user.create')),
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
                    ->sortable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('email')
                    ->sortable()
                    ->toggleable(),
                    TextColumn::make('email_verified_at')
                    ->label('Email Verified')
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->hidden(fn ($record) => $record->trashed() || ! auth()->user()->can('user.update')),
                    DeleteAction::make()
                        ->hidden(fn () => !auth()->user()->can('user.delete')),
                    RestoreAction::make()
                        ->hidden(fn () => !auth()->user()->can('user.restore')),
                    ForceDeleteAction::make()
                        ->hidden(fn () => !auth()->user()->can('user.delete.force')),
                ]),
            ]);
    }
}
