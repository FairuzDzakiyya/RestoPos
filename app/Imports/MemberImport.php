<?php

namespace App\Imports;

use App\Models\Member;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MemberImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $tahun = date('Y');
        $bulan = date('m');

        foreach ($rows as $index => $row) {
            // Skip header (baris pertama)
            if ($index === 0) continue;

            // Get the last member number for the current year and month
            $lastKode = Member::selectRaw('COALESCE(MAX(CAST(SUBSTRING(kode_member, 10, 3) AS UNSIGNED)), 0) AS angka')
                ->whereRaw('SUBSTRING(kode_member, 4, 4) = ?', [$tahun])
                ->whereRaw('SUBSTRING(kode_member, 8, 2) = ?', [$bulan])
                ->value('angka');

            $noUrutBaru = $lastKode + 1;

            // Format kode member: MBRYYYYMMXX
            $kode_member = 'MBR' . $tahun . $bulan . str_pad($noUrutBaru, 3, '0', STR_PAD_LEFT);

            // Create the member
            Member::create([
                'kode_member' => $kode_member,
                'nama_member' => $row[0], // Assuming the first column is 'nama_member'
                'alamat' => $row[1], // Assuming the second column is 'alamat'
                'telp' => $row[2], // Assuming the third column is 'telp'
                'email' => $row[3], // Assuming the fourth column is 'email'
            ]);
        }
    }
}