<?php

namespace App\Filament\App\Resources\EditResource\Pages;

use App\Filament\App\Resources\EditResource;
use Filament\Resources\Pages\Page;

// class EditProfile extends Page
// {
//     protected static string $resource = EditResource::class;

//     protected static string $view = 'filament.app.resources.edit-resource.pages.edit-profile';
// }

use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
 
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;

    // public ?array $data = []; 
    protected static ?string $model = User::class;

 
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
 
    protected static string $view = 'filament.pages.edit-company';
 
    public function mount(): void 
    {
        $this->form->fill();
    }
 
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
            ])
            ->statePath('data');
    } 
}