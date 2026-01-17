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
     * @return mixed
     */
    public function update(int $id, array $data): mixed
    {
        $productDocument = $this->model->find($id);

        if ($productDocument) {
            if ($data['file']) {
                $productDocument->file = $data['file'];
            }

            $productDocument->name = $data['name'];
            $productDocument->product_id = (int) $data['product_id'];
            $productDocument->save();
        }
        return null;
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
}