<?php

namespace App\Filament\App\Resources\ProfileSettingResource\Pages;

use App\Filament\App\Resources\ProfileSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Hash;
// use Filament\Actions\Action; // Corrected import statement
use Illuminate\Support\Facades\Password;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
// use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Actions\Action;
use Filament\Facades\Filament;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\SessionGuard;
use Filament\Infolists\Components\Tabs;

class PasswordSettings extends EditRecord
{
    protected static string $resource = ProfileSettingResource::class;

    protected static ?string $navigationLabel = 'Security';

    protected static ?string $navigationGroup = 'Profile Setting';
    // protected static ?string $navigationLabel = 'Profile';

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }


    public function form(Form $form): Form
    {
        return $form
        
            ->schema([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('password')
                                    ->label(__('filament-panels::pages/auth/register.form.password.label'))
                                    ->password()
                                    ->revealable(filament()->arePasswordsRevealable())
                                    ->required()
                                    // ->rule(Password::default())
                                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                                    ->same('passwordConfirmation')
                                    ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute')),
                                // TextInput::make('password')
                                //     ->password()
                                //     ->dehydrateStateUsing(fn($state) => Hash::make($state))
                                //     ->dehydrated(fn($state) => filled($state))
                                //     ->required(fn(string $context): bool => $context === 'create'),
                                TextInput::make('passwordConfirmation')
                                    ->label(__('filament-panels::pages/auth/register.form.password_confirmation.label'))
                                    ->password()
                                    ->revealable(filament()->arePasswordsRevealable())
                                    ->required()
                                    ->dehydrated(false)
                            ])->columns(2)
                    ])
                    ->columnSpan(['lg' => 2]),

            ])

            // ->columns(3)

        ;
    }
}