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

class BankReportExcelExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithColumnFormatting
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
                'SALARIES FOR '.$date
            ],
            [
                'Staff Name',
                'Sort Code',
                'Bank',
                'Bank Branch',
                'Account Number',
                'Amount',
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
            'B' => 10,
            'C' => 14,
            'D' => 20,
            'E' => 18,
            'F' => 13,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER,
            'E' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
//    public function collection()
//    {
//        return VWSalarySsnit::select('fullname', 'bank_sort_code', 'banker', 'bank_branch', 'bank_account', 'net_income')->where([
//            ['pay_month', $this->report_month],
//            ['pay_year', $this->report_year]
//        ])->orderBy('banker')->get();
//    }
    public function collection()
    {
        return Cache::get('bank_file');
    }
}
