@extends('frontend.layouts.master')

@section('content')


<div class="panel panel-default">
	<div class="panel-heading" style="background-color:#337AB7; color:white;" >
		<h2 style="margin-top:0px; margin-bottom:0px;"> Tin Tức</h2>
	</div>

	<div class="panel-body">
		<!-- item -->
		@foreach ($categories as $category)
		<div class="row-item row">
			<h3>
				<a href="#">Category</a> |
				<small><a href="loaitin.html"><i>subtitle</i></a>/</small>
				<small><a href="loaitin.html"><i>subtitle</i></a>/</small>
				<small><a href="loaitin.html"><i>subtitle</i></a>/</small>
				<small><a href="loaitin.html"><i>subtitle</i></a>/</small>
				<small><a href="loaitin.html"><i>subtitle</i></a>/</small>
			</h3>
			<div class="col-md-12 border-right">
				<div class="col-md-3">
					<a href="chitiet.html">
						<img class="img-responsive" src="image/320x150.png" alt="">
					</a>
				</div>

				<div class="col-md-9">
					<h3>{{ $category->name }}</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, quo, minima, inventore voluptatum saepe quos nostrum provident .</p>
					<a class="btn btn-primary" href="chitiet.html">View Project <span class="glyphicon glyphicon-chevron-right"></span></a>
				</div>

			</div>

			<div class="break"></div>
		</div>
		@endforeach
		<!-- end item -->
	</div>
</div>


@endsection
