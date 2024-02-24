@extends('layouts.master')
@section('title')
الأقسام
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الإعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الأقسام</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				
				@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

					@if (session()->has('Add'))
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<strong>{{session()->get('Add')}}</strong>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					@endif
					@if (session()->has('Error'))
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>{{session()->get('Error')}}</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				@endif
				@if (session()->has('Edit'))
				<div class="alert alert-info alert-dismissible fade show" role="alert">
					<strong>{{session()->get('Edit')}}</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			@endif
				<!-- row opened -->
				<div class="row row-sm">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
										<a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-sign" data-toggle="modal" href="#modaldemo1">إضافة قسم</a>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table mg-b-0 text-md-nowrap">
										<thead>
											<tr>
												<th>#</th>
												<th>الإسم</th>
												<th>الوصف</th>
												<th>العمليات</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($sections as $section)
											<tr>
												<th scope="row">{{$loop->iteration}}</th>
												<td>{{$section->name}}</td>
												<td>{{$section->description}}</td>
												<td>
												<a data-toggle="modal" href="#exampleModal2" data-id="{{$section->id}}" 
													data-name="{{$section->name}}" data-description="{{$section->description}}"	
													class="modal-effect btn btn-success"><i class="fa-solid fa-pen-to-square"></i></a>
												<a data-toggle="modal" href="#modaldemo9" data-id="{{$section->id}}" data-name="{{$section->name}}" 
													class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
												
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
			
			<!-- Basic modal -->
		<div class="modal" id="modaldemo1">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">إضافة قسم: </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<form action="{{route('sections.store')}}" method="POST">
							@csrf
							<div class="mb-3">
							  <label for="exampleInputEmail1" class="form-label">اسم القسم:</label>
							  <input type="text" class="form-control" name="section_name" id="exampleInputEmail1" aria-describedby="emailHelp">
							  </div>
							  <div class="form-floating">
								<label for="floatingTextarea">الوصف:</label>
								<textarea class="form-control" name="section_description" placeholder="Write a description here" id="floatingTextarea"></textarea>
							  </div>
							  <div class="modal-footer">
								<button class="btn ripple btn-primary" type="submit">إضافة</button>
								<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
							</div>
						  </form>
					</div>
					
				</div>
			</div>
		</div>
		<!-- End Basic modal -->

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

				   <form action="sections/update" method="post" autocomplete="off">
					   {{method_field('patch')}}
					   {{csrf_field()}}
					   <div class="form-group">
						   <input type="hidden" name="id" id="id" value="">
						   <label for="recipient-name" class="col-form-label">اسم القسم:</label>
						   <input class="form-control" name="name" id="name" type="text">
					   </div>
					   <div class="form-group">
						   <label for="message-text" class="col-form-label">ملاحظات:</label>
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
			<form action="sections/destroy" method="post">
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
		var description = button.data('description')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #name').val(name);
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