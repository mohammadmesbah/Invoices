@extends('layouts.master')
@section('css')
<!--- Internal Select2 css-->
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<!---Internal Fileupload css-->
<link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
<!---Internal Fancy uploader css-->
<link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('title')
تعديل فاتورة
@stop

@section('page-header')
<!-- breadcrumb -->
@if (session()->has('Edit'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>{{session()->get('Edit')}}</strong>
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
@endif
@if (session()->has('att_delete'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>{{session()->get('att_delete')}}</strong>
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
@endif

<div class="breadcrumb-header justify-content-between">
<div class="my-auto">
<div class="d-flex">
<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
تعديل حالة الدفع</span>
</div>
</div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')

<!-- row -->
<div class="row">

<div class="col-lg-12 col-md-12">
<div class="card">
<div class="card-body">
<form action="{{ route('invoices.changeStatus') }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col">
            <input type="hidden" name="invoice_id" value="{{$invoices->id}}">
            <label for="inputName" class="control-label">رقم الفاتورة</label>
            <input type="text" class="form-control" id="inputName" name="invoice_number"
                title="يرجي ادخال رقم الفاتورة" value="{{$invoices->invoice_number}}" readonly>
        </div>

        <div class="col">
            <label>تاريخ الفاتورة</label>
            <input class="form-control fc-datepicker" name="invoice_Date" placeholder="YYYY-MM-DD"
                type="text" value="{{$invoices->invoice_Date}}" readonly>
        </div>

        <div class="col">
            <label>تاريخ الاستحقاق</label>
            <input class="form-control fc-datepicker" name="Due_date" placeholder="YYYY-MM-DD"
                type="text" value="{{$invoices->due_date}}" readonly>
        </div>

    </div>

    {{-- 2 --}}
    <div class="row">
        <div class="col">
            <label for="inputName" class="control-label">القسم</label>
            <select name="Section" class="form-control SlectBox" onclick="console.log($(this).val())"
                onchange="console.log('change is firing')" readonly>
                <!--placeholder-->
                <option value="{{$invoices->section->id}}" selected>{{$invoices->section->name}}</option>
                
            </select>
        </div>

        <div class="col">
            <label for="inputName" class="control-label">المنتج</label>
            <select id="product" name="product" class="form-control" readonly>
                <option value="{{$invoices->product}}">{{$invoices->product}}</option>
            </select>
        </div>

        <div class="col">
            <label for="inputName" class="control-label">مبلغ التحصيل</label>
            <input type="text" class="form-control" id="inputName" name="Amount_collection"
                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                value="{{$invoices->amount_collection}}" readonly>
        </div>
    </div>


    {{-- 3 --}}

    <div class="row">

        <div class="col">
            <label for="inputName" class="control-label">مبلغ العمولة</label>
            <input type="text" class="form-control form-control-lg" id="Amount_Commission"
                name="Amount_Commission" title="يرجي ادخال مبلغ العمولة "
                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                value="{{$invoices->amount_commission}}" readonly>
        </div>

        <div class="col">
            <label for="inputName" class="control-label">الخصم</label>
            <input type="text" class="form-control form-control-lg" id="Discount" name="Discount"
                title="يرجي ادخال مبلغ الخصم "
                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                value="{{$invoices->discount}}" readonly>
        </div>

        <div class="col">
            <label for="inputName" class="control-label">نسبة ضريبة القيمة المضافة</label>
            <select name="Rate_VAT" id="Rate_VAT" class="form-control" onchange="myFunction()" readonly>
                <option value="{{$invoices->rate_vat}}" selected >{{$invoices->rate_vat}}</option>
                
            </select>
        </div>

    </div>

    {{-- 4 --}}

    <div class="row">
        <div class="col">
            <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
            <input type="text" class="form-control" id="Value_VAT" name="Value_VAT" value="{{$invoices->value_vat}}" readonly>
        </div>

        <div class="col">
            <label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
            <input type="text" class="form-control" id="Total" name="Total" value="{{$invoices->total}}" readonly>
        </div>
    </div>

    {{-- 5 --}}
    <div class="row">
        <div class="col">
            <label for="exampleTextarea">ملاحظات</label>
            <textarea class="form-control" id="exampleTextarea" name="note" rows="3" readonly>{{$invoices->note}}</textarea>
        </div>
    </div><br>

    <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
    <h5 class="card-title">المرفقات</h5>

    <div class="col-sm-12 col-md-12">
        
        <table class="table">
          <thead>  
            <th>الملفات</th>
            
          </thead>
          <tbody>
            @foreach ($attachments as $att)
            <tr >
                <td >{{$att->file_name}}</td>
            </tr>
            @endforeach   
          </tbody> 
        </table>
      
        <div class="row">
        <div class="col">
            <label for="inputName" class="control-label">تغير حالة الدفع</label>
            <select name="status" id="" class="form-control" >
                
                <option value="{{$invoices->status}}" selected>{{$invoices->status}}</option>
                <option value="مدفوعة"  >مدفوعة</option>
                <option value="غير مدفوعة"  >غير مدفوعة</option>
                <option value="مدفوعة جزئيا"  >مدفوعة جزئيا</option>
            </select>
        </div>
        <div class="col">
            <label for="inputName" class="control-label">تاريخ الدفع</label>
            <input class="form-control fc-datepicker" name="payment_date" placeholder="YYYY-MM-DD"
             type="text" required>
        </div>
    </div>

    </div><br>

    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">حفظ البيانات</button>
    </div>

</form>
</div>
</div>
</div>
</div>

    </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();

    </script>

@endsection