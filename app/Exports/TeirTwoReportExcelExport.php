<?php

namespace App\Exports;

use App\Models\VWSalarySsnit;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class TeirTwoReportExcelExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithColumnFormatting
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
                '2ND TIER CONTRIBUTION RETURNS FOR '.$date
            ],
            [
                'Staff Name',
                'SSNIT Number',
                'Ghana Card',
                'Basic Salary',
                'Tier 2',
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            2    => ['font' => ['bold' => true]],

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
            'A' => 30,
            'B' => 20, 
            'C' => 20,
            'D' => 15,
            'E' => 15,           
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return VWSalarySsnit::select('fullname', 'ssnit_number', 'ghana_card', 'basic', 'tier_2')->where([
            ['pay_month', $this->report_month],
            ['pay_year', $this->report_year],
            ['ghana_card', '!=', 'NAN']
        ])->orderBy('staff_number')->get();
        
        
        
        
    }
}
