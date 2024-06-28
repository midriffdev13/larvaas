<?php

namespace App\Filament\Admin\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Illuminate\Support\Facades\Auth;
class EditProfile extends BaseEditProfile
{


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getNameFormComponent()
                    ->label('First Name'),
                TextInput::make('last_name')
                    ->label('Last Name')
                    ->required()
                    ->maxLength(255),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);

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