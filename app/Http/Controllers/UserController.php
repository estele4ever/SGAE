<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   public function index(Request $request)
{
    $services = Service::all(); // On suppose que tu as un modèle Service pour récupérer les services
    $roles = Role::all(); // Idem pour les rôles
    
    $query = User::query();

    // Appliquer le filtrage uniquement si l'utilisateur a choisi un service ou un rôle
    if ($request->filled('service')) {
        $query->where('service_id', $request->service);
    }

    if ($request->filled('role')) {
        $query->where('role', $request->role);
    }

    $users = $query->get();

    return view('usermanage.index', compact('users', 'services', 'roles'));
}


    public function create()
    {
        $roles = Role::all(); 
        $services = Service::all();

        return view('usermanage.createuser', compact('roles', 'services'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required',
            'permission' => 'nullable',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'permission' => $validated['permission'] ?? '',
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit($id)
{
    $users = User::findOrFail($id);
    $roles = Role::all();
    $services = Service::all(); 

    return view('usermanage.edituser', compact('users', 'roles', 'services'));
}

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,{$user->id}",
            'role' => 'required',
            'permission' => 'nullable',
        ]);

        $user->update($validated);
        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }
}
