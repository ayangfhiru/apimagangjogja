<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'namaLengkap', 'nik', 'jenisKelamin',
        'nomorWhatsapp', 'asalSekolah', 'programStudi',
        'kotaAsal', 'alasanMagang', 'jenisMagang',
        'sistemMagang', 'statusAnda', 'bukuInggris',
        'whatsappDosen', 'programMagang', 'jamKerja',
        'yangDikuasai', 'laptop', 'memilikiAlat',
        'mulaiMagang', 'infoMagang', 'motor', 'tglGabung',
        'curriculumvitae', 'portofolio'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
