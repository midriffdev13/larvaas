<?php
 
namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
 
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use App\Models\Authorization\Role;
use Illuminate\Database\Eloquent\Model;
use App\Actions\Teams\CreateTeam;

use App\Models\Users\User;
use Filament\Pages\Auth\Register as BaseRegister;
 
class Register extends BaseRegister
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getNameFormComponent(),
                TextInput::make('last_name')
                ->label('Last Name')
                ->required()
                ->maxLength(255),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
                // Select::make('role_id')
                // ->placeholder('Select a role')
                // ->searchable(['id', 'name'])
                // ->getSearchResultsUsing(
                //     fn (string $search): array => Role::where('name', 'like', "%{$search}%")
                //         ->limit(50)
                //         ->pluck('name', 'id')
                //         ->toArray()
                       
                // ),
            ]);
    }

    protected function handleRegistration(array $data): Model
    {
        // return $this->getUserModel()::create($data);
        $user = $this->getUserModel()::create($data); 
        $user->assignRole('1'); 
        $handleData = $this->prepareData($data,$user);
        CreateTeam::run($handleData);
        return $user; 
    }
    

    // Automated register team according to user 

    private function prepareData(array $data , $user): array
    {
        $handleData['name'] = $data['name'];
        $handleData['owner'] = User::find($user->id);

        return $handleData;
    }
}