<?php

namespace App\Repositories;

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
    public function updateWithMapping(int $id, array $data): bool
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

    private function mapping(array $data): array
    {
        return collect($data)
            ->when(!isset($data['file']), function ($collection) {
                return $collection->forget('file');
            })
            ->only($this->model->getFillable())
            ->mapWithKeys(function ($value, $key) {
                if ($key === 'product_id' && !is_null($value)) {
                    return (int)$value;
                }

                return $value;
            })
            ->toArray();
    }
}