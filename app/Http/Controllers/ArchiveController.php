<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\TypeArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArchiveController extends Controller
{
    // Liste des archives
    public function index()
    {
        $archives = Archive::latest()->get();
        return view('archives.index', compact('archives'));
    }

    // Formulaire création
    public function create()
    {
        $types = TypeArchive::all();
        return view('archives.create', compact('types'));
    }

    // Enregistrement d'une nouvelle archive

    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'archive_profile_id' => 'required|exists:type_archives,id',
            'champs' => 'required|array',
        ]);
    

        $archive = new Archive();
            // Enregistrer les champs dynamiques
            //$archive->donnees = json_encode($request->champs);
        $fichier = $request->champs['document'] ;
        // Gestion de l'upload de fichier
        
        if ($fichier->hasFile('fichier')) {
            $fichierPath = $fichier->file('fichier')->store('archives', 'public');
            $archive->fichier = $fichierPath;
        }
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
        $type = TypeArchive::findOrFail($request->archive_profile_id);

        // Créer l'archive principale
        $archive = Archive::create([
            'titre' => $request->champs['Titre'] ?? $type->nom,
            'description' => $request->champs['Description'] ?? '',
            'type_id' => $request->archive_profile_id,
            'service_id' => $user->service, // Enregistrement automatique du service de l'utilisateur
            'metadata' => json_encode($request->champs), // Sauvegarde tous les champs comme métadonnées
            
        ]);
        $archive->save();
        return redirect()->route('archives.index')->with('success', 'Archive créée avec succès.');
    }
    
    // Affichage d'une archive
    public function show($id)
    {
        $archive = Archive::findOrFail($id);

        $champs = json_decode($archive->donnees, true);

        return view('archives.show', compact('archive', 'champs'));
    }
public function edit(Request $request,$id){

}
    // Suppression d'une archive
    public function destroy($id)
    {
        $archive = Archive::findOrFail($id);

        // Supprimer le fichier lié si existe
        if ($archive->fichier && Storage::disk('public')->exists($archive->fichier)) {
            Storage::disk('public')->delete($archive->fichier);
        }

        $archive->delete();

        return redirect()->route('archives.index')->with('success', 'Archive supprimée avec succès.');
    }

    // Télécharger le fichier
   /* public function telecharger($id)
    {
        $archive = Archive::findOrFail($id);

        if (!$archive->fichier || !Storage::disk('public')->exists($archive->fichier)) {
            abort(404);
        }

        return Storage::disk('public')->download($archive->fichier);
    }*/
}
