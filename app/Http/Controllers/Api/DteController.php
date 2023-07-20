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
    public function show(Request $request)
    {
        $branch_office_id = $request->segment(4);
        $cashier_id = $request->segment(5);
        $date = $request->segment(6);

        $dtes = Dte::from('dtes as c')
            ->selectRaw('c.id, c.total, c.folio, c.created_at')
            ->where('c.branch_office_id', $branch_office_id)
            ->where('c.cashier_id', $cashier_id)
            ->whereRaw("DATE_FORMAT(c.created_at, '%d-%m-%Y') = ?", $date) // Utilizamos DATE_FORMAT en la condición del WHERE
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
    public function download(Request $request)
    {
        $id = $request->segment(4);
        $url = 'https://libredte.cl';
        $hash = 'mIrjMMSoCs2sHmrK92SH4BsQifGbpZS9';
        $rut = 77777612;
        $dte = 39;
        $folio = $id;
        $papelContinuo = 0; // =75 ó =80 para papel contínuo
        $copias_tributarias = 1;
        $copias_cedibles = 1;
        $cedible = (int)(bool)$copias_cedibles; // =1 genera cedible, =0 no genera cedibleW

        // crear cliente
        $LibreDTE = new \sasco\LibreDTE\SDK\LibreDTE($hash, $url);

        // descargar PDF
        $opciones = '?papelContinuo='.$papelContinuo.'&copias_tributarias='.$copias_tributarias.'&copias_cedibles='.$copias_cedibles.'&cedible='.$cedible;
        $pdf = $LibreDTE->get('/dte/dte_emitidos/pdf/'.$dte.'/'.$folio.'/'.$rut.$opciones);
        if ($pdf['status']['code']!=200) {
            die('Error al descargar el PDF del DTE emitido: '.$pdf['body']."\n");
        }

        $response = response($pdf['body'], 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="dte_emitido_pdf.pdf"'
        ]);

        return $response;
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
