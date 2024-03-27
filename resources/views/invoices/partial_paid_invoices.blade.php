@extends('layouts.master')

@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/css/bootstrap/bootstrap.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
	@section('title')
	الفواتير
	@endsection				
				<!-- breadcrumb -->
@endsection
@section('content')

@if (session()->has('delete'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>{{session()->get('delete')}}</strong>
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
@endif

@if (session()->has('change_status'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>{{session()->get('change_status')}}</strong>
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
@endif
				<!-- row -->
				<div class="row">
						
						<div class="col-xl-12">
							<div class="card mg-b-20">
								<div class="card-header pb-0">
									<div class="d-flex justify-content-between">
										<a href="invoices/create" class="modal-effect btn btn-primary" style="color:white"><i
											class="fas fa-plus"></i>&nbsp; اضافة فاتورة</a>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table  id="example1" class="table key-buttons text-md-nowrap table-striped">
											<thead class="text-uppercase fs-2">
												<tr>
													<th class="border-bottom-0">#</th>
													<th class="border-bottom-0">رقم الفاتورة</th>
													<th class="border-bottom-0">تاريخ الفاتورة</th>
													<th class="border-bottom-0">تاريخ الإستحقاق</th>
													<th class="border-bottom-0">المنتج</th>
													<th class="border-bottom-0">القسم</th>
													<th class="border-bottom-0">الخصم</th>
													<th class="border-bottom-0">نسبة الضريبة</th>
													<th class="border-bottom-0">قيمة الضريبة</th>
													<th class="border-bottom-0">الإجمالى</th>
													<th class="border-bottom-0">الحالة</th>
													<th class="border-bottom-0">الملاحظات</th>
													<th>العمليات</th>
												</tr>

											</thead>
											<tbody>
												@foreach ($partial_paid_invoices as $invoice)
												
												<tr>
													<td>{{$loop->iteration}}</td>
													<td>{{$invoice->invoice_number}}</td>
													<td>{{$invoice->invoice_Date}}</td>
													<td>{{$invoice->due_date}}</td>
													<td>{{$invoice->product}}</td>
													<td>
														<a href="{{url('invoice_details')}}/{{$invoice->id}}"> {{$invoice->section->name}} </a>
													</td>
													<td>{{$invoice->discount}}</td>
													<td>{{$invoice->rate_vat}}</td>
													<td>{{$invoice->value_vat}}</td>
													<td>{{$invoice->total}}</td>
													<td>
														@if ($invoice->value_status == 1)
														    <span class="text-success">{{$invoice->status}}</span>
														@elseif ($invoice->value_status == 2)
														<span class="text-danger">{{$invoice->status}}</span>
														@else 
														<span class="text-warning">{{$invoice->status}}</span>
														@endif
													</td>
													<td>{{$invoice->note}}</td>
													<td>
			<!-- Example single danger button -->
			<div class="dropdown">
				<button aria-expanded="false" aria-haspopup="true" class="btn btn-danger"
				data-toggle="dropdown" id="dropdownMenuButton" type="button">Dropdown Menu <i class="fas fa-caret-down ml-1"></i></button>
				<div  class="dropdown-menu tx-13">
					<a class="dropdown-item" href="{{url('editInvoice')}}/{{$invoice->id}}">تعديل</a>
					<a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">حذف</a>
					<a class="dropdown-item"  href="{{route('invoices.show',$invoice->id)}}">تغير حالة الدفع</a>
				</div>
			</div>
													</td>
												</tr>

													
												@endforeach
											</tbody>
										  </table>
										
									</div>
								</div>
							</div>
						</div>
					
				</div>
				<!-- row closed -->
			</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <h1 class="modal-title fs-5" id="exampleModalLabel">حذف الفاتورة</h1>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			هل أنت متأكد من حذف الفاتورة ؟
		  <form action="invoices/destroy" method="POST">
			{{method_field('delete')}}
			@csrf
			@foreach ($partial_paid_invoices as $invoice)
			
			<input type="hidden" name="invoice_id" value="{{$invoice->id}}">
			@endforeach
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
		  <button type="submit" class="btn btn-danger">حذف</button>
		</div>
	</form>
	  </div>
	</div>
  </div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/js/bootstrap.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
@endsection