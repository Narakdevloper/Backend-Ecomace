<?php

namespace App\Http\Controllers;

use App\Models\Adress;
use Illuminate\Http\Request;
use App\Http\Requests\Address\StoreAddressRequest;
class AdressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses=Adress::where('user_id', auth()->id())->get();
        return response()->json($addresses,200);
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
    public function store(StoreAddressRequest $request)
    {
        $data=$request->validated();
        $address=Adress::create($data);
        return response()->json($address, 200);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Adress $adress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Adress $adress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAddressRequest $request, Adress $adress)
    {
        $data=$request->validated();
        $adress->update($data);
        return response()->json($adress, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adress $adress)
    {
        $adress->delete();
        return response()->json(null, 204);
    }
}
