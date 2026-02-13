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
    public function updateWithMapping(int $id, array $data): bool
    {
        $model = $this->model->find($id);

        if (!$model) return false;

        return $this->update($id, $this->mapping($data, $model));
    }

    /**
     * @param int $customerId
     * @param array $data
     * @return bool
     */
    public function updateByCustomer(int $customerId, array $data): bool
    {
        /** @var Company|null $company */
        $company = $this->model
            ->where('customer_id', $customerId)
            ->first();

        if (!$company) {
            return false;
        }

        return $this->update($company->id, $data);
    }

    private function mapping(array $data, Company $company): array
    {
        return collect($data)
            ->merge([
                'name' => $data['name'] ?? $company->name,
                'inn' => $data['inn'] ?? $company->inn,
                'contact_person' => $data['contact_person'] ?? $company->contact_person,
                'phone' => $data['phone'] ?? $company->phone,
                'email' => $data['email'] ?? $company->email,
                'customer_id' => $data['customer_id'] ?? $company->customer_id,
            ])
            ->only($this->model->getFillable())
            ->mapWithKeys(function ($value, $key) {
                if ($key === 'customer_id' && !is_null($value)) {
                    return (int)$value;
                }
                return $value;
            })
            ->toArray();
    }
}
