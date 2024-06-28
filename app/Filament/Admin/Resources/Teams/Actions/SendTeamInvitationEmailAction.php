<?php

namespace App\Filament\Admin\Resources\Teams\Actions;

use App\Actions\Teams\SendInvitationEmail;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Validation\ValidationException;
use Closure;

class SendTeamInvitationEmailAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'Send invitation';
    }

    public function action(Closure | string | null $action): static
    {
        if ($action !== 'submitAction') {
            throw new \Exception('You\'re unable to override the action.');
        }

        $this->action = $this->submitAction();

        return $this;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->action('submitAction')
            ->closeModalByClickingAway(true)
            ->icon('heroicon-o-envelope')
            ->modalWidth('md')
            ->modalAlignment('center')
            ->modalFooterActionsAlignment('right')
            ->requiresConfirmation();
    }

    private function prepareData(array $data, $livewire, $record): array
    {
        $handleData['team'] = $livewire->ownerRecord;
        $handleData['email'] = $record->email;

        return $handleData;
    }

    private function submitAction(): Closure
    {
        return function (array $data, $livewire, $record) {

            $handleData = $this->prepareData($data, $livewire, $record);

            try {
                SendInvitationEmail::run($handleData);

                Notification::make()
                    ->title(__('Success'))
                    ->body(__('Invitation sent to :email', ['email' => $handleData['email']]))
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