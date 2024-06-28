@component('mail::message')

<h1>You have been invited to join {{ $teamName }}.</h1>
<br>

@component('mail::button', ['url' => route('user.teams.invitations')])
View Invitation
@endcomponent

<br>

<h3>What happens when I join a team?</h3>
You will have access to all the projects of that team. If you do not recognize this team, please ignore and delete this email.

<br>
<br>

{{ config('app.name') }}

@endcomponent
