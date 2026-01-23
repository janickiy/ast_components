<?php

namespace App\DTO;

final class InvitesCreateData
{
    public function __construct(
        public readonly string $name,
        public readonly string $company,
        public readonly string $email,
        public readonly string $phone,
        public readonly ?string $message,
        public readonly ?string $ip,
        public readonly string $numb,
        public readonly string $platform,
    )
    {
    }
}
