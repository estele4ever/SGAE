<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Service;
use App\Models\Role;
use App\Models\User;
use App\Models\TypeArchive;


//dd($request->all());

class SettingsController extends Controller
{
    public function security() {
        $users = User::all(); // Récupère tous les utilisateurs existants
        return view('settings.security', compact('users'));
    }

   
    public function services() {
        $services = Service::all(); // Récupère tous les services existants
        return view('settings.services', compact('services'));
    }

    public function storage() {
        return view('settings.storage');
    }

    public function statistics() {
        return view('settings.statistics');
    }

    ////////////////////////////////GESTION DES TYPES D'ARCHIVES/////////////////////////////////////////

    public function archives() {
        $services = Service::all();
        $archiveTypes = TypeArchive::with('services')->get();
        return view('settings.archives', compact('services', 'archiveTypes'));
    }
    
    public function addArchiveType(Request $request) {

        $request->validate([
            'nom' => 'required|string|max:255',
            //'services_ids' => 'required|array', // Correction : tableau de services
            'services_id' => 'exists:services,id', // Vérifier que chaque service existe
            'description' => 'nullable|string',
        ]);

        $typeArchive = TypeArchive::create([
            'nom' => $request->nom,
            'services_id' => $request->services_id,
            'description' => $request->description
        ]);
    
        // Associer les services sélectionnés
        $typeArchive->services()->attach($request->services_id);
    
        return redirect()->route('settings.archives')->with('success', 'Type d\'archive ajouté avec succès.');
    }
   
public function updateArchiveType(Request $request, $id) {

    $request->validate([
        'nom' => 'required|string|max:255',
       // 'services_id' => 'required|array', // Tableau de services
        'services_id' => 'exists:services,id',
        'description' => 'nullable|string',
    ]);

    $typeArchive = TypeArchive::findOrFail($id);
    $typeArchive->update([
        'nom' => $request->nom,
        'services_id' => $request->services_id,
        'description' => $request->description
    ]);

    // Synchroniser les services sélectionnés
    $typeArchive->services()->sync($request->services_id);

    return redirect()->route('settings.archives')->with('success', 'Type d\'archive mis à jour avec succès.');
}
   
    public function deleteArchiveType($id) {
        $typeArchive = TypeArchive::findOrFail($id);
    
        // Détacher tous les services avant suppression
        $typeArchive->services()->detach();
    
        $typeArchive->delete();
    
        return redirect()->route('settings.archives')->with('success', 'Type d\'archive supprimé.');
    }


    ////////////////////////////////GESTION DES TYPES D'ARCHIVES/////////////////////////////////////////







    
    //////////////////////////////GESTION DES SERVICES/////////////////////////////////
    
    // Ajouter un service
    public function addService(Request $request) {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'statut' => 'required|boolean'
        ]);
        

        Service::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'statut' => $request->statut
        ]);

        return redirect()->route('settings.services')->with('success', 'Service ajouté avec succès.');
    }

    public function storeService(Request $request) {
        return $this->addService($request);
    }

    // Modifier un service
    public function editService($id) {
        $service = Service::findOrFail($id);
        return view('settings.edit_service', compact('service'));
    }
    public function updateService($id){


    }

    public function updateServiceStatus(Request $request, $id)
{
    $request->validate([
        'statut' => 'required|boolean',
    ]);

    $service = Service::findOrFail($id);
    $service->statut = $request->statut;
    $service->save();

    return redirect()->route('settings.services')->with('success', 'Statut du service mis à jour avec succès.');
}

    // Supprimer un service
    public function deleteService($id) {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('settings.services')->with('success', 'Service supprimé avec succès.');
    }

    //////////////////////////////////GESTION DES STOCKAGE/////////////////////////////////////////

    // Nettoyer le stockage
    public function clearStorage() {
        
        Storage::deleteDirectory('archives');
        Storage::makeDirectory('archives');

        return redirect()->route('settings.storage')->with('success', 'Stockage nettoyé avec succès.');
    }



    ///////////////////////////////////GESTION DES ROLES/////////////////////////////////////////
    // Méthode pour afficher la liste des rôles
    public function index()
    {
        $roles = Role::all();
        return view('settings.roles', compact('roles'));
    }

    // Méthode pour ajouter un nouveau rôle
    public function store(Request $request)
    {
        $request->validate([
            'privilege' => 'required|string|max:255',
        ]);

        Role::create([
            'privilege' => $request->privilege,
        ]);

        return redirect()->route('settings.roles')->with('success', 'Rôle ajouté avec succès.');
    }

    // Méthode pour mettre à jour un rôle existant
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'privilege' => 'required|string|max:255',
        ]);

        $role->update([
            'privilege' => $request->privilege,
        ]);

        return redirect()->route('settings.roles')->with('success', 'Rôle mis à jour avec succès.');
    }

    // Méthode pour supprimer un rôle
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('settings.roles')->with('success', 'Rôle supprimé avec succès.');
    }
}