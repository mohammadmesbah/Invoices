<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Invoice_attachment;
use App\Models\Invoice_detail;
use App\Models\Section;
use Illuminate\Http\Request;

class ArchiveInvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Archive_invoices= Invoice::onlyTrashed()->get();
        return view('invoices.Archive_invoices',compact('Archive_invoices'));
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
    public function show(string $id)
    {
        //
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
    public function update(Request $request)
    {
         $id = $request->invoice_id;
         $restore = Invoice::withTrashed()->where('id', $id)->restore();
         session()->flash('restore_invoice',"تم استعادة الفاتورة بنجاح");
         return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
         $invoices = invoice::withTrashed()->where('id',$request->invoice_id)->first();
         $invoices->forceDelete();
         session()->flash('delete_invoice',"تم حذف الفاتورة بنجاح");
         return redirect('/ArchiveInvoices');
    }
}
