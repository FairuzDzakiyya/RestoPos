<?php

namespace App\Exports;

use App\Models\Pengajuan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PengajuanExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Pengajuan::with('member')->get()->map(function ($p) {
            return [
                'Nama Pengaju' => $p->member->nama_member ?? '-',
                'Nama Barang' => $p->nama_barang,
                'Tanggal Pengajuan' => $p->tgl_pengajuan,
                'Qty' => $p->qty,
                'Status' => $p->terpenuhi ? 'Terpenuhi' : 'Belum',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Pengaju',
            'Nama Barang',
            'Tanggal Pengajuan',
            'Qty',
            'Status',
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
