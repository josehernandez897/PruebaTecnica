<?php

namespace App\Http\Controllers\api;

use App\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Property::all(),200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'article' => 'required|string|min:4|max:255',
            'description' => 'required|string|min:6|max:255',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $request["user_id"]=$request->user()->id;

        return response()->json([
            'create'=>Property::create($request->all()),
            'response'=> 200,
        ],200);
    }

    public function bulkLoad(Request $request)
    {
        $myArray = array();

        $id = $request->user()->id;

        foreach ($request->all() as $item) {
            $item['user_id'] = $id;

            array_push($myArray, $item );
        }

        $property = Property::insert(array_values($myArray));

        return response()->json([
            'created' => true,
            'property' => $myArray,
            'response' => 200
        ], 200);
    }

    public function MultipleLoad(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        return response()->json(Property::findMany($request->ids),200);
    }

    public function show(Property $property)
    {
        return response()->json([
            'property' => $property,
            'response' => 200,
        ],200);
    }


   public function update(Request $request, Property $property)
    {
        $validator = Validator::make($request->all(), [
            'article' => 'required|string|min:4|max:255',
            'description' => 'required|string|min:6|max:255',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        return response()->json([
            'update' => $property->update($request->all()),
            'response' => 200,
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        return response()->json([
            'delete' => $property->delete(),
            'response' => 200,
        ],200);
    }
}
