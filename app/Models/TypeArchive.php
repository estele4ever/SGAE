<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeArchive extends Model
{
    use HasFactory;
 
    protected $fillable = ['nom', 'services_id','description','statut','regles_id'];

    // Relation many-to-many avec Service via la table pivot
    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_type_archive');
    }
    public function regles()
    {
        return $this->belongsToMany(Regle::class, 'regle_type_archive');
    }
    public function fields()
{
    return $this->hasMany(ArchiveProfileField::class, 'archive_profile_id');
}
}

