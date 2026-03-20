<?php

namespace App\DTO;

final class RequestsCreateData implements DataTransferObjectInterface
{
    public function __construct(
        public readonly string  $name,
        public readonly string  $company,
        public readonly string  $email,
        public readonly string  $phone,
        public readonly ?string $message,
        public readonly string  $nomenclature,
        public readonly int     $count,
        public readonly int     $unit,
        public readonly ?string $attach,
        public readonly ?string $ip,
        public readonly ?int    $customerId,
    )
    {
    }


    public function toArray(): array
    {
        return get_object_vars($this);
    }

}
