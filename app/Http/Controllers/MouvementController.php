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

        $ressource = Ressource::whereId($request->ressource_id)->first();

        if (($ressource->solde < $request->montant) && ($request->type_mouvement_id == 2)) {
            return response()->json([
                'errors' => 'le solde de la ressource choisi ne suffit pas pour effectuer cette opération',
                'solde' => 'errors'
            ], 422);
        } else {

            /* calculer nouveau montant du solde de la ressource après l'ajout d'un mouvement et l'update*/
            if ($request->type_mouvement_id == 1) {
                $newSolde =  $ressource->solde + $request->montant;
            } else {
                $newSolde =  $ressource->solde - $request->montant;
            }


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

        $ressource = Ressource::whereId($request->ressource_id)->first();
        $solde = $ressource->solde;
        $oldMontant = $mouvement->montant;
        $newMontant = $request->montant;

        if ($request->type_mouvement_id == 2) {
            if ($mouvement->type_mouvement_id == 1) {
                if (($solde - $oldMontant) < $newMontant) {
                    return response()->json([
                        'errors' => 'le solde de la ressource choisi ne suffit pas pour effectuer cette opération',
                        'solde' => 'errors'
                    ], 422);
                } else {
                    $newSolde = $solde - $oldMontant - $newMontant;

                    $ressource->update(['solde' => $newSolde]);
                    $mouvement->update($data);
                    return response()->json([
                        'success' => 'Mouvement a bien était mise à jour'
                    ]);
                }
            } elseif ($mouvement->type_mouvement_id == 2) {
                if (($solde + $oldMontant) < $newMontant) {
                    return response()->json([
                        'errors' => 'le solde de la ressource choisi ne suffit pas pour effectuer cette opération',
                        'solde' => 'errors'
                    ], 422);
                } else {
                    $newSolde = $solde + $oldMontant - $newMontant;

                    $ressource->update(['solde' => $newSolde]);
                    $mouvement->update($data);
                    return response()->json([
                        'success' => 'Mouvement a bien était mise à jour'
                    ]);
                }
            }
        } elseif ($request->type_mouvement_id = 1) {
            if ($mouvement->type_mouvement_id == 1) {
                $newSolde = $solde - $oldMontant + $newMontant;
                $ressource->update(['solde' => $newSolde]);
                $mouvement->update($data);
                return response()->json([
                    'success' => 'Mouvement a bien était mise a jour'
                ]);
            } elseif ($mouvement->type_mouvement_id == 2) {
                $newSolde = $solde + $oldMontant + $newMontant;
                $ressource->update(['solde' => $newSolde]);
                $mouvement->update($data);
                return response()->json([
                    'success' => 'Mouvement a bien était mise a jour'
                ]);
            }
        }


        /*

               // /* check le type
        // calcule new solde
        $ressource = Ressource::whereId($request->ressource_id)->first('solde');

        if ($mouvement->type_mouvement_id == 2) {
            $solde = $ressource + $mouvement->montant;
        } elseif ($mouvement->type_mouvement_id == 1) {
            $solde = $ressource - $mouvement->montant;
        }



        if (($request->type_mouvement_id == 2) && ($solde < $request->montant)) {
             calcule du solde
            return response()->json([
                'errors' => 'le solde de la ressource choisi ne suffit pas pour effectuer cette opération',
                'solde' => 'errors'
            ], 422);
        } else {
             calculer nouveau montant du solde de la ressource après l'ajout d'un mouvement et l'update
            if ($request->type_mouvement_id == 1) {
                $newSolde =  $ressource->solde + $request->montant;
            } else {
                $newSolde =  $ressource->solde - $request->montant;
            }
            $ressource->update(['solde' => $newSolde]);

            $mouvement->update($data);
            return response()->json([
                'success' => 'Mouvement a bien était mise a jour'
            ]);
        }

  */
        /*         $mouvement->update($data);
        return response()->json([
            'success' => 'Mouvement a bien était mise a jour'
        ]); */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mouvement  $mouvement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mouvement $mouvement)
    {
        $ressource = Ressource::whereId($mouvement->ressource_id)->first();


        if ($mouvement->type_mouvement_id === 1) {
            $solde = $ressource->solde - $mouvement->montant;
        } else {
            $solde = $ressource->solde + $mouvement->montant;
        }

        $mouvement->delete();
        $ressource->update(['solde' => $solde]);
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
    public function showUserMouvement($userId)
    {

        return response()->json(Mouvement::whereUserId($userId)->orderBy('date_mouvement', 'desc')->get());
    }

    public function kpi($id)
    {
        $mouvementMonthly = Mouvement::selectRaw(' MONTH(date_mouvement) AS m, SUM(CASE WHEN type_mouvement_id = 1 THEN montant ELSE 0  END) AS recette, SUM(CASE WHEN type_mouvement_id = 2 THEN montant ELSE 0  END) AS depense')
            ->where('user_id', $id)
            ->whereYear('date_mouvement',  date('Y'))
            ->groupBy('m')
            ->orderBy('m', 'asc')
            ->get();
        $firstYear = date('Y') - 4;
        $lastYear = date('Y') + 2;
        $mouvementYearly = Mouvement::selectRaw(" YEAR(date_mouvement) AS y, SUM(CASE WHEN type_mouvement_id = 1 THEN montant ELSE 0  END) AS recette, SUM(CASE WHEN type_mouvement_id = 2 THEN montant ELSE 0  END) AS depense")
            ->where('user_id', $id)
            ->whereYear('date_mouvement', '>=', $firstYear)
            ->groupBy('y')
            ->orderBy('y', 'asc')
            ->get();

        return response()->json([
            $mouvementMonthly,
            $mouvementYearly
        ]);
    }
}