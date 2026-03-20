<?php

namespace App\DTO;

final class ArrayData implements DataTransferObjectInterface
{
    public function __construct(private readonly array $data)
    {
    }

    public static function from(array $data): self
    {
        return new self($data);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
