<?php

namespace App\Http\Controllers;

use App\Models\Mouvement;
use App\Models\Ressource;
use Illuminate\Http\Request;

class MouvementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Mouvement::orderBy('created_at')->get());
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
            'description' => 'required',
            'montant' => 'required|numeric',
            'date_mouvement' => 'required|date',
            'solde_intermediaire' => 'required|numeric',
            'user_id' => 'required',
            'ressource_id' => 'required',
            'type_mouvement_id' => 'required',
        ]);
        /* update solde  */
        $ressource = Ressource::whereId($request->ressource_id)->first();

        if ($ressource->solde < $request->montant) {
            return response()->json([
                'errors' => 'le solde de la ressource choisi ne suffit pas pour effectuer cette opération',
                'solde' => 'errors'
            ], 422);
        } else {

            /* TODO check le type de mouvement  pour up rajouté le montant ou le soustraire*/
            /* if($ressource->) */

            $newSolde =  $ressource->solde - $request->montant;
            $ressource->update(['solde' => $newSolde]);

            Mouvement::create($data);
            return response()->json([
                'success' => 'Mouvement a bien était crée'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mouvement  $mouvement
     * @return \Illuminate\Http\Response
     */
    public function show(Mouvement $mouvement)
    {
        return response()->json(Mouvement::whereId($mouvement->id)->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mouvement  $mouvement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mouvement $mouvement)
    {
        $data = $request->validate([
            'description' => 'required',
            'montant' => 'required|numeric',
            'date_mouvement' => 'required|date',
            /*  'solde_intermediaire' => 'required|numeric', */
            'user_id' => 'required',
            'ressource_id' => 'required',
            'type_mouvement_id' => 'required',
        ]);
        $mouvement->update($data);
        return response()->json([
            'success' => 'Mouvement a bien était mise a jour'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mouvement  $mouvement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mouvement $mouvement)
    {
        $mouvement->delete();
        return response()->json([
            'success' => 'Mouvement a bien était supprimer'
        ]);
    }

    public function TotalEntreSortie($id)
    {

        return response()->json([
            'entré' => Mouvement::whereUserId($id)->where('type_mouvement_id', 1)->sum('montant'),
            'sortie' => Mouvement::whereUserId($id)->where('type_mouvement_id', 2)->sum('montant'),
        ]);
    }
}