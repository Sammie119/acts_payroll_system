<?php

namespace App\Exports;

use App\Models\VWSalarySsnit;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class GRAReportExcelExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithColumnFormatting
{
    public function __construct($report_month, $report_year)
    {
        $this->report_month = $report_month;
        $this->report_year = $report_year;
    }

    public function headings():array{
        $date = strtoupper($this->report_month).', '.$this->report_year;
        return [
            [
                'STAFF INCOME TAX CONTRIBUTION FOR '.$date
            ],
            [
                '',
                '',
                '',
                'Non Resident',
                '',
                'Secondary',
                'Paid SSNIT',
                'Total',
                'Tax',
                'Total Taxable',
                '',
                'Severance',
                ''
            ],
            [
                'TIN Number',
                'Name of Employee',
                'Position',
                '(Y / N)',
                'Basic Salary',
                'Employment',
                '(Y/N)',
                'Allowances',
                'Relief',
                'Income',
                'Payable GRA',
                'pay paid',
                'Remarks'
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            2    => ['font' => ['bold' => true]],
            3    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            'A1' => ['font' => ['size' => 16]],
            // 'B2' => ['font' => ['italic' => true]],

            // // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 30, 
            'C' => 10,
            'D' => 14,
            'E' => 15,
            'F' => 10,
            'G' => 14, 
            'H' => 15,
            'I' => 10,
            'J' => 15,
            'K' => 15,
            'L' => 10,
            'M' => 10,          
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'J' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'K' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Cache::get('paye_tax');
    }
}


