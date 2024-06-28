<?php

namespace App\Filament\App\Resources\ProfileSettingResource\Pages;

use App\Filament\App\Resources\ProfileSettingResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Filament\Facades\Filament;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\SessionGuard;
use Illuminate\Validation\Rule;
class EmailSetting extends EditRecord
{
    protected static string $resource = ProfileSettingResource::class;

    protected static ?string $navigationLabel = 'Emails/Notifications';

    protected static ?string $navigationGroup = 'Profile Setting';
    // protected static ?string $navigationLabel = 'Profile';

    protected string $userModel;

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
                Section::make()
                    ->schema([
                        TextInput::make('email')
                            ->required()
                            ->email()
                            ->maxLength(255)
                            ->rules([
                                Rule::unique($this->getUserModel())->ignore(auth()->user() ? auth()->user()->id : null),
                            ])
                            // ->unique($this->getUserModel())
                    ])

            ]);
    }
    protected function getUserModel(): string
    {
        if (isset($this->userModel)) {
            return $this->userModel;
        }

        /** @var SessionGuard $authGuard */
        $authGuard = Filament::auth();

        /** @var EloquentUserProvider $provider */
        $provider = $authGuard->getProvider();
        return $this->userModel = $provider->getModel();
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $user = Auth::user();

        if ($user->email !== $data['email']) {
            // Invalidate the old email verification
            $data['email_verified_at'] = null;
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $user = Auth::user();
        $newEmail = $user->email;
        $recipient = auth()->user();


        // if ($user->wasChanged('email')) {
        //     // Send email verification
        //     // $user->sendEmailVerificationNotification();
        // }
        redirect('admin/email-verification/prompt');
    }
}