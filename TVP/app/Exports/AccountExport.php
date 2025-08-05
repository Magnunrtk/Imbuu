<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AccountExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $dataToExport;

    public function __construct(Collection $dataToExport)
    {
        $this->dataToExport = $dataToExport;
    }

    public function collection()
    {
        return $this->dataToExport;
    }

    public function headings(): array
    {
        return [
            'ID da Conta',
            'Dias VIP',
            'Data'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:C1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ]
                ]);
            },
        ];
    }
}
