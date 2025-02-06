<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::all();

        return response()->json([
            'status' => 'success',
            'cars' => $cars
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'no_car' => 'required',
            'name_car' => 'required',
            'type_car' => 'required',
            'year' => 'required',
            'seat' => 'required',
            'image' => 'required',
            'total' => 'required',
            'price' => 'required',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'invalid field.'
            ], 422);
        }

        $car = Car::create([
            'no_car' => $request->no_car,
            'name_car' => $request->name_car,
            'type_car' => $request->type_car,
            'year' => $request->year,
            'seat' => $request->seat,
            'image' => $request->image,
            'total' => $request->total,
            'price' => $request->price,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'create car success.',
            'car' => $car
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car = Car::find($id);

        if (!$car) {
            return response()->json([
                'success' => false,
                'message' => 'the car not exist.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'car' => $car
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $car = Car::find($id);

        if (!$car) {
            return response()->json([
                'success' => false,
                'message' => 'the car not exist.'
            ]);
        }

        return response()->json([
            'success' => true,
            'car' => $car
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $car = Car::find($id);

        if (!$car) {
            return response()->json([
                'success' => false,
                'message' => 'the car not exist.'
            ]);
        }

        $validated = Validator::make($request->all(), [
            'no_car' => 'required',
            'name_car' => 'required',
            'type_car' => 'required',
            'year' => 'required',
            'seat' => 'required',
            'image' => 'required',
            'total' => 'required',
            'price' => 'required',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'invalid field.'
            ], 422);
        }

        $car->update([
            'no_car' => $request->no_car,
            'name_car' => $request->name_car,
            'type_car' => $request->type_car,
            'year' => $request->year,
            'seat' => $request->seat,
            'image' => $request->image,
            'total' => $request->total,
            'price' => $request->price,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'update car success.',
            'car' => $car
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = Car::find($id);

        if (!$car) {
            return response()->json([
                'success' => false,
                'message' => 'the car not exist.'
            ]);
        }

        $car->delete();

        return response()->json([
            'success' => true,
            'message' => 'delete car succes.'
        ]);
    }
}
