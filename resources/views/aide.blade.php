@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">📘 Aide - Guide d'utilisation de l'application SGAE</h1>

    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2 text-blue-700">1. Accueil</h2>
        <p>L'écran d'accueil vous souhaite la bienvenue et affiche un résumé de votre activité. Il est accessible via le menu latéral.</p>
    </section>

    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2 text-blue-700">2. Dashboard</h2>
        <p>Le tableau de bord affiche les statistiques globales (nombre d'archives, utilisateurs, actions récentes...).</p>
    </section>

    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2 text-blue-700">3. Archives</h2>
        <ul class="list-disc pl-6 text-gray-700">
            <li><strong>Ajouter une archive :</strong> Cliquez sur "Nouvelle archive", remplissez le formulaire (titre, service, fichier, etc.). Le service est automatiquement assigné à l’utilisateur connecté.</li>
            <li><strong>Rechercher :</strong> Utilisez la barre de recherche rapide pour retrouver des archives.</li>
            <li><strong>Geler une archive :</strong> Cliquez sur "Geler" dans la fiche archive, remplissez le motif et la durée. L’archive ne pourra pas être supprimée pendant ce temps.</li>
            <li><strong>Suppression :</strong> Le bouton de suppression est désactivé si une archive est gelée.</li>
        </ul>
    </section>

    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2 text-blue-700">4. Gestion des utilisateurs</h2>
        <p>Accessible depuis le menu "Gestion des utilisateurs". Vous pouvez :</p>
        <ul class="list-disc pl-6 text-gray-700">
            <li>Créer un nouvel utilisateur avec un rôle (admin ou agent) et l’assigner à un service.</li>
            <li>Modifier ou supprimer un utilisateur.</li>
            <li>Filtrer les utilisateurs par service ou rôle.</li>
        </ul>
    </section>

    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2 text-blue-700">5. Paramètres</h2>
        <p>Dans le menu déroulant "Paramètres", vous pouvez configurer :</p>
        <ul class="list-disc pl-6 text-gray-700">
            <li><strong>Organisation des services :</strong> Créez et gérez les services rattachés aux utilisateurs.</li>
            <li><strong>Profils d'archives :</strong> Définissez les types ou catégories d'archives.</li>
            <li><strong>Règles de stockage :</strong> Configurez les durées ou emplacements de conservation.</li>
            <li><strong>Rôles :</strong> Définissez les droits associés à chaque rôle dans l'application.</li>
        </ul>
    </section>

    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2 text-blue-700">6. Profil & Déconnexion</h2>
        <p>Depuis le menu, accédez à votre profil pour modifier vos informations ou vous déconnecter en toute sécurité.</p>
    </section>

    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2 text-blue-700">7. Navigation et accessibilité</h2>
        <ul class="list-disc pl-6 text-gray-700">
            <li>Le menu latéral reste accessible sur toutes les pages.</li>
            <li>Les éléments actifs sont surlignés pour une meilleure orientation.</li>
            <li>Les zones cliquables sont élargies pour éviter les erreurs de clic.</li>
        </ul>
    </section>

    <div class="text-right">
        <a href="{{ route('Accueil') }}" class="text-blue-600 hover:underline">← Retour à l'accueil</a>
    </div>
</div>
@endsection
