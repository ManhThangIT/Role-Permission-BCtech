<!-- Name Field -->
<div class="form-group col-sm-6">
	{!! Form::label('name', 'Name:') !!}
	{!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Display Name Field -->
<div class="form-group col-sm-6">
	{!! Form::label('display_name', 'Display Name:') !!}
	{!! Form::text('display_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
	{!! Form::label('description', 'Description:') !!}
	{!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<div class="col-md-12">
	<div class="box box-info">
		<div class="box-body">
			{!! Form::label('permission', 'Permission') !!}
			<?php $count = 1; $i = 1; ?>
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th rowspan="2" style="text-align: center; vertical-align: middle;">STT</th>
							<th rowspan="2"  style="text-align: center; vertical-align: middle;">Module</th>
							<th colspan="4" style="text-align: center;" >Permission</th>
						</tr>
						<tr>
							<th style="text-align: center; vertical-align: middle;">VIEW</th>
							<th style="text-align: center; vertical-align: middle;">CREATE</th>
							<th style="text-align: center; vertical-align: middle;">UPDATE</th>
							<th style="text-align: center; vertical-align: middle;">DELETE</th>
						</tr>
					</thead>
					<tbody>
						@foreach($pGroups as $key => $value)
						<tr>
							<td style="text-align: center; vertical-align: middle;">{!! $count++ !!}</td>
							<td style="min-width: 200px;" >{!! $key !!}</td>
							<td style="text-align: center; vertical-align: middle;">
								@if(isset($value['read']))
								{!! Form::checkbox('permissions[]', $value['read'], old('permissions'), []) !!}
								@endif
							</td>
							<td style="text-align: center; vertical-align: middle;">
								@if(isset($value['create']))
								{!! Form::checkbox('permissions[]', $value['create'], old('permissions'), []) !!}
								@endif
							</td>
							<td style="text-align: center; vertical-align: middle;">
								@if(isset($value['update']))
								{!! Form::checkbox('permissions[]', $value['update'], old('permissions'), []) !!}
								@endif
							</td>
							<td style="text-align: center; vertical-align: middle;">
								@if(isset($value['delete']))
								{!! Form::checkbox('permissions[]', $value['delete'], old('permissions'), []) !!}
								@endif
							</td>
{{-- 							@foreach($value as $k => $v)
							@if (!in_array($k, ['read', 'update', 'create', 'delete']))
							<td style="text-align: center; vertical-align: middle;">
								{!! Form::checkbox('permissions[]', $v, old('permissions'), []) !!} {!! $k !!}
							</td>
							@endif
							@endforeach --}}
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
	<!-- Submit Field -->
	<div class="form-group col-sm-12">
		{!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
		<a href="{!! route('admin.roles.index') !!}" class="btn btn-default">Cancel</a>
	</div>
