<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Section;
use Illuminate\Http\Request;

class InvoiceReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('reports.invoices_report');
    }

    public function Search_invoices(Request $request)
    {
        //dd(Invoice::all()->where('status',$request->type));
        $radio= $request->rdio;
        if($radio == 1){
            if($request->type == 'All'){
                $invoices= Invoice::all();
                //dd($invoices);
                $type= $request->type;
                return view('reports.invoices_report',compact('type'))->with('details',$invoices);
            }
            else if($request->type && $request->start_at =='' && $request->end_at ==''){
                $invoices= Invoice::select('*')->where('status',$request->type)->get();
                //dd($invoices);
                $type= $request->type;
                return view('reports.invoices_report',compact('type'))->with('details',$invoices);
            }else{
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;
                
                $invoices = Invoice::whereBetween('invoice_Date',[$start_at,$end_at])->where('status',$request->type)->get();
                return view('reports.invoices_report',compact('type','start_at','end_at'))->with('details',$invoices);
            }
        }//====================================================================
    
// في البحث برقم الفاتورة
        else {
            
            $invoices = Invoice::select('*')->where('invoice_number','=',$request->invoice_number)->get();
            return view('reports.invoices_report')->with('details',$invoices);
            
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function customer_report(){
        $sections= Section::all();
        return view('reports.customers_report',compact('sections'));
    }
    public function Search_customers(Request $request)
    {
        if($request->Section && $request->product && $request->start_at == '' && $request->end_at == '')
        {
            $invoices= Invoice::where('section_id',$request->Section)->where('product',$request->product)->get();
            $sections = Section::all();
            return view('reports.customers_report',compact('sections'))->with('details',$invoices);
        }else{
            $start_at= date($request->start_at);
            $end_at= date($request->end_at);
            $invoices= Invoice::whereBetween('invoice_Date',[$start_at,$end_at])->where('section_id',$request->Section)->where('product',$request->product)->get();
            $sections = Section::all();
            return view('reports.customers_report',compact('sections'))->with('details',$invoices);
        }
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return $request;
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
