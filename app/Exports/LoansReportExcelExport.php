<?php

namespace App\Exports;

use App\Models\VWLoanPayment;
use App\Models\VWSalarySsnit;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class LoansReportExcelExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithColumnFormatting
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
                'OTHER LOAN PAYMENT FOR '.$date
            ],
            [
                'Staff ID',
                'Staff Name',
                'Description',
                'Amount',
                'Balance'
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
            'E' => 14,            
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return VWLoanPayment::selectRaw("staff_number, fullname, description, amount_paid, (amount - total_amount_paid) as balance")->where([
            ['pay_year', $this->report_year],
            ['description', '!=', 'Rent Advance']
        ])->whereRaw("pay_month collate utf8mb4_unicode_ci = '$this->report_month'")->orderBy('staff_number')->get();
    }
}
