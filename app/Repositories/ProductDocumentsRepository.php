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
    public function update(int $id, array $data): ?ProductDocuments
    {
        $model = $this->model->find($id);

        if ($model) {
            if ($data['file']) {
                $model->file = $data['file'];
            }

            $model->name = $data['name'];
            $model->product_id = (int) $data['product_id'];
            $model->save();

            return $model;
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