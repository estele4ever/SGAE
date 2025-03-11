<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Service;
use App\Models\User;
use App\Models\TypeArchive;

class SettingsController extends Controller
{
    public function security() {
        $users = User::all(); // Récupère tous les utilisateurs existants
        return view('settings.security', compact('users'));
    }

    public function editUsers() {


        // Implémentez cette méthode si nécessaire
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
        $archiveTypes = TypeArchive::with('service')->get();
        return view('settings.archives', compact('services', 'archiveTypes'));
    }

    public function addArchiveType(Request $request) {
        $request->validate([
            'nom' => 'required|string|max:255',
            'service_id' => 'required|exists:services,id',
            'description' => 'nullable|string',
        ]);

        TypeArchive::create([
            'nom' => $request->nom,
            'service_id' => $request->service_id,
            'description' => $request->description
        ]);

        return redirect()->route('settings.archives')->with('success', 'Type d\'archive ajouté avec succès.');
    }
    public function updateArchiveType($id){

    }
    public function deleteArchiveType($id) {
        TypeArchive::findOrFail($id)->delete();
        return redirect()->route('settings.archives')->with('success', 'Type d\'archive supprimé.');
    }
    
    //////////////////////////////GESTION DES SERVICES/////////////////////////////////
    
    // Ajouter un service
    public function addService(Request $request) {
        $request->validate([
            'name' => 'required|string|unique:services,name',
            'status' => 'required|boolean'
        ]);

        Service::create([
            'name' => $request->name,
            'status' => $request->status
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
}