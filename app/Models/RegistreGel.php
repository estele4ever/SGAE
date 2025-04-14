<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistreGel extends Model
{
    use HasFactory;
    protected $fillable = ['motif', 'date_gel', 'duree','statut','archive_id'];
    
}
