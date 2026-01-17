<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository extends BaseRepository
{
    public function __construct(Company $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Company|null
     */
    public function update(int $id, array $data): ?Company
    {
        /** @var \App\Models\Company $company */
        $company = $this->model->find($id);

        if (!$company) {
            return null;
        }

        $company->name = $data['name'] ?? $company->name;
        $company->inn = $data['inn'] ?? $company->inn;
        $company->contact_person = $data['contact_person'] ?? $company->contact_person;
        $company->phone = $data['phone'] ?? $company->phone;
        $company->email = $data['email'] ?? $company->email;
        $company->customer_id = $data['customer_id'] ?? $company->customer_id;

        $company->save();

        return $company;
    }

    /**
     * @param int $customerId
     * @param array $data
     * @return Company|null
     */
    public function updateByCustomer(int $customerId, array $data): ?Company
    {
        /** @var Company|null $company */
        $company = $this->model
            ->where('customer_id', $customerId)
            ->first();

        if (!$company) {
            return null;
        }

        $company = $this->update($company->id, $data);

        return $company;
    }
}
