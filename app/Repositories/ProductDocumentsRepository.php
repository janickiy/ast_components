<?php

namespace App\Repositories;

use App\DTO\DataTransferObjectInterface;
use App\Models\ProductDocuments;

class ProductDocumentsRepository extends BaseRepository
{
    public function __construct(ProductDocuments $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateWithMapping(int $id, array|DataTransferObjectInterface $data): bool
    {
        return $this->update($id, $this->mapping($data));
    }

    /**
     * @param int $id
     * @return void
     */
    public function remove(int $id): void
    {
        $manufacturer = $this->find($id);

        if ($manufacturer) {
            $manufacturer->remove();
        }
    }

    private function mapping(array|DataTransferObjectInterface $data): array
    {
        $data = $this->normalizeData($data);
        return collect($data)
            ->when(!isset($data['file']), function ($collection) {
                return $collection->forget('file');
            })
            ->only($this->model->getFillable())
            ->map(function ($value, $key) {
                if ($key === 'product_id' && !is_null($value)) {
                    return (int)$value;
                }

                return $value;
            })
            ->all();
    }
}