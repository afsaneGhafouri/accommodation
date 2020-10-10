<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccommodationCreateRequest;
use App\Models\Accommodation;
use App\Services\AccommodationService;

class AccommodationController extends Controller
{
    private $accommodationService;

    public function __construct(AccommodationService $accommodationService)
    {
        $this->accommodationService = $accommodationService;
    }
    public function create(AccommodationCreateRequest $request)
    {
        $fields = $request->only(['type','room_count','bed_count','price','address','description']);
        $newAccommodation = $this->accommodationService->create($fields);

        return response()->json($newAccommodation,201);
    }

    public function list()
    {
        return $this->accommodationService->list();
    }


}
