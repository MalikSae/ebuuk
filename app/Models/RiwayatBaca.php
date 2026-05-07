<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatBaca extends Model
{
    protected $table = 'riwayat_baca';

    protected $fillable = ['user_id', 'buku_id', 'halaman_terakhir'];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
