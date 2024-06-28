<?php

namespace App\Filament\Admin\Resources\Authorization\AuthorizationTypeResource\Pages;

use App\Filament\Admin\Resources\Authorization\AuthorizationTypeResource;
use Filament\Actions;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditAuthorizationType extends EditRecord
{
    protected static string $resource = AuthorizationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->hidden(fn () => ! auth()->user()->can('authorization.type.delete')),
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
