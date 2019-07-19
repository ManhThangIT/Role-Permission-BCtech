@extends('backend.layouts.app')

@section('content')
<section class="content-header">
    <h1 class="pull-left">Articles</h1>
    <h1 class="pull-right">
        @permission('articles.create')
        <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('admin.articles.create') !!}">Add New</a>
        @endpermission
    </h1>
</section>
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="box box-primary">
        <div class="box-body">
            @include('backend.articles.table')
        </div>
    </div>
    <div class="text-center">
        
    </div>
    {{-- {{ $articles->links() }} --}}
</div>
@endsection

