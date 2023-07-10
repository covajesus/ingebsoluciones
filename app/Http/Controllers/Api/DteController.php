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
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://libredte.cl/api/dte/dte_emitidos/pdf/39/9172935/76063822-6?formato=general&papelContinuo=0&copias_tributarias=1&copias_cedibles=1&cedible=0&compress=0&base64=0',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer EAAFYECjSEkQBABTS8JJeDkzoZAZBL8BbNBS3oAA0ZAoZCGGRydpGFX1t7WgeHs1s9ZCNSt7x8OXYza8UQZBZBwowfkpXVzdryffZAvx4gScGnDvtjfxmlcfZCT8v1VxoAsJJgRvNZAthAWSxD4uuXhiKqpwzer6TxLYyCwaZCJ4vZAyTGq2sVimC2RcB',
                'Content-Type: application/json'
            )
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
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
    public function show()
    {
        $dtes = Dte::from('dtes as c')
        ->selectRaw('c.id, c.total, c.folio, c.created_at')
        ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $dtes
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dte $dte)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function download(Request $id)
    {
        $dte = Dte::from('dtes as c')
        ->selectRaw('c.id, c.total, c.folio, c.created_at')
        ->where('c.folio', '=', $id)
        ->first();

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://libredte.cl/api/dte/dte_emitidos/pdf/39/'.$id.'/76063822?formato=general&papelContinuo=0&copias_tributarias=1&copias_cedibles=1&cedible=0&compress=0&base64=0',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: JXou3uyrc7sNnP2ewOCX38tWZ6BTm4D1',
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

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
