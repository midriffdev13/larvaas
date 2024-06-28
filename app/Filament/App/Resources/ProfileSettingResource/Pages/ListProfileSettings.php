<?php

namespace App\Filament\App\Resources\ProfileSettingResource\Pages;

use App\Filament\App\Resources\ProfileSettingResource;
use Filament\Resources\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Support\Exceptions\Halt;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\FileUpload;
use App\Models\Users\User;
use Filament\Notifications\Notification;
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

use Filament\Actions;
// use Filament\Resources\Pages\ListRecords;

class ListProfileSettings extends ListRecords
{
    protected static string $resource = ProfileSettingResource::class;

    // protected static string $resource = TeamResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         CreateTeamAction::make()
    //             ->hidden(fn () => ! auth()->user()->can('team.create')),
    //     ];
    // }



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
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                // TextColumn::make('guard_name')
                //     ->label('Guard')
                //     ->sortable()
                //     ->toggleable()
                //     ->toggledHiddenByDefault(),
                // TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable()
                //     ->toggledHiddenByDefault(),
                // TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable()
                //     ->toggledHiddenByDefault(),
                // TextColumn::make('members_count')
                //     ->label('Members')
                //     ->sortable()
                //     ->counts('members')
                //     ->badge(),
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
