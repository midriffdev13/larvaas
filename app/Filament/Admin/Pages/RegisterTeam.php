<?php

namespace App\Filament\Admin\Pages;

use App\Actions\Teams\CreateTeam;
use Filament\Pages\Tenancy\RegisterTenant;

use App\Models\Users\User;
use App\Models\Teams\Team;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Illuminate\Validation\ValidationException;
use Filament\Forms\Form;
use Illuminate\Support\Js;

use Closure;


class RegisterTeam extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'New Team';
    }

    public function getFormActions(): array
    {
        return [
            $this->getRegisterFormAction(),
        ];
    }

    public function getRegisterFormAction(): Action
    {
        return Action::make('register')
            ->label(static::getLabel())
            ->submit('register');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('owner')
                    ->placeholder('Select a user')
                    ->searchable(['name', 'email'])
                    ->getSearchResultsUsing(
                        fn(string $search): array => User::where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->limit(50)
                            ->pluck('name', 'id')
                            ->toArray()
                    )
                    ->required()
            ]);
    }

    protected function handleRegistration(array $data): Team
    {
        $handleData = $this->prepareData($data);

        try {
            $team = CreateTeam::run($handleData);
            Notification::make()
                ->title(__('Success'))
                ->body(__('Team created successfully!'))
                ->success()
                ->send();

            return $team;
        } catch (ValidationException $e) {
            foreach ($e->errors() as $error) {
                foreach ($error as $message) {
                    Notification::make()
                        ->title(__('Error'))
                        ->body($message)
                        ->danger()
                        ->send();
                }
            }

            throw ValidationException::withMessages($e->errors());
        }
    }

    private function prepareData(array $data): array
    {
        $handleData['name'] = $data['name'];
        $handleData['owner'] = User::find($data['owner']);

        return $handleData;
    }

}