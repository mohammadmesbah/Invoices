<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Invoice_attachment;
use App\Models\Invoice_detail;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices= Invoice::all();
        return view('invoices.invoice',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections= Section::all();
        return view('invoices.add_invoice',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Invoice::create([
            'invoice_number'=> $request->invoice_number,
            'invoice_Date'=> $request->invoice_Date,
            'due_date'=> $request->Due_date,
            'product'=> $request->product,
            'section_id'=> $request->Section,
            'discount'=> $request->Discount,
            'amount_collection'=> $request->Amount_collection,
            'amount_commission'=> $request->Amount_Commission,
            'rate_vat'=> $request->Rate_VAT,
            'value_vat'=> $request->Value_VAT,
            'total'=> $request->Total,
            'status'=> 'غير مدفوعه',
            'value_status'=> 2,
            'note'=> $request->note,
            'user'=> Auth::user()->name
        ]);

        $invoice_id= Invoice::latest()->first()->id;
        Invoice_detail::create([
            'invoice_id'=> $invoice_id,
            'invoice_number'=> $request->invoice_number,
            'product'=> $request->product,
            'section'=> $request->Section,
            'status'=> 'غير مدفوعه',
            'value_status'=> 2,
            'note'=> $request->note,
            'user'=> Auth::user()->name
        ]);

        if($request->hasFile('pic')){
            $this->validate($request,['pic'=>'required|mimes:pdf|max:10000'],['pic.mimes'=> 'خطأ فى حفظ الفاتورة لا بد أن يكون المرفق pdf']);
            $invoice_id= Invoice::latest()->first()->id;
            $image= $request->file('pic');
            $file_name= $image->getClientOriginalName();
            $invoice_number= $request->invoice_number;

            $attachments= new Invoice_attachment();
            $attachments->file_name= $file_name;
            $attachments->invoice_number= $invoice_number;
            $attachments->invoice_id= $invoice_id;
            $attachments->created_by= Auth::user()->name;
            $attachments->save();

            //move picture
            $image_name= $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/'.$invoice_number),$image_name);

        }
        session()->flash('Add','تم إضافة الفاتورة بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
    public function getProducts($id){
        $products= DB::table('products')->where('section_id',$id)->pluck('name','id');
        return json_encode($products);
    }
}
