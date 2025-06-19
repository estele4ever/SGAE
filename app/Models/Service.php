<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
 
    protected $fillable = ['nom', 'description', 'statut'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relation many-to-many avec TypeArchive via la table pivot
    public function typeArchives()
    {
        return $this->belongsToMany(TypeArchive::class, 'service_type_archive');
    }

    // Dans app/Models/Service.php
public function archives()
{
    return $this->hasMany(Archive::class);
}
    public function scopeWithArchivesCount($query)
{
    return $query->withCount('archives');
}
}
