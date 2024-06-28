<?php

namespace App\Actions\Authorization;

use App\Rules\Authorization\RoleIsActive;
use App\Rules\Authorization\UniqueRole;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;

class AttachRole
{
    use AsAction;

    public function handle($data): void
    {
        $this->validate($data);

        $this->doAction($data);
    }

    private function doAction($data): void
    {
        $data['model']->roles()->attach($data['role']);
    }

    private function validate($data): void
    {
        $validator = Validator::make(
            [
                'model' => $data['model']->id,
                'role' => $data['role']->id,
            ],
            [
                'model' => [
                    'exists:' . $data['model']->getTable() . ',id',
                ],
                'role' => [
                    'exists:roles,id',
                    new RoleIsActive(),
                    new UniqueRole($data['model']),
                ],
            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}