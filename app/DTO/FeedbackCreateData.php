<?php

namespace App\DTO;

final class FeedbackCreateData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone,
        public readonly ?string $ip,
        public readonly string $message,
    )
    {
    }
}
