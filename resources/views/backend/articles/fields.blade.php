<!-- Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_id', 'Category Id:') !!}
    {!! Form::select('category_id', $categories, null, ["class" => "form-control"]) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::select('user_id',$users, null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:') !!}
    <div class="fileupload fileupload-new" data-provides="fileupload">
        <div class="fileupload-preview thumbnail" style="width: 500px; height: 300px">
        </div>

        <div>
            <span class="btn btn-default btn-file">
                <span class="fileupload-new">
                    Add Image
                </span>
                {!! Form::file('image') !!}
            </span>
            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">
                Delete
            </a>
        </div>
    </div>
</div>

<!-- Summary Field -->
<div class="form-group col-sm-6">
    {!! Form::label('summary', 'Summary:') !!}
    {!! Form::text('summary', null, ['class' => 'form-control']) !!}
</div>

<!-- Content Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('content', 'Content:') !!}
    {!! Form::textarea('content', null, ['class' => 'form-control ckeditor', 'name' => 'content']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.articles.index') !!}" class="btn btn-default">Cancel</a>
</div>
@section('jseditor')
<script src="{!! asset('vendor/img/bootstrap-fileupload.js') !!}"></script>
<script>
    CKEDITOR.replace('content',
    {
        filebrowserBrowseUrl: '../../vendor/ckfinder/ckfinder.html',
       filebrowserImageBrowseUrl: '../../vendor/ckfinder/ckfinder.html?type=Images',
       filebrowserUploadUrl: '../../vendor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
       filebrowserImageUploadUrl: '../../vendor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
   });
</script>
@endsection
