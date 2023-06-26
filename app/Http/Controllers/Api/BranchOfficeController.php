<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BranchOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\StoreBranchOfficeRequest;

class BranchOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branch_offices = BranchOffice::select('id', 'branch_office')
             ->orderByDesc('id')
             ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $branch_offices
        ], 200);
    }

    /**
     * Display a listing of the resource.
     */
    public function get_select()
    {
        $branch_offices = BranchOffice::orderByDesc('id')->get();

        return response()->json([
            'success' => true,
            'data' => $branch_offices
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
    public function store(StoreBranchOfficeRequest $request)
    {
        $branch_office = BranchOffice::create([
            'branch_office' => $request->branch_office,
            'address' => $request->address,
            'opening_date' => $request->opening_date
        ]);

        return response()->json([
            'success' => true,
            'data' => $branch_office
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(BranchOffice $branch_office)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BranchOffice $branch_office)
    {
        return response()->json([
            'success' => true,
            'data' => $branch_office
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $branch_office = BranchOffice::find($id);
        $branch_office->branch_office = $request->branch_office;
        $branch_office->address = $request->address;
        $branch_office->opening_date = $request->opening_date;
        $branch_office->save();

        return response()->json([
            'success' => true,
            'data' => $branch_office
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BranchOffice $branch_office)
    {
        $branch_office->delete();

        return response()->json([
            'success' => true,
            'data' => $branch_office
        ], 200);
    }
}
