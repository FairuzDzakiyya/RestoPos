<?php

namespace App\Imports;

use App\Models\AbsenKerja;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AbsenKerjaImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Skip if required fields are empty
            if (empty($row['user_id']) || empty($row['status'])) {
                continue;
            }

            // Convert user identifier to ID
            $user = $this->findUser($row['user_id']);
            if (!$user) {
                continue; // Skip if user not found
            }

            // Create attendance record
            AbsenKerja::create([
                'user_id' => $user->id,
                'status' => $this->validateStatus($row['status']),
                'tgl_absen' => $this->convertExcelDate($row['tgl_absen'] ?? null),
                'jam_keluar' => $this->convertExcelTime($row['jam_keluar'] ?? null),
                'jam_masuk' => $this->convertExcelTime($row['jam_masuk'] ?? null),
            ]);
        }
    }

    /**
     * Find user by ID, name, or role
     */
    protected function findUser($identifier)
    {
        // If numeric, try as ID first
        if (is_numeric($identifier)) {
            return User::find($identifier);
        }

        // Try by name
        $user = User::where('name', $identifier)->first();
        if ($user) {
            return $user;
        }

        // Try by role (if your users have roles)
        return User::where('role', $identifier)->first();
    }

    /**
     * Validate and format status
     */
    protected function validateStatus($status)
    {
        $validStatuses = ['masuk', 'sakit', 'cuti'];
        $status = Str::lower(trim($status));
        
        return in_array($status, $validStatuses) ? $status : 'masuk';
    }

    /**
     * Convert Excel time fraction to proper time format
     */
    protected function convertExcelTime($excelTime)
    {
        if (is_null($excelTime)) {
            return null;
        }

        // If already in time format (HH:MM:SS)
        if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $excelTime)) {
            return $excelTime;
        }

        // If in Excel time fraction format
        if (is_numeric($excelTime)) {
            $seconds = $excelTime * 24 * 60 * 60;
            return gmdate('H:i:s', $seconds);
        }

        // If in other time format (e.g., "9:00 AM")
        try {
            return Carbon::parse($excelTime)->format('H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Convert Excel date serial number or string to MySQL date format
     */
    protected function convertExcelDate($excelDate)
    {
        if (is_null($excelDate)) {
            return now()->format('Y-m-d');
        }

        // If already in date format (YYYY-MM-DD)
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $excelDate)) {
            return $excelDate;
        }

        // If Excel date serial number
        if (is_numeric($excelDate)) {
            // Excel's base date is 1900-01-01 (with 1900 incorrectly treated as leap year)
            $unixTimestamp = ($excelDate - 25569) * 86400;
            return gmdate('Y-m-d', $unixTimestamp);
        }

        // If in other date format (e.g., "17/04/2025")
        try {
            return Carbon::parse($excelDate)->format('Y-m-d');
        } catch (\Exception $e) {
            return now()->format('Y-m-d');
        }
    }
}