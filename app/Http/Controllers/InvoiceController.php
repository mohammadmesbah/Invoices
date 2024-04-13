<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Models\Invoice;
use App\Models\Invoice_attachment;
use App\Models\Invoice_detail;
use App\Models\Section;
use App\Models\User;
use App\Notifications\AddInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:قائمة الفواتير'], ['only' => ['index']]);
        $this->middleware(['permission:اضافة فاتورة'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:تعديل الفاتورة'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:حذف الفاتورة'], ['only' => ['destroy']]);
        $this->middleware(['permission:تصدير EXCEL'], ['only' => ['export']]);
        $this->middleware(['permission:تغير حالة الدفع'], ['only' => ['changeStatus']]);
        $this->middleware(['permission:ارشفة الفاتورة'], ['only' => ['destroy']]);
        $this->middleware(['permission:طباعةالفاتورة'], ['only' => ['print_invoice']]);
        $this->middleware(['permission:اضافة مرفق'], ['only' => ['store']]);
        $this->middleware(['permission:حذف المرفق'], ['only' => ['deleteAttachment','destroy']]);
        $this->middleware(['permission:الفواتير المدفوعة'], ['only' => ['paid_invoices']]);
        $this->middleware(['permission:الفواتير المدفوعة جزئيا'], ['only' => ['partial_paid_invoices']]);
        $this->middleware(['permission:الفواتير الغير مدفوعة'], ['only' => ['unpaid_invoices']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices= Invoice::all();
        return view('invoices.invoice',compact('invoices'));
    }
    public function paid_invoices()
    {
        $paid_invoices= Invoice::where('value_status',1)->get();
        return view('invoices.paid_invoices',compact('paid_invoices'));
    }
    public function unpaid_invoices()
    {
        $unpaid_invoices= Invoice::where('value_status',3)->get();
        return view('invoices.unpaid_invoices',compact('unpaid_invoices'));
    }
    public function partial_paid_invoices()
    {
        $partial_paid_invoices= Invoice::where('value_status',2)->get();
        return view('invoices.partial_paid_invoices',compact('partial_paid_invoices'));
    }
    
    public function print_invoice($invoice_id)
    {
        $invoice= Invoice::where('id',$invoice_id)->first();
        return view('invoices.print_invoice',compact('invoice'));
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
            'value_status'=> 3,
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
        $user= User::first(); 
        Notification::send($user, new AddInvoice($invoice_id));
        session()->flash('Add','تم إضافة الفاتورة بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show($invoice_id)
    {
        $invoices= Invoice::findOrFail($invoice_id);
        $attachments= $invoices->invoice_attachments;
        return view('invoices.change_status',compact('invoices','attachments'));
    }
    public function changeStatus(Request $request)
    {
        $invoice= Invoice::findOrFail($request->invoice_id);
        if($request->status == "مدفوعة"){
            $invoice->update([
                'status'=> $request->status,
                'value_status'=> 1,
                'payment_date'=>$request->payment_date
            ]);
            Invoice_detail::create([
                'invoice_id'=> $request->invoice_id,
                'invoice_number'=> $request->invoice_number,
                'product'=> $request->product,
                'section'=> $request->Section,
                'status'=> $request->status,
                'value_status'=> 1,
                'payment_date'=>$request->payment_date,
                'note'=> $request->note,
                'user'=> Auth::user()->name
            ]);
        }elseif($request->status == "مدفوعة جزئيا"){
            $invoice->update([
                'status'=> $request->status,
                'value_status'=> 2,
                'payment_date'=>$request->payment_date
            ]);
            Invoice_detail::create([
                'invoice_id'=> $request->invoice_id,
                'invoice_number'=> $request->invoice_number,
                'product'=> $request->product,
                'section'=> $request->Section,
                'status'=> $request->status,
                'value_status'=> 2,
                'payment_date'=>$request->payment_date,
                'note'=> $request->note,
                'user'=> Auth::user()->name
            ]);
        }else{
            redirect('invoices');
        }
        session()->flash('change_status',"تم تعديل حالة الدفع بنجاح");
        return redirect('invoices');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($invoice_id)
    {
        $invoices= Invoice::findOrFail($invoice_id);
        
        $attachments= $invoices->invoice_attachments;
        $sections= Section::all();
        return view('invoices.update_invoice',compact('invoices','sections','attachments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $in_details= Invoice_detail::where('invoice_id',$request->invoice_id)->first();
        $in_attach= Invoice_attachment::where('invoice_id',$request->invoice_id)->first();
        $invoice= Invoice::findOrFail($request->invoice_id);
        //dd($request);
        $invoice->update([
            'invoice_number'=> $request->input('invoice_number'),
            'invoice_Date'=> $request->input('invoice_Date'),
            'due_date'=> $request->input('Due_date'),
            'product'=> $request->input('product'),
            'section_id'=> $request->input('Section'),
            'discount'=> $request->input('Discount'),
            'amount_collection'=> $request->input('Amount_collection'),
            'amount_commission'=> $request->input('Amount_Commission'),
            'rate_vat'=> $request->input('Rate_VAT'),
            'value_vat'=> $request->input('Value_VAT'),
            'total'=> $request->input('Total'),
            'status'=> 'غير مدفوعه',
            'value_status'=> 2,
            'note'=> $request->input('note'),
            'user'=> Auth::user()->name
        ]);

        $invoice_id= $request->invoice_id;
        $in_details->update([
            'invoice_id'=> $invoice_id,
            'invoice_number'=> $request->input('invoice_number'),
            'product'=> $request->input('product'),
            'section'=> $request->input('Section'),
            'status'=> 'غير مدفوعه',
            'value_status'=> 2,
            'note'=> $request->input('note'),
            'user'=> Auth::user()->name
        ]); 

        if($request->hasFile('pic')){
            $this->validate($request,['pic'=>'required|mimes:pdf|max:10000'],['pic.mimes'=> 'خطأ فى حفظ الفاتورة لا بد أن يكون المرفق pdf']);
            $invoice_id= $request->invoice_id;
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
        session()->flash('Edit','تم تعديل الفاتورة بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteAttachment($attach_id){
        $attach= Invoice_attachment::findOrFail($attach_id);
        $attach->delete();
        session()->flash('att_delete','تم حذف الملف بنجاح');
        return back();
    }
     public function destroy(Request $request)
    {
        $invoice= Invoice::findOrFail($request->invoice_id);
        $archive_invoice= $request->archive_invoice;

        if($archive_invoice == 2){
            
            $invoice->delete();
            session()->flash('Archive','تم نقل الفاتوره إلى الأرشيف بنجاح');
            return redirect('/ArchiveInvoices');
        }else{
        $att= Invoice_attachment::where('invoice_id',$request->invoice_id)->first();
        
        if(!empty($att->invoice_number)){
            File::deleteDirectory(public_path().'/Attachments'.'/'.$att->invoice_number);
        }else{
            echo 'file not found';
        }
        $invoice->forceDelete();

        session()->flash('delete','تم حذف الفاتوره بنجاح');
        return redirect('/invoices');
    }
    }
    public function getProducts($id){
        $products= DB::table('products')->where('section_id',$id)->pluck('name','id');
        return json_encode($products);
    }

    public function export() 
    {
        return Excel::download(new InvoicesExport, 'قائمة الفواتير.xlsx');
    }

}
