<?php

namespace App\Filament\Admin\Resources\Teams\Actions;

use App\Actions\Teams\CreateTeam;
use App\Models\Users\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Illuminate\Validation\ValidationException;
use Closure;

class CreateTeamAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'New team';
    }

    public function action(Closure | string | null $action): static
    {
        if ($action !== 'submitAction') {
            throw new \Exception('You\'re unable to override the action.');
        }

        $this->action = $this->submitAction();

        return $this;
    }

    protected function getDefaultForm(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            Select::make('owner')
                ->placeholder('Select a user')
                ->searchable(['name', 'email'])
                ->getSearchResultsUsing(
                    fn (string $search): array => User::where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->limit(50)
                        ->pluck('name', 'id')
                        ->toArray()
                )
                ->required()
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->action('submitAction')
            ->closeModalByClickingAway(true)
            ->form($this->getDefaultForm())
            ->modalFooterActionsAlignment('right')
            ->modalWidth('md');
    }

    private function prepareData(array $data, $livewire, $record): array
    {
        $handleData['name'] = $data['name'];
        $handleData['owner'] = User::find($data['owner']);

        return $handleData;
    }

    private function submitAction(): Closure
    {
        return function (array $data, $livewire, $record) {

            $handleData = $this->prepareData($data, $livewire, $record);

            try {
                CreateTeam::run($handleData);

                Notification::make()
                    ->title(__('Success'))
                    ->body(__('Team created successfully!'))
                    ->success()
                    ->send();
                    
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
        };
    }
}