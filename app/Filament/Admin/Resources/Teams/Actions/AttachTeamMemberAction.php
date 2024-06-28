<?php

namespace App\Filament\Admin\Resources\Teams\Actions;

use App\Actions\Teams\AttachMember;
use App\Models\Users\User;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Validation\ValidationException;
use Closure;

class AttachTeamMemberAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'Attach member';
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
            Select::make('user')
                ->placeholder('Select a user')
                ->searchable(['name', 'email'])
                ->getSearchResultsUsing(fn (string $search, $livewire): array => 
                    User::whereNotIn('id', $livewire->ownerRecord->members->pluck('id'))
                        ->where(function($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        })
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
        $handleData['team'] = $livewire->ownerRecord;
        $handleData['user'] = User::find($data['user']);

        return $handleData;
    }

    private function submitAction(): Closure
    {
        return function (array $data, $livewire, $record) {

            $handleData = $this->prepareData($data, $livewire, $record);

            try {
                AttachMember::run($handleData);

                Notification::make()
                    ->title(__('Success'))
                    ->body(__('The user has been added to the team.'))
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