<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dte;
use App\Models\BranchOffice;
use App\Models\Cashier;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\StoreDteRequest;

class DteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branch_offices = BranchOffice::all();

        foreach($branch_offices as $branch_office) 
        {
            echo $branch_office->branch_office_id;
            $cashiers = Cashier::where('branch_office_id', $branch_office->branch_office_id)->get();

            $date = date('Y-m-d', strtotime('-5 days', strtotime(date('Y-m-d'))));

            foreach($cashiers as $cashier) {
                
                $dtes = Dte::from('dtes as c')
                        ->selectRaw('SUM(c.cash_amount) as cash_amount, SUM(c.card_amount) as card_amount, COUNT(*) as quantity, DATE(c.created_at) as date')
                        ->groupBy(DB::raw('DATE(c.created_at)'))
                        ->whereDate('created_at', '>=', $date)
                        ->where('c.branch_office_id', $branch_office->branch_office_id)
                        ->where('c.cashier_id', $cashier->cashier_id)
                        ->get();

                foreach($dtes as $dte) {
                    $collection_qty = Collection::where('branch_office_id', $branch_office->branch_office_id)->where('cashier_id', $cashier->cashier_id)->whereRaw('DATE(created_at) = "'. $dte->date .'"')->count();

                    if($collection_qty > 0) {
                        $collection = Collection::where('branch_office_id', $branch_office->branch_office_id)->where('cashier_id', $cashier->cashier_id)->whereRaw('DATE(created_at) = "'. $dte->date .'"')->first();
                        $cash_amount = $collection->cash_amount;
                        $card_amount = $collection->card_amount;
                        $ticket_number = $collection->quantity;
                        $old_amount = $collection->cash_amount + $collection->card_amount;
                        $new_amount = $dte->cash_amount + $dte->card_amount;
                        $collection->cash_amount = $dte->cash_amount;
                        $collection->card_amount = $dte->card_amount;
                        $collection->quantity = $dte->quantity;
                        $tz = 'America/Santiago';
                        $timestamp = time();
                        $dt = new DateTime("now", new \DateTimeZone($tz));
                        $dt->setTimestamp($timestamp);
                        $datetime = $dt->format('Y-m-d H:i:s');
                        $collection->updated_at = $datetime;
                        
                        if($old_amount < $new_amount) {
                            $collection->save();
                        }
                    } else {
                        $collection = new Collection;
                        $cash_amount = $collection->cash_amount;
                        $card_amount = $collection->card_amount;
                        $ticket_number = $collection->quantity;
                        $collection->branch_office_id = $branch_office->branch_office_id;
                        $collection->cashier_id = $cashier->cashier_id;
                        $collection->cash_amount = $dte->cash_amount;
                        $collection->card_amount = $dte->card_amount;
                        $collection->quantity = $dte->quantity;
                        $collection->created_at = $dte->date .' 00:00:00';
                        $tz = 'America/Santiago';
                        $timestamp = time();
                        $dt = new DateTime("now", new \DateTimeZone($tz)); //first argument "must" be a string
                        $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
                        $datetime = $dt->format('Y-m-d H:i:s');

                        $collection->updated_at = $datetime;
                        $collection->save();
                    }
                }
            }
        }
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
