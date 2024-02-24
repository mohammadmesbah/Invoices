@extends('layouts.master')
@section('title')
المنتجات
@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/css/icons.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/css/bootstrap.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الإعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')

@if (session()->has('Add'))
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		<strong>{{session()->get('Add')}}</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
@endif

<a class="btn ripple btn-primary mb-3" data-target="#select2modal" data-toggle="modal" href="">إضافة منتج</a>

		<!-- Basic modal -->
		<div class="modal" id="select2modal">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">إضافة منتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<form action="{{route('products.store')}}" method="POST">
							@csrf
							<div class="mb-3">
							  <label for="exampleInputName" class="form-label">اسم المنتج</label>
							  <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp">
							</div>
							<div class="form-floating">
								<label for="floatingTextarea">الوصف</label>
								<textarea class="form-control mb-3" name="description" placeholder="Write a description here" id="description"></textarea>
							  </div>
							
							  <select class="form-control" name="section_id" id="section_name" aria-label="Default select example">
								<option selected disabled>الفسم</option>
							@foreach ($sections as $section)
								<option value="{{$section->id}}">{{$section->name}}</option>
							@endforeach								
							  </select>

					</div>
					<div class="modal-footer">
						<button class="btn ripple btn-primary" type="submit">إضافه</button>
						<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إلغاء</button>
					</div>
				</form>

				</div>
			</div>
		</div>
		<!-- End Basic modal -->
				<!-- row -->
				<div class="row">

					<table class="table table-bordered">
						<thead class="table-light">
						  <tr>
							<th scope="col">#</th>
							<th scope="col">اسم المنتج</th>
							<th scope="col">الوصف</th>
							<th scope="col">القسم</th>
							<th scope="col">العمليات</th>
						  </tr>
						</thead>
						<tbody class="table-group-divider">
						@foreach ($products as $product)
						
						  <tr>
							<th scope="row">{{$loop->iteration}}</th>
							<td>{{$product->name}}</td>
							<td>{{$product->description}}</td>
							<td>{{$product->section_id}}</td>
							<td></td>
						  </tr>
						  	
						@endforeach
						
						</tbody>
					  </table>
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
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
@endsection