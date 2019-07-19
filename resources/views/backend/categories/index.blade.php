@extends('backend.layouts.app')

@section('content')
<section class="content-header">
    <h1 class="pull-left">Categories</h1>
    <h1 class="pull-right">
        @permission('categories.create')
        <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('admin.categories.create') !!}">Add New</a>
        @endpermission
    </h1>
</section>
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="box box-primary">
        <div class="box-body">
            @include('backend.categories.table')
        </div>
    </div>
    <div class="text-center">
        {{-- <textarea name="ckeditor" class="form-control"></textarea> --}}
    </div>
</div>
@endsection
{{-- 
    @section('jseditor')
        <script>
            CKEDITOR.replace('ckeditor');
        </script>
        @endsection --}}

