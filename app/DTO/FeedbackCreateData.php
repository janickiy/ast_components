<?php

namespace App\DTO;

final class FeedbackCreateData implements DataTransferObjectInterface
{
    public function __construct(
        public readonly string  $name,
        public readonly string  $email,
        public readonly string  $phone,
        public readonly ?string $ip,
        public readonly string  $message,
    )
    {
    }


    public function toArray(): array
    {
        return get_object_vars($this);
    }

}
