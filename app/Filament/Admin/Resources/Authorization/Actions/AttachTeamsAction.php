<?php

namespace App\Filament\Admin\Resources\Authorization\Actions;

use App\Actions\Teams\AttachTeam;
use App\Models\Teams\Team;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Validation\ValidationException;
use Closure;

class AttachTeamsAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'Attach team';
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
            Select::make('teams')
                ->placeholder('Select teams')
                ->searchable(['name'])
                ->getSearchResultsUsing(fn (string $search, $livewire): array => 
                    Team::whereNotIn('id', $livewire->ownerRecord->teams->pluck('id'))
                        ->where(function($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        })
                        ->pluck('name', 'id')
                        ->toArray()
                )
                ->multiple()
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
        $handleData['model'] = $livewire->ownerRecord;
        $handleData['teams'] = Team::find($data['teams']);

        return $handleData;
    }

    private function submitAction(): Closure
    {
        return function (array $data, $livewire, $record) {

            $handleData = $this->prepareData($data, $livewire, $record);

            try {
                foreach ($handleData['teams'] as $team) {
                    $handleData['team'] = $team;
                    AttachTeam::run($handleData);
                }

                Notification::make()
                    ->title(__('Success'))
                    ->body(__('Team(s) attached successfully.'))
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