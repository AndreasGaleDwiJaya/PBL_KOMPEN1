<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidKomModel extends Model
{
    use HasFactory;

    protected $table = 'm_bidangkompetensi';
    protected $primaryKey = 'bidkom_id';
    protected $fillable = ['nama_bidkom'];
}

