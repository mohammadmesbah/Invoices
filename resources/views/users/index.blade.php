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
          @can('اضافة مستخدم')
          
            <a class="btn btn-success" href="{{ route('users.create') }}"><i class="fas fa-plus"></i> إضافة مستخدم</a>
            
          @endcan
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


<table class="table table-bordered table-hover table-striped" style=" text-align: center;">

 <tr>
   <th>الاسم</th>
   <th>الايميل</th>
   <th>الحالة</th>
   <th>الصلاحيه</th>
   <th width="280px">العمليات</th>
 </tr>

 @foreach ($data as $key => $user)
  <tr>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>
      @if ($user->status == 'مفعل')
      <span class="label text-success d-flex">
          <div class="dot-label bg-success"></div>{{ $user->status }}
      </span>
      @else
      <span class="label text-danger d-flex">
          <div class="dot-label bg-danger"></div>{{ $user->status }}
      </span>
      @endif  
    </td>
    <td>
      @if(!empty($user->getRoleNames()))
        @foreach($user->getRoleNames() as $v)
           <label class="badge badge-success text-dark">{{ $v }}</label>
        @endforeach
      @endif
    </td>
    <td>
      @can('عرض مستخدم')
      
       <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">عرض</a>
         
      @endcan
       @can('تعديل مستخدم')
       
       <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">تعديل</a>
         
       @endcan
       @can('حذف مستخدم')
      
        <a class="btn btn-success" href="{{ route('users.destroy',$user->id) }}">مسح</a>
          
       @endcan
    </td>
  </tr>
 @endforeach
</table>
@endsection 