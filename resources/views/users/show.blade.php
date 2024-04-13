@extends('layouts.master')

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ عرض مستخدم</span>
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
                <a class="btn btn-primary" href="{{ route('users.index') }}">رجوع</a>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="d-block col-xs-12 mb-3">
        <div class="form-group">
            <strong>الاسم:</strong>
            {{ $user->name }}
        </div>
    </div>
    <div class="d-block col-xs-12 mb-3">
        <div class="form-group">
            <strong>الايميل:</strong>
            {{ $user->email }}
        </div>
    </div>
    <div class="d-block col-xs-12 mb-3">
        <div class="form-group">
            <strong>الحالة:</strong>
            {{ $user->status }}
        </div>
    </div>
    <div class="d-block col-xs-12 mb-3">
        <div class="form-group">
            <strong>الصلاحيات:</strong>
            @if(!empty($user->getRoleNames()))
                @foreach($user->getRoleNames() as $v)
                    <label class="badge badge-success text-dark">{{ $v }}</label>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection 