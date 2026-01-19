<?php

namespace App\Repositories;

use App\DTO\Complaints\RequestsCreateData;
use App\Enums\RequestStatus;
use App\Models\Requests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Database\DatabaseManager;

class RequestsRepository extends BaseRepository
{
    /**
     * @param DatabaseManager $database
     * @param Requests $model
     */
    public function __construct(private readonly DatabaseManager $database, Requests $model)
    {
        parent::__construct($model);
    }

    /**
     * @param RequestsCreateData $data
     * @return Requests
     */
    public function add(RequestsCreateData $data): Requests
    {
        return Requests::query()->create([
            'name' => $data->name,
            'company' => $data->company,
            'phone' => $data->phone,
            'email' => $data->email,
            'message' => $data->message,
            'nomenclature' => $data->nomenclature,
            'count' => $data->count,
            'unit' => $data->unit,
            'ip' => $data->ip,
            'status' => RequestStatus::Created->value,
            'customer_id' => $data->customerId,
            'attach' =>$data->attach,
        ]);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data): mixed
    {
        $request = $this->model->find($id);

        if ($request) {
            $request->name = $data['name'];
            $request->company = $data['company'];
            $request->phone = $data['phone'];
            $request->email = $data['email'];
            $request->message = $data['message'];
            $request->nomenclature = $data['nomenclature'];
            $request->count = (int) $data['count'];
            $request->unit = (int) $data['unit'];
            $request->ip = $data['ip'];
            $request->status = (int) $data['status'];
            $request->customer_id = (int) $data['customer_id'] ?? null;

            if ($data['attach']) {
                $request->attach = $data['attach'];
            }

            $request->save();
        }
        return null;
    }

    /**
     * @param int $customerId
     * @param int $perPage
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function paginateByCustomer(
        int   $customerId,
        int   $perPage = 10,
        array $filters = []
    ): LengthAwarePaginator
    {
        $q = $this->model->newQuery()
            ->where('customer_id', $customerId)
            ->orderByDesc('created_at'); // или created_at

        // Примеры фильтров (по желанию)
        if (!empty($filters['status'])) {
            $q->where('status', $filters['status']);
        }

        if (!empty($filters['from'])) {
            $q->whereDate('created_at', '>=', $filters['from']);
        }

        if (!empty($filters['to'])) {
            $q->whereDate('created_at', '<=', $filters['to']);
        }

        return $q->paginate($perPage);
    }
}
