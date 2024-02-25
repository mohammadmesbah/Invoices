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

@if (session()->has('Edit'))
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		<strong>{{session()->get('Edit')}}</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
@endif

@if (session()->has('delete'))
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		<strong>{{session()->get('delete')}}</strong>
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
							<td>{{$product->section->name}}</td>
							<td>
								<a data-toggle="modal" href="#exampleModal2" data-id="{{$product->id}}" 
									data-name="{{$product->name}}" data-section_name="{{$product->section->name}}" data-description="{{$product->description}}"	
									class="modal-effect btn btn-success"><i class="fa-solid fa-pen-to-square"></i></a>
								<a data-toggle="modal" href="#modaldemo9" data-id="{{$product->id}}" data-name="{{$product->name}}" 
									class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
							</td>
						  </tr>
						  	
						@endforeach
						
						</tbody>
					  </table>
				</div>
				<!-- row closed -->
<!-- edit -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
   <div class="modal-content">
	   <div class="modal-header">
		   <h5 class="modal-title" id="exampleModalLabel">تعديل القسم</h5>
		   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			   <span aria-hidden="true">&times;</span>
		   </button>
	   </div>
	   <div class="modal-body">

		   <form action="products/update" method="post" autocomplete="off">
			   {{method_field('patch')}}
			   {{csrf_field()}}
			   <div class="form-group">
				   <input type="hidden" name="id" id="id" value="">
				   <label for="recipient-name" class="col-form-label">اسم المنتج:</label>
				   <input class="form-control" name="name" id="name" type="text">
			   </div>
			   <label for="recipient-name" class="col-form-label">القسم: </label>
			   <select class="form-control" name="section_name" id="section_name" aria-label="Default select example">
				
			@foreach ($sections as $section)
				<option>{{$section->name}}</option>
			@endforeach								
			  </select>

			   <div class="form-group">
				   <label for="message-text" class="col-form-label">الوصف:</label>
				   <textarea class="form-control" id="description" name="description"></textarea>
			   </div>
	   </div>
	   <div class="modal-footer">
		   <button type="submit" class="btn btn-primary">تعديل</button>
		   <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
	   </div>
	   </form>
   </div>
</div>
</div>

 <!-- delete -->
 <div class="modal" id="modaldemo9">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close" data-dismiss="modal"
															   type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<form action="products/destroy" method="post">
				{{method_field('delete')}}
				{{csrf_field()}}
				<div class="modal-body">
					<p>هل انت متاكد من عملية الحذف ؟</p><br>
					<input type="hidden" name="id" id="id" value="">
					<input class="form-control" name="name" id="name" type="text" readonly>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
					<button type="submit" class="btn btn-danger">حذف</button>
				</div>
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
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
<script>
	$('#exampleModal2').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var name = button.data('name')
		var section_name = button.data('section_name')
		var description = button.data('description')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #name').val(name);
		modal.find('.modal-body #section_name').val(section_name);
		modal.find('.modal-body #description').val(description);
	})
</script>
<script>
	$('#modaldemo9').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var name = button.data('name')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #name').val(name);
	})
</script>
@endsection