<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nama_team', 'status_order', 'edit_deadline'];

    // Relasi: Tim ini milik siapa?
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Tim ini punya baju apa aja?
    public function jerseys()
    {
        return $this->hasMany(Jersey::class);
    }
}