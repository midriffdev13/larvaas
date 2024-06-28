<?php

namespace App\Filament\Admin\Resources\Authorization\Actions;

use App\Actions\Authorization\AttachPermission;
use App\Models\Authorization\Permission;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Validation\ValidationException;
use Closure;

class AttachPermissionsAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'Attach permission';
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
            Select::make('permissions')
                ->placeholder('Select permissions')
                ->searchable(['name', 'description'])
                ->options(fn ($livewire): array =>
                    Permission::whereNotIn('id', $livewire->ownerRecord->permissions->pluck('id'))
                        ->where('is_active', true)
                        ->pluck('name', 'id')
                        ->toArray()
                )
                ->getSearchResultsUsing(fn (string $search, $livewire): array => 
                    Permission::whereNotIn('id', $livewire->ownerRecord->permissions->pluck('id'))
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
        $handleData['permissions'] = Permission::find($data['permissions']);

        return $handleData;
    }

    private function submitAction(): Closure
    {
        return function (array $data, $livewire, $record) {

            $handleData = $this->prepareData($data, $livewire, $record);

            try {
                foreach ($handleData['permissions'] as $permission) {
                    $handleData['permission'] = $permission;
                    AttachPermission::run($handleData);
                }

                Notification::make()
                    ->title(__('Success'))
                    ->body(__('The permissions has been attached to the record.'))
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