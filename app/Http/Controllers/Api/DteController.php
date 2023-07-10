<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\StoreDteRequest;
use DB;
use DateTime;

class DteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreDteRequest $request)
    {
        $dte = Dte::create([
            'branch_office_id' => $request->branch_office_id,
            'cashier_id' => $request->cashier_id,
            'folio' => $request->folio,
            'cash_amount' => $request->cash_amount,
            'card_amount' => $request->card_amount,
            'subtotal' => $request->subtotal,
            'tax' => $request->tax,
            'total' => $request->total,
            'ticket_serial_number' => $request->ticket_serial_number,
            'ticket_hour' => $request->ticket_hour,
            'ticket_transaction_number' => $request->ticket_transaction_number,
            'ticket_dispenser_number' => $request->ticket_dispenser_number,
            'ticket_station_number' => $request->ticket_station_number,
            'ticket_sa' => $request->ticket_sa,
            'ticket_number' => $request->ticket_number,
            'ticket_correlative' => $request->ticket_correlative,
            'entrance_hour' => $request->entrance_hour,
            'exit_hour' => $request->exit_hour,
            'item_quantity' => $request->item_quantity,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at
        ]);

        if ($dte) {
            return response()->json([
                'success' => true,
                'data' => $dte
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'data' => $dte
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BranchOffice $dte)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dte $dte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dte $dte)
    {
        //
    }
}
