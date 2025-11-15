<?php

namespace App\Http\Controllers;

use App\Models\Mua;

use Illuminate\Http\Request;

class PublicMuaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $muas = Mua::whereNotNull('nama_usaha')
            ->orderBy('nama_usaha')
            ->get();

        return view('menudpn.mua', compact('muas'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Mua $mua)
    {
        $mua = Mua::with('layanan')->findOrFail($mua->id);

        return view('menudpn.detailmua', compact('mua'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
