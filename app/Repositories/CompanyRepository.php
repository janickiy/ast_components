<?php

namespace App\Repositories;

use App\DTO\DataTransferObjectInterface;
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
     * @return bool
     */
    public function updateWithMapping(int $id, array|DataTransferObjectInterface $data): bool
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
    public function updateByCustomer(int $customerId, array|DataTransferObjectInterface $data): ?Company
    {
        /** @var Company|null $company */
        $company = $this->model
            ->where('customer_id', $customerId)
            ->first();

        if (!$company) {
            return null;
        }

        return parent::update($company->id, $this->mapping($data, $company)) ? $company->fresh() : null;
    }

    private function mapping(array|DataTransferObjectInterface $data, Company $company): array
    {
        $data = $this->normalizeData($data);

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
            ->map(function ($value, $key) {
                if ($key === 'customer_id' && !is_null($value)) {
                    return (int)$value;
                }
                return $value;
            })
            ->all();
    }
}
