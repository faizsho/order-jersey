<?php

namespace App\Imports;

use App\Models\Jersey;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class JerseyImport implements ToModel, WithStartRow
{
    protected $team_id;

    public function __construct($team_id) {
        $this->team_id = $team_id;
    }

    // Mulai baca dari baris ke-2 (Baris 1 buat Header)
    public function startRow(): int {
        return 2;
    }

    public function model(array $row)
    {
        // Abaikan jika baris kosong
        if (!isset($row[1])) {
            return null;
        }

        return new Jersey([
            'team_id'        => $this->team_id,
            'nama_punggung'  => $row[1],
            'nomor_punggung' => $row[2],
            'ukuran'         => $row[3] ?? 'L',
            'lengan'         => $row[4] ?? 'Pendek',
            'kategori'       => $row[5] ?? 'Player',
        ]);
    }
}