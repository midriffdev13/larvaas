<?php

namespace App\Filament\Admin\Resources\Authorization\PermissionResource\Pages;

use App\Filament\Admin\Resources\Authorization\PermissionResource;
use App\Models\Authorization\AuthorizationType;
use App\Models\Teams\Team;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;

class CreatePermission extends CreateRecord
{
    protected static string $resource = PermissionResource::class;

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
                                TextInput::make('description')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('int_value')
                                    ->label('Value')
                                    ->numeric(),
                                Select::make('authorization_type_id')
                                    ->label('Authorizable Type')
                                    ->searchable(['name'])
                                    ->relationship(name: 'authorizationType', titleAttribute: 'name')
                                    ->options(
                                        AuthorizationType::all()
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
                                    ->helperText('To which team does this permission belong?')
                                    ->searchable(['name'])
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
            ])
            ->columns(3);
    }
}
