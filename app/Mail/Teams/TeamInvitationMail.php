<?php

namespace App\Mail\Teams;

use App\Models\Teams\TeamInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamInvitationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(protected TeamInvitation $invitation)
    {
        $this->afterCommit();
    }

    public function build()
    {
        $subject = 'You\'re Invited to "' . $this->invitation->team->name . '"';
        
        return $this
            ->from(env('MAIL_FROM_ADDRESS', 'project@larvaas.com'), env('MAIL_FROM_NAME', 'Example'))
            ->to($this->invitation->email)
            ->subject($subject)
            ->markdown('mail.teams.team_invitation')
            ->with([
                'subject' => $subject,
                'teamName' => $this->invitation->team->name,
            ]);
    }
}
