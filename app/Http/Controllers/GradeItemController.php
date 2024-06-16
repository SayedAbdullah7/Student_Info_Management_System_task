<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGradeItemRequest;
use App\Http\Requests\UpdateGradeItemRequest;
use App\Http\Resources\GradeItemResource;
use App\Models\GradeItem;

class GradeItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $grandes = GradeItem::select('id', 'name', 'max_degree')->get();
        return GradeItemResource::collection($grandes);
    }

}
