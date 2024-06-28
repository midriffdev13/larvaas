<?php

namespace App\Filament\Admin\Resources\Users\UserResource\Pages;

use App\Filament\Admin\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;
// use Filament\Actions\Action; // Corrected import statement
use Illuminate\Support\Facades\Password;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
// use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Actions\Action;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->hidden(fn () => !auth()->user()->can('user.delete')),
        ];
    }

    // public function getFormActions(): array
    // {
    //     return [
    //         Action::make('sendPasswordResetEmail')
    //             ->label('Send Password Reset Email')
    //             ->color('primary')
    //             ->requiresConfirmation()
    //             ->action(fn() => $this->sendPasswordResetEmail())

    //     ];
    // }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Group::make()
                    ->schema([
                        Section::make()
                            ->id('profile')
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->required()
                                    ->email()
                                    ->maxLength(255),
                                // TextInput::make('password')
                                //     ->password()
                                //     ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                                //     ->dehydrated(fn ($state) => filled($state))
                                //     ->required(fn (string $context): bool => $context === 'create'),
                                TextInput::make('guard_name')
                                    ->maxLength(255),

                            ])
                            ->columns(2),
                        Section::make()
                            ->id('password')
                            ->footerActions([
                                Action::make('sendPasswordResetEmail')
                                    ->label('Send Password Reset Email')
                                    ->color('primary')
                                    ->requiresConfirmation()
                                    ->action(fn() => $this->sendPasswordResetEmail()),
                            ])
                            ->schema([

                                TextInput::make('password')
                                    ->password()
                                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                                    ->dehydrated(fn($state) => filled($state))
                                    ->required(fn(string $context): bool => $context === 'create'),

                            ])
                            ->columns(2),
                        Section::make()
                            ->schema([
                                TextInput::make('address_1')
                                    ->maxLength(255),
                                TextInput::make('address_2')
                                    ->maxLength(255),
                                TextInput::make('country')
                                    ->maxLength(255),
                                TextInput::make('state')
                                    ->maxLength(255),
                                TextInput::make('city')
                                    ->maxLength(255),
                                TextInput::make('zip')
                                    ->maxLength(255),
                                TextInput::make('phone')
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
                                    ->content(fn($record): ?string => $record->created_at?->diffForHumans()),
                                Placeholder::make('updated_at')
                                    ->label('Last modified at')
                                    ->content(fn($record): ?string => $record->updated_at?->diffForHumans()),
                            ])
                    ])
                    ->columnSpan(['lg' => 1]),

            ])

            ->columns(3)

        ;
    }


    public function sendPasswordResetEmail()
    {
        $user = $this->record;

        $status = Password::sendResetLink(['email' => $user->email]);
        // Revoke all tokens except the current one
        $user->tokens()->where('id', '<>', Auth::id())->delete();
        if ($status == Password::RESET_LINK_SENT) {
            Notification::make()
                ->title('Success')
                ->body('Password reset email sent successfully.')
                ->success()
                ->send()
                ->sendToDatabase($user);
        } else {
            Notification::make()
                ->title('Error')
                ->body('Failed to send password reset email.')
                ->danger()
                ->send();
        }
    }

}
