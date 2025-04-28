<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\RegistreGel;
use App\Models\Service;
use App\Models\TypeArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;

    
class ArchiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
   
        public function index(Request $request)
        {
            $query = Archive::query();
        
            if ($request->has('search') && !empty($request->search)) {
                $query->where('titre', 'like', '%' . $request->search . '%');
            }
        
            $archives = $query->latest()->get(); // trié par date si tu veux
        
            return view('archives.index', compact('archives'));
        }
        
       
        
    public function create()
    {
        $services = Service::where('statut', 1)->get();

        $types = TypeArchive::where('statut', 1)->get();
        return view('archives.create', compact('types', 'services'));
    }


    public function store(Request $request)
    {
        dd($request->all()); 
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',//
            'categorie' => 'required|string|max:255',//
            'archive_profile_id' => 'required|exists:type_archives,id',
            'service_id' => 'required|exists:services,id',
            'champs' => 'nullable|array', // <- ici on valide que champs est bien un tableau
            'fichier' => 'required|file|max:2048',
        ]);
    
        $destinationPath = public_path('archives');
    
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true, true);
        }
    
        $fichier = $request->file('fichier');
        $fichierNom = time() . '_' . $fichier->getClientOriginalName();
        $fichier->move($destinationPath, $fichierNom);
    
        // Préparer les champs dynamiques en JSON
        $metadata = null;
        if ($request->has('champs')) {
            $metadata = json_encode($request->input('champs'));
        }
    
        Archive::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'categorie' => $request->categorie,
            'type_id' => $request->type_id,
            'service_id' => $request->service_id,
            'metadata' => $metadata, // ici on stocke tous les champs dynamiques au format JSON
            'fichier' => 'archives/' . $fichierNom,
        ]);
    
        return redirect()->route('archives.index')->with('success', 'Archive ajoutée avec succès.');
    }     


    public function show($id)
    {
        $archive = Archive::findOrFail($id);
        return view('archives.show', compact('archive'));
    }

    public function destroy($id)
    {
        $archive = Archive::findOrFail($id);

        // Supprimer le fichier
        Storage::delete($archive->fichier);

        // Supprimer l'archive
        $archive->delete();

        return redirect()->route('archives.index')->with('success', 'Archive supprimée avec succès.');
    }

    public function telecharger($id)
    {
        $archive = Archive::findOrFail($id);
    
        $chemin = public_path($archive->fichier); 
    
        if (file_exists($chemin)) {
            return response()->download($chemin);
        }
        return redirect()->back()->with('error', 'Fichier introuvable.');
    }


public function geler(Request $request, $id)
{
    
    $request->validate([
        'motif' => 'required|string',
        'duree' => 'required|integer|min:1',
        'statut' => 'required|boolean'
    ]);
    RegistreGel::create([
        'archive_id' => $id,
        'duree' => $request->duree,
        'motif' => $request->motif,
        'statut' => $request->statut,
        'date_gele' => now(),
    ]);
    
    

    return redirect()->route('archives.show', $id)->with('success', 'L’archive a été gelée avec succès.');
}

}