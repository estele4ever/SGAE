<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $archives = Archive::all();
        return view('archives.index', compact('archives'));
    }

        public function create()
        {
            $services = Service::all(); // Récupère tous les services existants
            return view('archives.create', compact('services'));

        }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categorie' => 'required|string|max:255',
            'type_id' => 'required|string|max:255',
            'service_id' => 'required|string|max:255',
            'metadata' => 'required|string|max:255',
            'fichier' => 'required|file|max:2048', // Limite de 2 Mo
        ]);
 // Enregistrement du fichier dans public/archives/
 $fichier = $request->file('fichier');
 $fichierNom = time() . '_' . $fichier->getClientOriginalName(); // Ajout d'un timestamp pour éviter les doublons
 $fichier->move(public_path('archives'), $fichierNom); // Déplacement du fichier dans public/archives

        // Création de l'archive
        Archive::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'categorie' => $request->categorie,
            'type_id' => $request->categorie,
            'service_id' => $request->categorie,
            'metadata' => $request->categorie,
            'fichier' => 'archives/' . $fichierNom, // Stocke le chemin relatif
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
}
