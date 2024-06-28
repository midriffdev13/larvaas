<?php

namespace App\Filament\Admin\Resources\Authorization\Actions;

use App\Actions\Users\AttachUser;
use App\Models\Users\User;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Validation\ValidationException;
use Closure;

class AttachUsersAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'Attach user';
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
            Select::make('users')
                ->placeholder('Select users')
                ->searchable(['name', 'email'])
                ->getSearchResultsUsing(fn (string $search, $livewire): array => 
                    User::whereNotIn('id', $livewire->ownerRecord->users->pluck('id'))
                        ->where(function($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
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
        $handleData['users'] = User::find($data['users']);

        return $handleData;
    }

    private function submitAction(): Closure
    {
        return function (array $data, $livewire, $record) {

            $handleData = $this->prepareData($data, $livewire, $record);

            try {
                foreach ($handleData['users'] as $user) {
                    $handleData['user'] = $user;
                    AttachUser::run($handleData);
                }

                Notification::make()
                    ->title(__('Success'))
                    ->body(__('The user(s) has been attached.'))
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