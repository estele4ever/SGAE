<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeArchive extends Model
{
    use HasFactory;
 
    protected $fillable = ['nom', 'description' ,'services_id'];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_type_archive');
    }

}
