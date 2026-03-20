<?php

namespace App\DTO;

final class InvitesCreateData implements DataTransferObjectInterface
{
    public function __construct(
        public readonly string  $name,
        public readonly string  $company,
        public readonly string  $email,
        public readonly string  $phone,
        public readonly ?string $message,
        public readonly ?string $ip,
        public readonly string  $numb,
        public readonly string  $platform,
    )
    {
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

}
