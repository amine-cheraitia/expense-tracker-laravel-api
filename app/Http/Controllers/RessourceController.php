<?php

namespace App\Http\Controllers;

use App\Models\Ressource;
use Illuminate\Http\Request;

class RessourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Ressource::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_ressource' => 'required',
            'solde' => 'required|numeric',
            'num_compte' => 'nullable',
            'type_ressources_id' => 'required',
            'user_id' => 'required',
        ]);

        Ressource::create($data);

        return response()->json([
            'success' => 'Ressource a bien était crée'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ressource  $ressource
     * @return \Illuminate\Http\Response
     */
    public function show(Ressource $ressource)
    {
    }

    public function showperuser($id)
    {
        return response()->json(Ressource::whereUserId($id)->get());
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ressource  $ressource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ressource $ressource)
    {
        $data = $request->validate([
            'nom_ressource' => 'required',
            'solde' => 'required|numeric',
            'type_ressources_id' => 'required',
            'num_compte' => 'nullable',
            'user_id' => 'required',
        ]);

        $ressource->update($data);
        return response()->json([
            'success' => 'Ressource a bien était mise a jour'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ressource  $ressource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ressource $ressource)
    {
        $ressource->delete();
        return response()->json([
            'success' => 'Ressource a bien était supprimer'
        ]);
    }
}