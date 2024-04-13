@extends('layouts.master')

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل الصلاحيات</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                
                    <div class="float-end">
                        <a class="btn btn-primary" href="{{ route('roles.index') }}">رجوع</a>
                    </div>
                
            </div>
        </div>
    </div>


    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @method('PATCH')
        @csrf
        <div class="row">
            <div class="col-xs-12 mb-3">
                <div class="form-group">
                    <strong>الاسم:</strong>
                    <input type="text" value="{{ $role->name }}" name="name" class="form-control"
                        placeholder="الاسم">
                </div>
            </div>
            <div class="col-xs-12 mb-3">
                <div class="form-group">
                    <strong>الصلاحيات:</strong>
                    <br />
                    @foreach ($permission as $value)
                        <label>
                            <input type="checkbox" @if (in_array($value->id, $rolePermissions)) checked @endif name="permission[]"
                                value="{{ $value->name }}" class="name">
                            {{ $value->name }}</label>
                        <br />
                    @endforeach
                </div>
            </div>
            <div class="col-xs-12 mb-3 text-center">
                <button type="submit" class="btn btn-primary">تعديل</button>
            </div>
        </div>
    </form>


@endsection