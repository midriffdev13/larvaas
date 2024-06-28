<?php

namespace App\Actions\Authorization;

use App\Rules\Authorization\PermissionIsActive;
use App\Rules\Authorization\UniquePermission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;

class AttachPermission
{
    use AsAction;

    public function handle($data): void
    {
        $this->validate($data);

        $this->doAction($data);
    }

    private function doAction($data): void
    {
        $data['model']->permissions()->attach($data['permission']);
    }

    private function validate($data): void
    {
        $validator = Validator::make(
            [
                'model' => $data['model']->id,
                'permission' => $data['permission']->id,
            ],
            [
                'model' => [
                    'exists:' . $data['model']->getTable() . ',id',
                ],
                'permission' => [
                    'exists:permissions,id',
                    new PermissionIsActive(),
                    new UniquePermission($data['model']),
                ],
            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}