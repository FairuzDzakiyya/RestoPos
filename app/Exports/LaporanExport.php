<?php

namespace App\Exports;

use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $jenis;
    protected $startDate;
    protected $endDate;
    protected $search;

    public function __construct($jenis = 'transaksi', $startDate = null, $endDate = null, $search = null)
    {
        $this->jenis = $jenis;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->search = $search;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if ($this->jenis === 'penjualan') {
            return $this->getPenjualanData();
        }
        
        return $this->getTransaksiData();
    }

    protected function getTransaksiData()
    {
        $query = Pesanan::with(['karyawan', 'details.menu'])
            ->when($this->startDate, function($q) {
                $q->whereDate('tgl_pesan', '>=', $this->startDate);
            })
            ->when($this->endDate, function($q) {
                $q->whereDate('tgl_pesan', '<=', $this->endDate);
            })
            ->when($this->search, function($q) {
                $q->whereHas('karyawan', function($query) {
                    $query->where('name', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy('tgl_pesan', 'desc')
            ->get();

        return $query;
    }

    protected function getPenjualanData()
    {
        return DetailPesanan::with('menu')
            ->selectRaw('menu_id, sum(qty) as total_qty, sum(subtotal) as total_pendapatan')
            ->when($this->startDate, function($q) {
                $q->whereHas('pesanan', function($query) {
                    $query->whereDate('tgl_pesan', '>=', $this->startDate);
                });
            })
            ->when($this->endDate, function($q) {
                $q->whereHas('pesanan', function($query) {
                    $query->whereDate('tgl_pesan', '<=', $this->endDate);
                });
            })
            ->when($this->search, function($q) {
                $q->whereHas('menu', function($query) {
                    $query->where('menu', 'like', '%'.$this->search.'%');
                });
            })
            ->groupBy('menu_id')
            ->orderBy('total_qty', 'desc')
            ->get();
    }

    /**
     * Map data for each row
     */
    public function map($data): array
    {
        if ($this->jenis === 'penjualan') {
            $harga_modal = $data->menu->harga_modal ?? 0;
            $total_modal = $data->total_qty * $harga_modal;
            $keuntungan = $data->total_pendapatan - $total_modal;
            
            return [
                $data->menu->menu ?? '-',
                $data->menu->stok ?? 0,
                $data->total_qty,
                'Rp'.number_format($keuntungan, 0, ',', '.'),
            ];
        }

        // For transaksi data
        $details = '';
        foreach ($data->details as $detail) {
            $details .= $detail->menu->menu.' (Qty: '.$detail->qty.', Subtotal: Rp'.number_format($detail->subtotal, 0, ',', '.').")\n";
        }

        return [
            $data->id,
            $data->karyawan->name ?? '-',
            $data->tgl_pesan,
            'Rp'.number_format($data->total, 0, ',', '.'),
            $details,
            $data->status,
        ];
    }

    /**
     * Column headings
     */
    public function headings(): array
    {
        if ($this->jenis === 'penjualan') {
            return [
                'Menu',
                'Stok',
                'Stok Terjual',
                'Keuntungan',
            ];
        }

        return [
            'ID Pesanan',
            'Karyawan',
            'Tanggal Pesanan',
            'Total',
            'Detail Menu (Qty, Subtotal)',
            'Status',
        ];
    }

    /**
     * Apply styles to the sheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
            
            // Set alignment for all cells
            'A:Z' => [
                'alignment' => [
                    'wrapText' => true,
                    'vertical' => 'top',
                ],
            ],
        ];
    }
}