<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cashier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\StoreCashierRequest;

class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cashiers = Cashier::select('id', 'cashier')
             ->orderByDesc('id')
             ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $cashiers
        ], 200);
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
    public function store(StoreCashierRequest $request)
    {
        $cashier = Cashier::create([
            'branch_office_id' => $request->branch_office_id,
            'cashier' => $request->cashier
        ]);

        return response()->json([
            'success' => true,
            'data' => $cashier
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cashier $cashier)
    {
        return response()->json([
            'success' => true,
            'data' => $cashier
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cashier = Cashier::find($id);
        $cashier->branch_office_id = $request->branch_office_id;
        $cashier->cashier = $request->cashier;
        $cashier->save();

        return response()->json([
            'success' => true,
            'data' => $cashier
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cashier $cashier)
    {
        $cashier->delete();

        return response()->json([
            'success' => true,
            'data' => $cashier
        ], 200);
    }
}
