<?php

namespace App\Actions\Teams;

use App\Rules\Teams\UniqueTeam;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;

class AttachTeam
{
    use AsAction;

    public function handle($data): void
    {
        $this->validate($data);

        $this->doAction($data);
    }

    private function doAction($data): void
    {
        $data['model']->teams()->attach($data['team']);
    }

    private function validate($data): void
    {
        $validator = Validator::make(
            [
                'team' => $data['team']->id,
                'model' => $data['model']->id,
            ],
            [
                'model' => [
                    'exists:' . $data['model']->getTable() . ',id',
                ],
                'team' => [
                    'exists:teams,id',
                    new UniqueTeam($data['model']),
                ],
            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}