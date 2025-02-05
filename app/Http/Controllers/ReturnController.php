<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarReturn;
use App\Models\Penalty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $returns = CarReturn::all();

        return response()->json([
            'success' => true,
            'returns' => $returns,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cars = Car::select('id', 'name_car', 'no_car')->get();
        $tenants = User::select('id', 'name', 'username')->where('role', 'user')->get();
        $penalties = Penalty::select('id', 'penalties_name', 'penalties_total')->get();

        return response()->json([
            'cars' => $cars,
            'tenants' => $tenants,
            'penalties' => $penalties,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'id_tenant' => 'required|exists:users,id',
            'id_car' => 'required|exists:cars,id',
            'id_penalties' => 'required|exists:penalties,id',
            'date_borrow' => 'required|date',
            'date_return' => 'required|date',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'invalid fields',
                'errors' => $validated->errors()
            ], 422);
        }

        $car = Car::find($request->input('id_car'));
        $carPrice = $car->price;

        $penaltiesTotal = $request->input('penalties_total', 0);
        $discount = $request->input('discount', 0);
        $total = $carPrice - ($penaltiesTotal + $discount);

        CarReturn::create([
            'id_tenant' => $request->input('id_tenant'),
            'id_car' => $request->input('id_car'),
            'id_penalties' => $request->input('id_penalties'),
            'date_borrow' => $request->input('date_borrow'),
            'date_return' => $request->input('date_return'),
            'penalties_total' => $penaltiesTotal,
            'discount' => $discount,
            'total' => $total
        ]);

        return response()->json([
            'success' => true,
            'message' => 'create return success.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $return = CarReturn::find($id);

        if (!$return) {
            return response()->json([
                'success' => false,
                'message' => 'return not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'return' => $return
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $return = CarReturn::find($id);

        if (!$return) {
            return response()->json([
                'success' => false,
                'message' => 'return not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'return' => $return
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $return = CarReturn::find($id);

        if (!$return) {
            return response()->json([
                'success' => false,
                'message' => 'return not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'return' => $return
        ]);

        $validated = Validator::make($request->all(), [
            'id_tenant' => 'required|exists:users,id',
            'id_car' => 'required|exists:cars,id',
            'id_penalties' => 'required|exists:penalties,id',
            'date_borrow' => 'required|date',
            'date_return' => 'required|date',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'invalid fields',
                'errors' => $validated->errors()
            ], 422);
        }

        $car = Car::find($request->input('id_car'));
        $carPrice = $car->price;

        $penaltiesTotal = $request->input('penalties_total', 0);
        $discount = $request->input('discount', 0);
        $total = $carPrice - ($penaltiesTotal + $discount);

        $return->update([
            'id_tenant' => $request->input('id_tenant'),
            'id_car' => $request->input('id_car'),
            'id_penalties' => $request->input('id_penalties'),
            'date_borrow' => $request->input('date_borrow'),
            'date_return' => $request->input('date_return'),
            'penalties_total' => $penaltiesTotal,
            'discount' => $discount,
            'total' => $total
        ]);

        return response()->json([
            'success' => true,
            'message' => 'update return success.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $return = CarReturn::find($id);

        if (!$return) {
            return response()->json([
                'success' => false,
                'message' => 'return not found'
            ], 404);
        }

        $return->delete();

        return response()->json([
            'success' => true,
            'message' => 'delete return success'
        ]);
    }
}
