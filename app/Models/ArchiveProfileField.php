<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveProfileField extends Model
{
    use HasFactory;

    protected $fillable = [
        'archive_profile_id',
        'nom_champ',
        'type_champ',
        'obligatoire',
        'ordre',
    ];

    public function profile()
    {
        return $this->belongsTo(TypeArchive::class, 'archive_profile_id');
    }
}
