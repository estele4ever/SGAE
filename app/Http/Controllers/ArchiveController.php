<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Service;
use App\Models\TypeArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
    
class ArchiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    /*
        public function index()
        {
            // Récupérer les archives depuis la base de données
            $archives = Archive::all(); // Vous pouvez personnaliser la requête selon vos besoins
    
            // Retourner la vue avec les données
            return view('archives.index',compact('archives'));
        }*/
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
        $types = TypeArchive::all();
        $services = Service::all();
        return view('archives.create', compact('types', 'services'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categorie' => 'required|string|max:255',
            'type_id' => 'required|exists:type_archives,id',
            'service_id' => 'required|exists:services,id',     
            'metadata' => 'nullable|string|max:255', 
            'fichier' => 'required|file|max:2048',
        ]);
       
        $destinationPath = public_path('archives');

        // Vérifier si le dossier existe, et le créer s'il n'existe pas
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true, true);
            // Les paramètres de makeDirectory sont :
            // 1. Le chemin du dossier à créer
            // 2. Les permissions (0755 est courant pour les dossiers web)
            // 3. recursive (true pour créer les dossiers parents si nécessaire)
            // 4. force (true pour créer le dossier même s'il existe déjà)
        }

        // Enregistrement du fichier dans public/archives/
        $fichier = $request->file('fichier');
        $fichierNom = time() . '_' . $fichier->getClientOriginalName();
        $fichier->move($destinationPath, $fichierNom); // Utiliser $destinationPath

        Archive::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'categorie' => $request->categorie,
            'type_id' => $request->type_id, // Utilisation de la valeur sélectionnée
            'service_id' => $request->service_id, // Utilisation de la valeur sélectionnée
            'metadata' => $request->metadata, // Enregistrement des métadonnées telles quelles
            'fichier' => 'archives/' . $fichierNom,
        ]);
//dd($request->all());
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
}