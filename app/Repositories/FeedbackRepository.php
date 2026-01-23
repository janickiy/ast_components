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
     * @return Feedback|null
     */
    public function update(int $id, array $data): ?Feedback
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->status = $data['status'];
            $model->save();
        }

        return null;

    }
}
