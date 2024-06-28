<?php

namespace App\Filament\Admin\Resources\Authorization\RoleResource\Pages;

use App\Filament\Admin\Resources\Authorization\RoleResource;
use App\Models\Authorization\AuthorizationType;
use App\Models\Teams\Team;
use Filament\Actions;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->hidden(fn () => ! auth()->user()->can('authorization.role.delete')),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('slug')
                                    ->disabled()
                                    ->maxLength(255),
                                TextInput::make('description')
                                    ->required()
                                    ->maxLength(255),
                                Select::make('authorization_type_id')
                                        ->label('Authorizable Type')
                                        ->searchable(['name'])
                                        ->required()
                                        ->relationship(name: 'authorizationType', titleAttribute: 'name')
                                        ->options(fn ($record) => 
                                            AuthorizationType::whereNot('id', $record->authorizable_type_id)
                                                ->pluck('name', 'id')
                                                ->toArray()
                                            
                                        )
                                        ->getSearchResultsUsing(fn (string $search): array => 
                                            AuthorizationType::where(function($query) use ($search) {
                                                    $query->where('name', 'like', "%{$search}%");
                                                })
                                                ->pluck('name', 'id')
                                                ->toArray()
                                        ),
                                Select::make('team_id')
                                        ->label('Team')
                                        ->helperText('To which team does this role belong?')
                                        ->searchable(['name'])
                                        ->relationship(name: 'team', titleAttribute: 'name')
                                        ->getSearchResultsUsing(fn (string $search, $livewire): array => 
                                            Team::where(function($query) use ($search) {
                                                    $query->where('name', 'like', "%{$search}%");
                                                })
                                                ->pluck('name', 'id')
                                                ->toArray()
                                        ),
                            ])
                            ->columns(2),
                        ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                Placeholder::make('created_at')
                                    ->label('Created at')
                                    ->content(fn ($record): ?string => $record->created_at?->diffForHumans()),
                                Placeholder::make('updated_at')
                                    ->label('Last modified at')
                                    ->content(fn ($record): ?string => $record->updated_at?->diffForHumans()),
                            ])
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }
}
