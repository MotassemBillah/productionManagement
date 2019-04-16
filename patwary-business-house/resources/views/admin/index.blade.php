@extends('admin.layouts.master')
@section('content')
	@if ( Auth::user()->type == 'admin' )
	    @include('admin.layouts.admin_dashboard')
	@else
	    @include('admin.layouts.institute_dashboard')
	@endif
@endsection