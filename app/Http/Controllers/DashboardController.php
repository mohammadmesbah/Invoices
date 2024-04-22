<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $count_all =Invoice::count();
        $count_paidInvoices = Invoice::where('value_status', 1)->count();
        $count_partialPaidInvoices = Invoice::where('value_status', 2)->count();
        $count_unpaidinvoices = Invoice::where('value_status', 3)->count();



        $chartjs = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 360, 'height' => 200])
        ->labels(['الفواتير الغير مدفوعه', 'الفواتير المدفوعه','الفواتير المدفوعه جزئيا','إجمالى الفواتير'])
        ->datasets([
            [
                "label" => "الفواتير الغير مدفوعه",
                'backgroundColor' => ['#E72929', ],
                'data' => [$count_unpaidinvoices / $count_all *100 , ]
            ],
            [
                "label" => "الفواتير المدفوعه",
                'backgroundColor' => ['#416D19',],
                'data' => [$count_paidInvoices / $count_all *100,]
            ],
            [
                "label" => "الفواتير المدفوعه",
                'backgroundColor' => ['#FDA403'],
                'data' => [$count_partialPaidInvoices / $count_all *100]
            ],
            [
                "label" => "إجمالى الفواتير",
                'backgroundColor' => ['#121481'],
                'data' => [100]
            ],
        ])
        ->options([]);

         $chartjsPie = app()->chartjs
         ->name('pieChartTest')
         ->type('doughnut')
         ->size(['width' => 290, 'height' => 200])
         ->labels(['الفواتير الغير مدفوعه','الفواتير المدفوعه جزئيا','الفواتير المدفوعه'])
         ->datasets([
             [
                 'backgroundColor' => ['#E72929','#FDA403','#416D19'],
                 'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                 'data' => [$count_unpaidinvoices / $count_all *100 , $count_partialPaidInvoices / $count_all *100,
                 $count_paidInvoices / $count_all *100]
             ]
         ])
         ->options([]);

        return view('dashboard', compact('chartjs','chartjsPie'));
    }
}
