<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistreGel extends Model
{
    use HasFactory;
    protected $fillable = ['motif', 'duree','statut','archive_id'];
    
    public function archive()
    {
        return $this->belongsTo(Archive::class, 'archive_id');
    }
    
}
