<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tuto;
use Illuminate\Http\Request;

class TutoController extends Controller
{
    public function index(Request $request)
    {

        if ($request->categories) {
            $tutos = Tuto::filters($request)->paginate(config('app.api_per_page'));

            // $newTutos = sortByCategoriesMatchCount($tutos, $request->categories, config('app.api_per_page'));

            return response()->json($tutos, 200, [], JSON_NUMERIC_CHECK);
        } else {
            $tutos = Tuto::customLatest('tutos', $request)->paginate(config('app.api_per_page'));

            return response()->json($tutos, 200, [], JSON_NUMERIC_CHECK);
        }


    }

    public function show($id)
    {

        $tuto = Tuto::with(['tutoParts'])->findOrFail($id);


        return response()->json($tuto, 200, [], JSON_NUMERIC_CHECK);
    }
}
