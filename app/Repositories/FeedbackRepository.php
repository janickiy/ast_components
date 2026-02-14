<?php

namespace App\Repositories;

use App\DTO\FeedbackCreateData;
use App\Models\Feedback;

class FeedbackRepository extends BaseRepository
{

    public function __construct(Feedback $model)
    {
        parent::__construct($model);
    }

    /**
     * @param FeedbackCreateData $data
     * @return Feedback
     */
    public function add(FeedbackCreateData $data): Feedback
    {
        return Feedback::query()->create([
            'name' => $data->name,
            'email' => $data->email,
            'phone' => $data->phone,
            'message' => $data?->message,
            'ip' => $data->ip,
        ]);
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
     * @param array $data
     * @return array
     */
    private function mapping(array $data): array
    {
        return collect($data)
            ->only($this->model->getFillable())
            ->map(function ($value, $key) {
                if ($key === 'status' && !is_null($value)) {
                    return (int)$value;
                }
                return $value;
            })
            ->all();
    }
}
