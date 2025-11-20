<?php

namespace App\Repositories;

use App\Models\ProductParameters;

class ProductParametersRepository extends BaseRepository
{
    public function __construct(ProductParameters $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return null
     */
    public function update(int $id, array $data): mixed
    {
        $productParameters = $this->model->find($id);

        if ($productParameters) {
            $productParameters->name = $data['name'];
            $productParameters->value = $data['value'];
            $productParameters->product_id = $data['product_id'];
            $productParameters->save();
        }
        return null;
    }
}