<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckServiceAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        // Utilisateur connecté
        $user = auth()->user();

        // ID de l'archive demandée dans l'URL
        $archiveId = $request->route('id'); 
        $archive = Archive::find($archiveId);

        // Si l'archive n'existe pas ou si l'utilisateur n'est pas dans le bon service
        if (!$archive || $archive->service_id !== $user->service_id) {
            abort(403, "Vous n'avez pas accès à cette archive.");
        }

        // Passe à la requête suivante si tout est valide
        return $next($request);
    }
    }

