<?php

namespace App\Repositories;

use App\Models\Customers;

class CustomerRepository extends BaseRepository
{
    public function __construct(Customers $model)
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
        $customer = $this->model->find($id);

        if ($customer) {
            $customer->name = $data['name'];
            $customer->email = $data['email'];
            $customer->phone = $data['phone'];
            $customer->save();
        }
        return null;
    }
}
