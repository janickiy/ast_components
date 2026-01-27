<?php

namespace App\Repositories;

use App\DTO\InvitesCreateData;
use App\Models\Invites;

class InvitesRepository extends BaseRepository
{
    public function __construct(Invites $model)
    {
        parent::__construct($model);
    }

    /**
     * @param InvitesCreateData $data
     * @return Invites
     */
    public function add(InvitesCreateData $data): Invites
    {
        return Invites::query()->create([
            'name' => $data->name,
            'company' => $data->company,
            'email' => $data->email,
            'phone' => $data->phone,
            'message' => $data?->message,
            'ip' => $data->ip,
            'numb' => $data->numb,
            'platform' => $data->platform
        ]);
    }
}
