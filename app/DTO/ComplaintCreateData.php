<?php

namespace App\DTO;

final class ComplaintCreateData
{
    public function __construct(
        public readonly int $type,
        public readonly int $orderId,
        public readonly int $productId,
        public readonly int $returnCount,
        public readonly int $customerId,
        public readonly ?string $blank,
    )
    {
    }
}
