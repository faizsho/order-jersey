<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jersey extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id', 'nama_punggung', 'nomor_punggung', 'ukuran', 'lengan', 'kategori'
    ];

    // Relasi: Baju ini milik tim apa?
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}