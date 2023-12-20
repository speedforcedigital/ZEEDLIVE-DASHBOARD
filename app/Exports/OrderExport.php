<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrderExport implements FromCollection, WithHeadings, WithStyles
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $serialNumber = 1;

        return $this->orders->map(function ($order) use (&$serialNumber) {
            return [
                'Sr No' => $serialNumber++, // Increment serial number
                'Buyer' => $order->customer->name ?? '',
                'Seller' => $order->seller->name ?? '',
                'Order ID' => $order->order_id,
                'Status' => $order->is_deliverd ? 'Delivered' : ($order->is_shipped ? 'Shipped' : 'Pending'),
                // Add more columns as needed

            ];
        });
    }

    public function headings(): array
    {
        return [
            'Sr No',
            'Buyer',
            'Seller',
            'Order ID',
            'Status',
            // Add more columns as needed
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Make headings bold
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
