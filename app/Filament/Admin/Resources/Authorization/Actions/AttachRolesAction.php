<?php

namespace App\Filament\Admin\Resources\Authorization\Actions;

use App\Actions\Authorization\AttachRole;
use App\Models\Authorization\Role;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Validation\ValidationException;
use Closure;

class AttachRolesAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'Attach role';
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
            Select::make('roles')
                ->placeholder('Select roles')
                ->searchable(['name', 'description'])
                ->options(fn ($livewire): array =>
                    Role::whereNotIn('id', $livewire->ownerRecord->roles->pluck('id'))
                        ->where('is_active', true)
                        ->pluck('name', 'id')
                        ->toArray()
                )
                ->getSearchResultsUsing(fn (string $search, $livewire): array => 
                    Role::whereNotIn('id', $livewire->ownerRecord->roles->pluck('id'))
                        ->where(function($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('description', 'like', "%{$search}%");
                        })
                        ->where('is_active', true)
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
        $handleData['roles'] = Role::find($data['roles']);

        return $handleData;
    }

    private function submitAction(): Closure
    {
        return function (array $data, $livewire, $record) {

            $handleData = $this->prepareData($data, $livewire, $record);

            try {
                foreach ($handleData['roles'] as $role) {
                    $handleData['role'] = $role;
                    AttachRole::run($handleData);
                }

                Notification::make()
                    ->title(__('Success'))
                    ->body(__('The roles has been attached to the record.'))
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