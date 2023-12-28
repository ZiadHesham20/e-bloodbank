<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AiModel;
use Illuminate\Http\Request;

class AiModelController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'frequency' => 'required',
            'recency' => 'required',
            'target' => 'required',
            'time' => 'required',
        ]);

        $Aimodel = new AiModel();

        $Aimodel = AiModel::created([
            'frequency' => $request->frequency,
            'recency' => $request->recency,
            'target' => $request->target,
            'time' => $request->time,
        ]);

        return response()->json([
            'AiModel' => $Aimodel,
        ], 200);
    }

}
