<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Archive; // Assurez-vous que ces modèles existent
use App\Models\Service;
use App\Models\User;
use App\Models\TypeArchive;
use Illuminate\View\View;

class DashboardController extends Controller
{
    //
  


    public function index(): View
    {
        $archiveCount = Archive::count();
        $serviceCount = Service::count();
        $userCount = User::count();
        $archiveTypeCount = TypeArchive::count();
//dd($archiveCount, $serviceCount, $userCount, $archiveTypeCount);
        return view('dashboard', [
            'archiveCount' => $archiveCount,
            'serviceCount' => $serviceCount,
            'userCount' => $userCount,
            'archiveTypeCount' => $archiveTypeCount,
        ]);
    }
    public function Accueil(): View
    {
        return view('Accueil');
    }
}
