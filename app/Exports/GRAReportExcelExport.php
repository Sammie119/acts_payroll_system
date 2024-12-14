<?php

namespace App\Exports;

use App\Models\VWSalarySsnit;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class GRAReportExcelExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithColumnFormatting, WithEvents
{
    public function __construct(public $report_month, public $report_year)
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
                'TIN Number',
                'Name of Employee',
                'Position',
                'Residency /Part-Time /Casual',
                'Basic Salary',
                'Secondary Employment (Y/N)',
                'Paid SSNIT (Y/N)',
                'Total Allowances',
                'Tax Relief',
                'Tier 3',
                'Total Taxable Income',
                'Payable to GRA',
                'Severance pay paid',
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
//            3    => ['font' => ['bold' => true]],

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
            'D' => 16,
            'E' => 15,
            'F' => 14,
            'G' => 14,
            'H' => 15,
            'I' => 10,
            'J' => 10,
            'K' => 15,
            'L' => 15,
            'M' => 12,
            'N' => 10,
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
            'L' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A2:N2'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(13);

                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);

                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
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


