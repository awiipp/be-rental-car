<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Penalty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenaltyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penalties = Penalty::all();

        return response()->json([
            'success' => true,
            'penalties' => $penalties
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cars = Car::select('id', 'name_car', 'no_car')->get();

        return response()->json([
            'cars' => $cars
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'penalties_name' => 'required',
            'description' => 'required',
            'id_car' => 'required|exists:cars,id',
            'penalties_total' => 'required',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'invalid field'
            ], 422);
        }

        $penalty = Penalty::create([
            'penalties_name' => $request->input('penalties_name'),
            'description' => $request->input('description'),
            'id_car' => $request->input('id_car'),
            'penalties_total' => $request->input('penalties_total'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'create penalties success',
            'penalty' => $penalty
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $penalty = Penalty::find($id);

        if (!$penalty) {
            return response()->json([
                'success' => false,
                'message' => 'penalty not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'penalty' => $penalty
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penalty = Penalty::find($id);

        if (!$penalty) {
            return response()->json([
                'success' => false,
                'message' => 'penalty not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'penalty' => $penalty
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $penalty = Penalty::find($id);

        if (!$penalty) {
            return response()->json([
                'success' => false,
                'message' => 'penalty not found'
            ], 404);
        }

        $validated = Validator::make($request->all(), [
            'penalties_name' => 'required',
            'description' => 'required',
            'id_car' => 'required|exists:cars,id',
            'penalties_total' => 'required',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'invalid field'
            ], 422);
        }

        $penalty->update([
            'penalties_name' => $request->input('penalties_name'),
            'description' => $request->input('description'),
            'id_car' => $request->input('id_car'),
            'penalties_total' => $request->input('penalties_total'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'create penalties success',
            'penalty' => $penalty
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penalty = Penalty::find($id);

        if (!$penalty) {
            return response()->json([
                'success' => false,
                'message' => 'penalty not found'
            ], 404);
        }

        $penalty->delete();

        return response()->json([
            'success' => true,
            'message' => 'delete penalties success'
        ]);
    }
}
