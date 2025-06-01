<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NotDeletedRecordsExport implements FromArray, WithHeadings
{
    protected $records;

    public function __construct(array $records)
    {
        $this->records = $records;
    }

    public function array(): array
    {
        $excelData = [];

        foreach ($this->records as $record) {
            
            $row = [
                $record['precinto'] ?? '',
                $record['empresa'] ?? '',
            ];

            $excelData[] = $row;
        }

        return $excelData;
    }

    public function headings(): array
    {
        return [
            'Precinto',
            'Empresa',
        ];
    }
}
