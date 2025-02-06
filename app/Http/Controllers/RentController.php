<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $rents = Rent::all();

            return response()->json([
                'success' => true,
                'rents' => $rents
            ]);
        }

        $rents = Rent::where('id_tenant' == Auth::user()->id)->get();

        return response()->json([
            'success' => true,
            'rents' => $rents
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cars = Car::select('id', 'name_car', 'no_car')->get();
        $tenants = User::select('id', 'name', 'username')->where('role', 'user')->get();

        return response()->json([
            'success' => true,
            'cars' => $cars,
            'tenants' => $tenants
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
            'date_borrow' => 'required',
            'date_return' => 'required',
            'down_payment' => 'required',
            'discount' => 'required',
            'total' => 'required'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'invalid field'
            ]);
        }

        $downPayment = $request->input('down_payment', 0);
        $discount = $request->input('discount', 0);

        $total = $request->total - ($downPayment + ($request->total * ($discount / 100)));

        $rent = Rent::create([
            'id_tenant' => $request->id_tenant,
            'id_car' => $request->id_car,
            'date_borrow' => $request->date_borrow,
            'date_return' => $request->date_return,
            'down_payment' => $downPayment,
            'discount' => $discount,
            'total' => $total
        ]);

        return response()->json([
            'success' => true,
            'message' => 'create rent success',
            'rent' => $rent
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rent = Rent::find($id);

        if (!$rent) {
            return response()->json([
                'success' => false,
                'message' => 'rent not exist.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'rent' => $rent
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rent = Rent::find($id);

        if (!$rent) {
            return response()->json([
                'success' => false,
                'message' => 'rent not exist.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'rent' => $rent
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rent = Rent::find($id);

        if (!$rent) {
            return response()->json([
                'success' => false,
                'message' => 'rent not exist.'
            ], 404);
        }

        $validated = Validator::make($request->all(), [
            'id_tenant' => 'required|exists:users',
            'id_car' => 'required|exists:cars',
            'date_borrow' => 'required',
            'date_return' => 'required',
            'down_payment' => 'required',
            'discount' => 'required',
            'total' => 'required'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'invalid field'
            ]);
        }

        $downPayment = $request->input('down_payment', 0);
        $discount = $request->input('discount', 0);

        $total = $request->total - ($downPayment + ($request->total * $discount));

        $rent->update([
            'id_tenant' => $request->id_tenant,
            'id_car' => $request->id_car,
            'date_borrow' => $request->date_borrow,
            'date_return' => $request->date_return,
            'down_payment' => $downPayment,
            'discount' => $discount,
            'total' => $total
        ]);

        return response()->json([
            'success' => true,
            'message' => 'rent edited success.',
            'rent' => $rent
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rent = Rent::find($id);

        if (!$rent) {
            return response()->json([
                'success' => false,
                'message' => 'rent not exist.'
            ], 404);
        }

        $rent->delete();

        return response()->json([
            'success' => true,
            'message' => 'rent deleted success.'
        ]);
    }
}
