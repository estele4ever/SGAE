<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Service;
use App\Models\Regle;
use App\Models\Role;
use App\Models\User;
use App\Models\TypeArchive;
use App\Models\ArchiveProfileField;




class SettingsController extends Controller
{
 

    ////////////////////////////////GESTION DES TYPES D'ARCHIVES/////////////////////////////////////////

    public function archives() {
        $services = Service::all();
        $regles = Regle::all();
        $archiveTypes = TypeArchive::with('services')->get();
        $totalProfiles = $archiveTypes->count();
        return view('settings.archives', compact('services', 'archiveTypes', 'totalProfiles','regles'));
    }
    
    public function getProfile($id)
    {
        $profile = TypeArchive::findOrFail($id);
        return response()->json($profile);
    }

    public function editArchiveProfile($id)
    {
        $profile = TypeArchive::findOrFail($id);
        $fields = ArchiveProfileField::where('type_archive_id', $id)->get();
    
        return response()->json([
            'profile' => $profile,
            'fields' => $fields
        ]);
    }
    
    public function getProfileFields($id)
    {
        $fields = ArchiveProfileField::where('archive_profile_id', $id)
            ->orderBy('ordre')
            ->get(['id', 'nom_champ', 'type_champ', 'obligatoire']);
    
        return response()->json($fields);
    }
    
    public function updateArchiveProfile(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'services_id' => 'required|exists:services,id',
            'statut' => 'required|boolean',
            'regles_id' => 'required|string'
        ]);
    
        $profile = TypeArchive::findOrFail($id);
        $profile->update($validated);
    
        return redirect()->route('settings.archives')->with('success', 'Profil d\'archive mis à jour avec succès.');
    }
    public function updateArchiveType($id)
{
    $profile = TypeArchive::findOrFail($id);

    return response()->json([
        'id' => $profile->id,
        'nom' => $profile->nom,
        'description' => $profile->description,
        'statut' => $profile->statut,
        'regle_id' => $profile->regles_id,
        'service_id' => $profile->services_id,
        'regles' => Regle::all(),
        'services' => Service::all()
    ]);

   /* public function updateArchiveType(Request $request, $id)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'nullable|string',
        'statut' => 'required|boolean',
        'regle_id' => 'required|exists:regles,id',
        'service_id' => 'required|exists:services,id',
    ]);

    $archiveType = TypeArchive::findOrFail($id);
    $archiveType->nom = $request->input('nom');
    $archiveType->description = $request->input('description');
    $archiveType->statut = $request->input('statut');
    $archiveType->regles_id = $request->input('regle_id');
    $archiveType->services_id = $request->input('service_id');
    $archiveType->save();

    return redirect()->back()->with('success', 'Type d\'archive mis à jour avec succès.');
}*/
    
}

   

    public function updateTypeStatus(Request $request, $id){
           // dd($request->all(),$id);
            $request->validate([
                'statut' => 'required|boolean',
            ]);

            $types = TypeArchive::findOrFail($id);
            

            $types->statut = $request->statut;
            $types->save();

            return redirect()->route('settings.archives')->with('success', 'Statut du type d\'archive mis à jour avec succès.');
    }
   
    public function deleteArchiveType($id) {
        $typeArchive = TypeArchive::findOrFail($id);
    
        // Détacher tous les services avant suppression
        $typeArchive->services()->detach();
    
        $typeArchive->delete();
    
        return redirect()->route('settings.archives')->with('success', 'Type d\'archive supprimé.');
    }



    public function addArchiveProfile(Request $request){
        // 1. Valider les données principales

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'services_id' => 'required|exists:services,id',
            'statut' => 'required|boolean',
            'champs.nom_champ' => 'array',
            'champs.type_champ' => 'array',
            'regles_id' => 'required|string'
        ]);
        
        $regle = Regle::findOrFail($validated['regles_id']);
        // 2. Créer le profil
        $profile = TypeArchive::create([
            'nom' => $validated['nom'],
            'description' => $validated['description'],
            'services_id' => $validated['services_id'],
            'statut' => $validated['statut'],
            'regles_id' => $regle->nom
        ]);
        // 3. Ajouter les champs
        foreach ($request->champs['nom_champ'] as $index => $nom_champ) {
            ArchiveProfileField::create([
                'archive_profile_id' => $profile->id,
                'nom_champ' => $nom_champ,
                'type_champ' => $request->champs['type_champ'][$index],
                'obligatoire' => isset($request->champs['obligatoire'][$index]) ? 1 : 0,
                'ordre' => $index,
            ]);
        }

        return redirect()->back()->with('success', 'Profil d\'archive créé avec ses champs.');
    }

    // ArchiveProfile.php
