<?php

namespace App\Exports;

use App\Models\AbsenKerja;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsenKerjaExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AbsenKerja::all();
    }

    public function headings(): array
    {
        return [
            'Nama Karyawan',
            'Tanggal Masuk',
            'Waktu Masuk',
            'Status',
            'Waktu Selesai Kerja',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [ // baris header
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => 'fce4ec'], // pink soft
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin',
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],
        ];
    }
}
