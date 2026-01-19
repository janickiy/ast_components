<?php

namespace App\Contracts;

use App\DTO\Complaints\RequestsCreateData;
use App\Models\Requests;

interface RequestsRepositoryInterface
{
    public function create(RequestsCreateData $data): Requests;
}
