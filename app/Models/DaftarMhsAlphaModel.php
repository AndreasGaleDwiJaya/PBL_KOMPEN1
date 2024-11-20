<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DaftarMhsAlphaModel extends Model
{
    use HasFactory;

    protected $table = 'm_daftarmhsalpha'; // Nama tabel
    protected $primaryKey = 'daftarmhsalpha_id'; // Primary key
    protected $fillable = ['mahasiswa_id', 'jumlah_jamalpha', 'periode', 'prodi'];

    /**
     * Relasi ke tabel m_usermahasiswa
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(UserMahasiswaModel::class, 'mahasiswa_id', 'mahasiswa_id');
    }
}
