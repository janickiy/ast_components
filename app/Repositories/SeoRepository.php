<?php

namespace App\Repositories;

use App\Models\Seo;

class SeoRepository extends BaseRepository
{
    public function __construct(Seo $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data): mixed
    {
        $seo = $this->model->find($id);

        if ($seo) {
            $seo->h1 = $data['h1'];
            $seo->title = $data['title'];
            $seo->keyword = $data['keyword'];
            $seo->description = $data['description'];
            $seo->url_canonical = $data['url_canonical'];
            $seo->save();
        }
        return null;
    }
}