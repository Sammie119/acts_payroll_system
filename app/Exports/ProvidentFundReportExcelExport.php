<?php

namespace App\Exports;

use App\Models\VWSalarySsnit;
use App\Models\VWTax;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ProvidentFundReportExcelExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithColumnFormatting
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
                'PROVIDENT FUND '.$date
            ],
            [
                'Staff ID',
                'Staff Name',
                'Description',
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
            'A' => 10,
            'B' => 30,
            'C' => 23,
            'D' => 14,
        ];
    }

    public function columnFormats(): array
    {
        return [
            // 'D' => NumberFormat::FORMAT_NUMBER,
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return VWTax::selectRaw("staff_number, fullname, 'Provident Fund', tier_3")->where([
            ['pay_year', $this->report_year],
            ['tier_3', '>', 0]
        ])->whereRaw("pay_month collate utf8mb4_unicode_ci = '$this->report_month'")->orderBy('staff_number')->get();
    }
}





