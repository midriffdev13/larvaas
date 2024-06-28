<?php

namespace App\Actions\Teams;

use App\Mail\Teams\TeamInvitationMail;
use App\Models\Teams\TeamInvitation;
use App\Rules\Teams\TeamHasInvitationWithEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;

class SendInvitationEmail
{
    use AsAction;

    public function handle($data): void
    {
        $this->validate($data);

        $this->doAction($data);
    }

    private function doAction($data): void
    {
        $invitation = TeamInvitation::where('team_id', $data['team']->id)->where('email', $data['email'])->first();
        $mail = new TeamInvitationMail($invitation);

        Mail::to($invitation->email)->send($mail);
    }
    private function validate($data): void
    {
        $validator = Validator::make(
            [
                'email' => $data['email'],
                'team' => $data['team']->id,
            ],
            [
                'email' => [
                    'required',
                    'email',
                    new TeamHasInvitationWithEmail($data['team']),
                ],
                'team' => [
                    'exists:teams,id',
                ],
            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
