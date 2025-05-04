<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MemberExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Member::all();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Alamat',
            'No Telepon',
            'Email',
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
