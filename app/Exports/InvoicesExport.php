<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoicesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Invoice::all();
    }

    public function headings(): array
    {
        return [
            'م','رقم القسم','رقم الفاتوره','تاريخ الفاتوره','تاريخ الاستحقاق',
            'المنتج','الخصم','المبلغ الكلى','العموله','الضريبه',
            'قيمه الخصم','الاجمالى','حالة الدفع','قيمة الحاله','تاريخ الدفع',
            'الملاحظات','سجلت بواسطة','تم المسح','تم الإنشاء','تم التعديل',
            
        ];
    }
}
