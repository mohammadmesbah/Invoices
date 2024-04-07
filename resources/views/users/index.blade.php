@extends('layouts.master')

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إدارة المستخدمين</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb mb-4">
        <div class="pull-left">
                         
        <div class="float-end">
            <a class="btn btn-success" href="{{ route('users.create') }}"> إضافة مستخدم</a>
        </div>
            </h2>
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success my-2">
  <p>{{ $message }}</p>
</div>
@endif


<table class="table table-bordered table-hover table-striped">
 <tr>
   <th>الاسم</th>
   <th>الايميل</th>
   <th>الصلاحيه</th>
   <th width="280px">العمليات</th>
 </tr>
 @foreach ($data as $key => $user)
  <tr>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>
      @if(!empty($user->getRoleNames()))
        @foreach($user->getRoleNames() as $v)
           <label class="badge badge-secondary text-dark">{{ $v }}</label>
        @endforeach
      @endif
    </td>
    <td>
       <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">عرض</a>
       <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">تعديل</a>
        <a class="btn btn-success" href="{{ route('users.destroy',$user->id) }}"> مسح</a>
    </td>
  </tr>
 @endforeach
</table>
@endsection 