<?php

namespace App\Services;

use App\Models\Accommodation;
use Elasticsearch;

class AccommodationService
{
    private $model;

    public function __construct(Accommodation $accommodation)
    {
        $this->model = $accommodation;
    }

    public function create(array $fields)
    {
        $accommodation = $this->model->create($fields);
        $data = [
            'body' => $accommodation->toArray(),
            'index' => 'accommodation_index',
            'type' => 'type'
            ];

        Elasticsearch::index($data);

        return $accommodation;
    }

    public function list()
    {
        return $this->model->all();
    }
}
