<?php

namespace App\Filament\Admin\Resources\Teams\Actions;

use App\Actions\Teams\CreateInvitation;
use App\Actions\Teams\SendInvitationEmail;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Validation\ValidationException;
use Closure;

class CreateTeamInvitationAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'New Invitation';
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
            TextInput::make('email')
                ->required()
                ->email(),
            Checkbox::make('send_invitation_email')

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
        $handleData['email'] = $data['email'];
        $handleData['send_invitation_email'] = $data['send_invitation_email'] ?? false;
        $handleData['team'] = $livewire->ownerRecord;

        return $handleData;
    }

    private function submitAction(): Closure
    {
        return function (array $data, $livewire, $record) {

            $handleData = $this->prepareData($data, $livewire, $record);

            try {
                CreateInvitation::run($handleData);

                if ($data['send_invitation_email']) {
                    SendInvitationEmail::run($handleData);

                    Notification::make()
                        ->title(__('Success'))
                        ->body(__('The invitation has been created and sent.'))
                        ->success()
                        ->send();
                } else {
                    Notification::make()
                        ->title(__('Success'))
                        ->body(__('The invitation has been created.'))
                        ->success()
                        ->send();
                }
                    
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