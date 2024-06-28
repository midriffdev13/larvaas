<?php

namespace App\Filament\App\Resources\ProfileSettingResource\Pages;

use App\Filament\App\Resources\ProfileSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Auth;

use Filament\Forms\Components\FileUpload;
class EditProfileSetting extends EditRecord
{

    protected static string $resource = ProfileSettingResource::class;
    protected static ?string $navigationGroup = 'Profile Setting';

    protected static ?string $navigationLabel = 'Profile';

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }

    public  function form(Form $form): Form
    {
        $user = Auth::user();
        return $form
            ->schema([
                
                TextInput::make('name')
                    ->label('First Name')
                    // ->defaultValue($user->first_name) // Populate with user's first name
                    ->required()
                    ->maxLength(255),
                TextInput::make('last_name')
                    ->label('Last Name')
                    // ->defaultValue($user->last_name) // Populate with user's last name
                    ->required()
                    ->maxLength(255),
                FileUpload::make('profile_picture')
                    ->preserveFilenames()
                    ->label('Profile Picture')
                    ->avatar()
                // TextInput::make('email')
                //     ->label('Email')
                //     // ->defaultValue($user->email) // Populate with user's email
                //     ->disabled() // Disable editing email if you don't want to allow changes
                //     ->email()
                //     ->maxLength(255),
                // Add more fields as needed
            ]);
    }
}
