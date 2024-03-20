@extends('layouts.master')
@section('css')
<!---Internal  Prism css-->
<link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
<!---Internal Input tags css-->
<link href="{{URL::asset('assets/plugins/inputtags/inputtags.css')}}" rel="stylesheet">
<!--- Custom-scroll -->
<link href="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">

@endsection

@section('content')

@section('page-header')
    <!-- breadcrumb -->
    @if (session()->has('delete'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{session()->get('delete')}}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row row-sm">
    <div class="col-lg-12 col-md-12">
        <div class="card" id="basic-alert">
            <div class="card-body">
                <div>
                    
                    <h6 class="card-title mb-1">الفاتوره رقم : {{$invoice->invoice_number}}</h6>
                    <p class="text-muted card-sub-title">القسم : {{$invoice->section->name}}</p>
                </div>
                <div class="text-wrap">
                    <div class="example">
                        <div class="panel panel-primary tabs-style-1">
                            <div class=" tab-menu-heading">
                                <div class="tabs-menu1">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs main-nav-line">
                                        <li class="nav-item"><a href="#tab1" class="nav-link active" data-toggle="tab">بيانات الفاتوره</a></li>
                                        <li class="nav-item"><a href="#tab2" class="nav-link" data-toggle="tab">المدفوعات</a></li>
                                        <li class="nav-item"><a href="#tab3" class="nav-link" data-toggle="tab">المرفقات</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <table class="table">
                                            <thead>
                                              <tr>
                                                <th scope="col">رقم الفاتورة</th>
                                                <th scope="col">تاريخ الفاتورة</th>
                                                <th scope="col">المنتج</th>
                                                <th scope="col">الملاحظات</th>
                                                <th scope="col">المدخل</th>
                                              </tr>
                                            </thead>
                                            <tbody class="table-group-divider">
                                              <tr>
                                                <th scope="row">{{$invoice->invoice_number}}</th>
                                                <td>{{$invoice->invoice_Date}}</td>
                                                <td>{{$invoice->product}}</td>
                                                <td>{{$invoice->note}}</td>
                                                <td>{{$invoice->user}}</td>
                                              </tr>
                                              
                                            </tbody>
                                          </table>
                                    </div>
                                    <div class="tab-pane" id="tab2">
                                        <table class="table">
                                            <thead>
                                              <tr>
                                                <th scope="col">رقم الفاتورة</th>
                                                <th scope="col">القسم</th>
                                                <th scope="col">المنتج</th>
                                                <th scope="col">تاريخ التحصيل</th>
                                                <th scope="col">الملاحظات</th>
                                                <th scope="col">المستخدم</th>
                                                <th scope="col">الحالة</th>
                                              </tr>
                                            </thead>
                                            <tbody class="table-group-divider">
                                              @foreach ($details as $detail)
                                              
                                              <tr>
                                                <th scope="row">{{$detail->invoice_number}}</th>
                                                <td>{{$detail->section}}</td>
                                                <td>{{$detail->product}}</td>
                                                <td>{{$detail->payment_date}}</td>
                                                <td>{{$detail->note}}</td>
                                                <td>{{$detail->user}}</td>
                                                <td>
                                                    @if ($detail->value_status == 1)
                                                    <span class="badge badge-pill badge-success">{{$detail->status}}</span>
                                                    @elseif ($detail->value_status == 2)
                                                    <span class="badge badge-pill badge-warning">{{$detail->status}}</span>
                                                    @else 
                                                    <span class="badge badge-pill badge-danger">{{$detail->status}}</span>
                                                    @endif    
                                                </td>
                                              </tr>
                                              @endforeach

                                            </tbody>
                                          </table>
                                    </div>
                                    <div class="tab-pane" id="tab3">
                                      <table class="table">
                                        <thead>
                                          <tr>
                                            
                                            <th scope="col">رقم الفاتورة</th>
                                            <th scope="col">اسم الفايل</th>
                                            <th scope="col">التاريخ</th>
                                            <th scope="col">المدخل</th>
                                            <th scope="col">العمليات</th>
                                          </tr>
                                        </thead>
                                        <tbody class="table-group-divider">
                                          <tr>
                                            
                                            <th scope="row">{{$attachments->invoice_number}}</th>
                                            <td>
                                              {{-- <iframe src= 
                                  "{{ asset('Attachments/'.$attachments->invoice_number.'/'.$attachments->file_name) }}" 
                                                  width="200"
                                                  height="200"> 
                                          </iframe> --}}
                                          {{$attachments->file_name}}
                                            </td>
                                            <td>{{$attachments->created_at}}</td>
                                            <td>{{$attachments->created_by}}</td>
                                            <td>
                                              <a target="_blank" href="{{url('view_file')}}/{{$attachments->invoice_number}}/{{$attachments->file_name}}" class="btn btn-outline-success" role="button"><i class="fa-solid fa-eye"></i></a>
                                              <a target="_blank" href="{{url('download_file')}}/{{$attachments->invoice_number}}/{{$attachments->file_name}}" class="btn btn-outline-info" role="button"><i class="fa-solid fa-download"></i></a>
                                              <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                              data-id="{{$attachments->id}}" data-file_name="{{$attachments->file_name}}" 
                                              data-invoice_number="{{$attachments->invoice_number}}">
                                                <i class="fa-solid fa-trash"></i>
                                              </button>
                                              
                                          </tr>
                                          
                                        </tbody>
                                      </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <h1 class="modal-title fs-5" id="staticBackdropLabel">هل أنت متأكد من الحذف ؟</h1>
      </div>
      <div class="modal-body">
        <form action="{{route('files.destroy')}}" method="post">
				{{csrf_field()}}
          <input type="text" id="file_name" name="file_name" readonly>
          <input type="hidden" id="id" name="id">
          <input type="hidden" id="invoice_number" name="invoice_number">
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger">Delete</button>
         
      </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!-- Internal Jquery.mCustomScrollbar js-->
<script src="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- Internal Input tags js-->
<script src="{{URL::asset('assets/plugins/inputtags/inputtags.js')}}"></script>
<!--- Tabs JS-->
<script src="{{URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js')}}"></script>
<script src="{{URL::asset('assets/js/tabs.js')}}"></script>
<!--Internal  Clipboard js-->
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.js')}}"></script>
<!-- Internal Prism js-->
<script src="{{URL::asset('assets/plugins/prism/prism.js')}}"></script>
<script src="/bootstrap-5.3.3-dist/js/bootstrap.js"></script>
<script>
	$('#staticBackdrop').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var file_name = button.data('file_name')
		var invoice_number = button.data('invoice_number')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #file_name').val(file_name);
		modal.find('.modal-body #invoice_number').val(invoice_number);
	})
</script>
@endsection