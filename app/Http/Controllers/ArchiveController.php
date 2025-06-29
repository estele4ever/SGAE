<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\RegistreGel;
use App\Models\Regle;
use App\Models\Role ;
use App\Models\Service;
use App\Models\TypeArchive;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;



class ArchiveController extends Controller
{
    // Liste des archives
    public function index(){
        $archives = Archive::whereRaw("deleted_at  >= NOW()")
        ->latest()
        ->get();
       // $archives = Archive::latest()->get()->whereRaw("(archives.deleted_at + (registre_gels.duree || ' days')::interval) >= NOW()");
        $types = TypeArchive::all();
        return view('archives.index', compact('archives', 'types'));
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
            'fichier' => 'required|file|mimes:jpg,jpeg,png,pdf,xls,xlsx,doc,docx,html,htm,zip',
        ]);

        $user = Auth::user();
        $type = TypeArchive::findOrFail($request->archive_profile_id);
    
        $regle_id = Regle::where('nom', $type->regles_id)->firstOrFail();
        $dureearchives = $regle_id->duree;
        $datesuppression = Carbon::now()->addDays($dureearchives);

        // Gestion de l'upload de fichier
        $fichierPath = null;
        if ($request->hasFile('fichier')) {
            $originalName = $request->file('fichier')->getClientOriginalName(); // nom original avec extension
            $fichierPath = $request->file('fichier')->storeAs('archives', $originalName, 'public');
        }
        
        //dd($fichierPath);        // Créer l'archive principale
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
        $champs = json_decode($archive->donnees, true);
    
        // Générer le chemin complet du fichier
        $cheminFichier = asset('storage/' . $archive->fichier);
    
        return view('archives.show', compact('archive', 'champs', 'cheminFichier'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'type_id' => 'required|exists:type_archives,id',
            'fichier' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,xlsx,doc,docx,html,htm,zip|max:20480',
        ]);

        $archive = Archive::findOrFail($id);
        $archive->titre = $request->titre;
        $archive->description = $request->description;
        $archive->type_id = $request->type_id;

        if ($request->hasFile('fichier')) {
            $fichierPath = $request->file('fichier')->store('archives', 'public');
            $archive->fichier = $fichierPath;
        }

        $archive->save();

        return redirect()->route('archives.index')->with('success', 'Archive modifiée avec succès.');
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

    public function gelArchives()
    {
    // Récupérer les archives  dont la durée est dépassée
    $archivesObsoletes = Archive::whereNotNull('deleted_at')
    ->whereRaw("deleted_at < NOW()")
    ->get();
    
    
    //recuperer toutes les archives geler pour degeler
    $archivegeler = Archive::whereNotNull('deleted_at')
    ->whereHas('registreGel', function ($query) {
        $query->where('statut', 1)
            ->whereRaw("(archives.deleted_at + (registre_gels.duree || ' days')::interval) > NOW()");
    })
    ->with('gels') // utile pour accéder à $archive->gels dans la vue
    ->get();
   
        return view('archives.gel', compact('archivesObsoletes' , 'archivegeler'));
    }
    
    public function degeler($id){
    // Supposons que vous ayez un modèle RegistreGel
    RegistreGel::where('archive_id', $id)
        ->where('statut', 1)
        ->update(['statut' => 0]);

    return redirect()->back()->with('success', 'Archive dégélée avec succès.');
    }
    
    public function supprimerArchivesObsoletes(){
    $archives = Archive::whereNotNull('deleted_at')
        ->whereHas('registreGel', function ($query) {
            $query->where('statut', 'actif')
                  ->whereRaw('DATE_ADD(archives.deleted_at, INTERVAL registre_gels.duree DAY) <= NOW()');
        })
        ->with('registreGel')
        ->get();

    foreach ($archives as $archive) {
        // Supprimer le fichier s'il existe
        if ($archive->fichier && Storage::disk('public')->exists($archive->fichier)) {
            Storage::disk('public')->delete($archive->fichier);
        }

        // Supprimer le gel associé
        $archive->registreGel()->delete();

        // Suppression définitive
        $archive->forceDelete();
    }

    return redirect()->route('archives.gel.index')->with('success', 'Toutes les archives obsolètes ont été supprimées.');
}


    public function geler(Request $request, $id)
{
    
    $request->validate([
        'motif' => 'required|string',
        'duree' => 'required|integer|min:1',
        'statut' => 'required|boolean',
    ]);

    RegistreGel::create([
        'archive_id' => $id,
        'motif' => $request->motif,
        'duree' => $request->duree,
        'statut' => $request->statut,
    ]);

    return redirect()->route('archives.show', $id)->with('success', 'L’archive a été gelée avec succès.');
}

}
