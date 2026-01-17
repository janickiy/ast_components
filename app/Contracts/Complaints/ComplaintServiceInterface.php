<?php

namespace App\Contracts\Complaints;

use App\DTO\Complaints\ComplaintCreateData;
use App\Models\Complaints;

interface ComplaintServiceInterface
{
    public function create(ComplaintCreateData $data): Complaints;
}
