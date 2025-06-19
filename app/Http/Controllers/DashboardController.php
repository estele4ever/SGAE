<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Archive; // Assurez-vous que ces modèles existent
use App\Models\Service;
use App\Models\User;
use App\Models\TypeArchive;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // Ajoutez cette ligne

class DashboardController extends Controller
{
    //
  


    public function Accueil(): View
    {
       
        $archiveCount = Archive::count();
        $serviceCount = Service::count();
        $userCount = User::count();
        $archiveTypeCount = TypeArchive::count();
//dd($archiveCount, $serviceCount, $userCount, $archiveTypeCount);
        return view('Accueil', [
            'archiveCount' => $archiveCount,
            'serviceCount' => $serviceCount,
            'userCount' => $userCount,
            'archiveTypeCount' => $archiveTypeCount,
        ]);
        
    
    }
    public function index()
    {
        // Données de base
        $archiveCount = Archive::count();
        $serviceCount = Service::count();
        $userCount = User::count();
        $archiveTypeCount = TypeArchive::count();

        // Données pour le graphique par service
       
    $servicesWithArchives = Service::query()
        ->select('services.*')
        ->selectSub(function($query) {
            $query->from('archives')
                ->whereColumn('archives.service_id', 'services.nom')
                ->where('archives.created_at', '>=', now()->subMonths(6))
                ->selectRaw('count(*)');
        }, 'archives_count')
        ->get()
        ->map(function($service) {
            $service->monthly_archives = $this->getDailyArchivesCount($service,Carbon::now());
            return $service;
        });
        //dd($servicesWithArchives);
    
        // Données pour le graphique par type d'archive
       $archiveTypes = TypeArchive::select('type_archives.*')
        ->leftJoin('archives', function($join) {
            $join->on(DB::raw('type_archives.id::text'), '=', DB::raw('archives.type_id::text'))
                ->where('archives.created_at', '>=', now()->subMonths(6));
        })
        ->groupBy('type_archives.id')
        ->selectRaw('count(archives.id) as archives_count')
        ->get();

        return view('dashboard', [
            'archiveCount' => $archiveCount,
            'serviceCount' => $serviceCount,
            'userCount' => $userCount,
            'archiveTypeCount' => $archiveTypeCount,
            'servicesWithArchives' => $servicesWithArchives,
            'archiveTypes' => $archiveTypes
        ]);
    }

    /**
     * Récupère le nombre d'archives par mois pour un service donné
     **/
    private function getDailyArchivesCount(Service $service, Carbon $month)
{
    $days = collect();

    // On récupère le nombre de jours dans le mois donné
    $daysInMonth = $month->daysInMonth;

    for ($day = 1; $day <= $daysInMonth; $day++) {
        $count = $service->archives()
            ->whereDate('created_at', Carbon::create($month->year, $month->month, $day))
            ->count();

        $days->push([
            'day' => $day,
            'count' => $count,
        ]);
    }

    return $days;
}

    
}