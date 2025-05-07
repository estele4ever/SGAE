<?php

namespace App\Http\Controllers;

use App\Models\Archive;

use App\Models\Regle;
use App\Models\TypeArchive;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Carbon\Carbon;

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
        //$types = TypeArchive::all();
        $types = TypeArchive::where('statut', 1)->get();
        return view('archives.create', compact('types'));
    }

    // Enregistrement d'une nouvelle archive

    public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'required|string',
        'archive_profile_id' => 'required|exists:type_archives,id',
        'champs' => 'required|array',
        'fichier' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,xlsx|max:20480', // 20MB Max
    ]);

    $user = Auth::user();
    $type = TypeArchive::findOrFail($request->archive_profile_id);
   
    $regle_id = Regle::where('nom', $type->regles_id)->firstOrFail();
    $dureearchives = $regle_id->duree;
    $datesuppression = Carbon::now()->addDays($dureearchives);

    // Gestion de l'upload de fichier
    $fichierPath = null;
    if ($request->hasFile('fichier')) {
        $fichierPath = $request->file('fichier')->store('archives', 'public');
    }

    // Créer l'archive principale
    $archive = Archive::create([
        'titre' => $request->nom,
        'description' => $request->description,
        'type_id' => $request->archive_profile_id,
        'service_id' => $user->service, // Enregistrement automatique du service de l'utilisateur
        'metadata' => json_encode($request->champs), // Sauvegarde tous les champs dynamiques comme métadonnées
        'deleted_at' => $datesuppression,
        'fichier' => $fichierPath, // Sauvegarde le chemin du fichier
    ]);

    return redirect()->route('archives.index')->with('success', 'Archive créée avec succès.');
} 
    // Affichage d'une archive
    public function show($id)
    {
        $archive = Archive::findOrFail($id);
        dd($archive);
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
   public function telecharger($id)
    {
        $archive = Archive::findOrFail($id);
        if (!$archive->fichier || !Storage::disk('public')->exists($archive->fichier)) {
            abort(404);
        }

        return Storage::disk('public')->download($archive->fichier);
    }
}
