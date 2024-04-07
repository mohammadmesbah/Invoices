@extends('layouts.master')

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل مستخدم</span>
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


    <form action="{{ route('users.update', $user->id) }}" method="PATCH">
        @csrf
        <div class="row">
            <div class="col-xs-12 mb-3">
                <div class="form-group">
                    <strong>الاسم:</strong>
                    <input type="text" value="{{ $user->name }}" name="name" class="form-control"
                        placeholder="الاسم">
                </div>
            </div>
            <div class="col-xs-12 mb-3">
                <div class="form-group">
                    <strong>الايميل:</strong>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control"
                        placeholder="الايميل">
                </div>
            </div>
            <div class="col-xs-12 mb-3">
                <div class="form-group">
                    <strong>كلمة السر:</strong>
                    <input type="password" name="password" class="form-control"
                        placeholder="كلمة السر">
                </div>
            </div>
            <div class="col-xs-12 mb-3">
                <div class="form-group">
                    <strong>تأكيد كلمة السر:</strong>
                    <input type="password" name="confirm-password" class="form-control"
                        placeholder="كلمة السر">
                </div>
            </div>
            <div class="col-xs-12 mb-3">
                <div class="form-group">
                    <strong>الصلاحيات:</strong>
                    <select class="form-control multiple" multiple name="roles[]">
                        @foreach ($roles as $role)
                            <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 mb-3 text-center">
                <button type="submit" class="btn btn-primary">تعديل</button>
            </div>
        </div>
    </form>

@endsection