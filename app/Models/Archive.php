<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre','type_id', 'service_id', 'metadata', 'description',  'fichier','deleted_at'
    ];
   

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function type()
    {
        return $this->belongsTo(TypeArchive::class);
    }
}


