<?php

namespace App\Filament\Admin\Resources\Authorization\AuthorizationTypeResource\Pages;

use App\Filament\Admin\Resources\Authorization\AuthorizationTypeResource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateAuthorizationType extends CreateRecord
{
    protected static string $resource = AuthorizationTypeResource::class;

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
                            ])
                            ->columns(2),
                        ])
                    ->columnSpan(['lg' => 2]),
            ])
            ->columns(3);
    }
}
