<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Invoice_attachment;
use App\Models\Invoice_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class InvoiceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $invoice= Invoice::findOrFail($id);
        $details= Invoice_detail::all()->where('invoice_id',$id)->first();
        $attachments= Invoice_attachment::all()->where('invoice_id',$id)->first();
        return view('invoices.invoice_details',compact('invoice','details','attachments'));
    }

    /**
     * Show the form for creating a new resource.
     */
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
    public function show($folder_name, $file_name)
    {
        //$file= Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($folder_name.'/'.$file_name);
        return response()->file(public_path().'/Attachments'.'/'.$folder_name.'/'.$file_name);
    }
    public function download_file($folder_name, $file_name)
    {
        $file= public_path().'/Attachments'.'/'.$folder_name.'/'.$file_name;
        $headers = [
            'Content-Type' => 'application/pdf',
         ];
        return Storage::download($file,"$file_name",$headers);    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice_detail $invoice_detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice_detail $invoice_detail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $folder_name= $request->invoice_number;
        $file_name= $request->file_name;
         //dd(Storage::exists(public_path().'/Attachments'.'/'.$folder_name.'/'.$file_name));
        if(File::exists(public_path().'/Attachments'.'/'.$folder_name.'/'.$file_name)){
            File::delete(public_path().'/Attachments'.'/'.$folder_name.'/'.$file_name);
        }else{
            dd('file not exist');
        }
        $file= Invoice_attachment::findOrFail($request->id);
        $file->delete();
        
        session()->flash('delete','تم حذف الفايل بنجاح');
        return redirect('/invoices');
    }
}
