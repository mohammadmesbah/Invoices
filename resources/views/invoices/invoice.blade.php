@extends('layouts.master')
@section('title')
الفواتير
@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
						
						<div class="col-xl-12">
							<div class="card mg-b-20">
								<div class="card-header pb-0">
									<div class="d-flex justify-content-between">
										<a href="invoices/create" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
											class="fas fa-plus"></i>&nbsp; اضافة فاتورة</a>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="example" class="table key-buttons text-md-nowrap">
											<thead>
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
													<th></th>
												</tr>

											</thead>
											<tbody>
												@foreach ($invoices as $invoice)
												
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
													<td></td>
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
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
@endsection