public function regle()
{
    return $this->belongsTo(Regle::class);
}

    

    ////////////////////////////////GESTION DES TYPES D'ARCHIVES/////////////////////////////////////////







    
    //////////////////////////////GESTION DES SERVICES/////////////////////////////////
    
    public function services() {
        $services = Service::all(); // Récupère tous les services existants
        $totalServices = $services->count();

        return view('settings.services', compact('services','totalServices'));
    }
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
    public function updateService(Request $request,$id){
        $request->validate([
            'nom' => 'required|string|max:255',
            'statut' => 'required|boolean',
            'description' => 'nullable|string'
        ]);
    
        $service = Service::findOrFail($id);
        $service->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'statut' => $request->statut
        ]);
    
        return redirect()->route('settings.services')->with('success', 'Service mis à jour avec succès.');
    
        
    }

    public function updateServiceStatus(Request $request, $id){
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

    



    ///////////////////////////////////GESTION DES ROLES/////////////////////////////////////////
    // Méthode pour afficher la liste des rôles
    public function index()
    {
        $roles = Role::all();
        $totalRole = $roles->count();

        return view('settings.roles', compact('roles','totalRole'));
    }

    // Méthode pour ajouter un nouveau rôle
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Role::create([
            'name' => $request->privilege,
        ]);

        return redirect()->route('settings.roles')->with('success', 'Rôle ajouté avec succès.');
    }

    // Méthode pour mettre à jour un rôle existant
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role->update([
            'name' => $request->privilege,
        ]);

        return redirect()->route('settings.roles')->with('success', 'Rôle mis à jour avec succès.');
    }

    // Méthode pour supprimer un rôle
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('settings.roles')->with('success', 'Rôle supprimé avec succès.');
    }



//////////////////////////////////GESTION DES STOCKAGE/////////////////////////////////////////

    // Nettoyer le stockage
    public function clearStorage() {
        Storage::deleteDirectory('archives');
        Storage::makeDirectory('archives');

        return redirect()->route('settings.storage')->with('success', 'Stockage nettoyé avec succès.');
    }

   

// Utilisation
    
    public function security() {
        $users = User::all(); // Récupère tous les utilisateurs existants
        return view('settings.security', compact('users'));
    }

   

    public function statistics() {
        return view('settings.statistics');
    }

    //////////////////////////////  REGLE DE CONSERVATION///////////////////////////////////////
    public function formatSize($bytes, $decimals = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$units[$factor];
    }

    public function regles() {
        $regles = Regle::all();

        $files = Storage::files();
        $totalSize = 0;

        foreach ($files as $file) {
            $totalSize += Storage::size($file);
        }
        //dd($totalSize); // Pour déboguer et voir la taille formatée

        $formattedSize = $this->formatSize($totalSize);

        return view('settings.storage', compact('regles', 'formattedSize'));
    }
    function convertDaysToPeriod($days) {
        $years = floor($days / 365);
        $days %= 365; // Reste après avoir calculé les années
    
        $months = floor($days / 30);
        $days %= 30; // Reste après avoir calculé les mois
    
        // Construction de la chaîne
        $period = [];
        if ($years > 0) {
            $period[] = $years . ' an' . ($years > 1 ? 's' : '');
        }
        if ($months > 0) {
            $period[] = $months . ' mois';
        }
        if ($days > 0) {
            $period[] = $days . ' jour' . ($days > 1 ? 's' : '');
        }
    
        return implode(' ', $period);
    }
    
    // Exemples d'utilisation
    //echo convertDaysToPeriod(50);   // 1 mois 20 jours
    //echo convertDaysToPeriod(105);  // 3 mois 15 jours
    //echo convertDaysToPeriod(450);  // 1 an 2 mois 25 jours
    // Ajouter un service
    public function addRegle(Request $request) {
        $tempo = $request->temporalite;
        $duree = $request->duree;
        if($tempo == 2){
            $duree *= 30; 
        }
        else if($tempo == 3){
            $duree *=365;
        }
        
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string'
        ]);
        

         Regle::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'duree' => $duree
        ]);
        return redirect()->route('settings.regles')->with('success', 'Regle ajouté avec succès.');
    }

    public function storeRegle(Request $request) {
        return $this->addRegle($request);
    }

    // Modifier un service
    public function editRegle($id) {
        $regle = Regle::findOrFail($id);
        return view('settings.edit_regle', compact('regle'));
    }
    public function updateRegle(Request $request,$id){
        $request->validate([
            'nom' => 'required|string|max:255',
            'duree' => 'required|integer',
            'description' => 'nullable|string'
        ]);
    
        $regle = Regle::findOrFail($id);
        $regle->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'duree' => $request->duree
        ]);
    
        return redirect()->route('settings.regles')->with('success', 'Regle mis à jour avec succès.');
    
        
    }

   

    // Supprimer un service
    public function deleteRegle($id) {
        $regles = Regle::findOrFail($id);
        $regles->delete();

        return redirect()->route('settings.regles')->with('success', 'Regle supprimé avec succès.');
    }

}