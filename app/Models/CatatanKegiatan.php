<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanKegiatan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'tanggal', 'catatan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
