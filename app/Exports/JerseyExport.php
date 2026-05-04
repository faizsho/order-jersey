<?php

namespace App\Exports;

use App\Models\Jersey;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class JerseyExport implements FromCollection, WithHeadings, WithMapping
{
    protected $team_id;

    public function __construct($team_id) {
        $this->team_id = $team_id;
    }

    public function collection() {
        return Jersey::where('team_id', $this->team_id)->get();
    }

    public function headings(): array {
        return ['Nama Punggung', 'Nomor Punggung', 'Ukuran', 'Lengan', 'Kategori'];
    }

    public function map($jersey): array {
        return [
            $jersey->nama_punggung,
            $jersey->nomor_punggung,
            $jersey->ukuran,
            $jersey->lengan,
            $jersey->kategori,
        ];
    }
}