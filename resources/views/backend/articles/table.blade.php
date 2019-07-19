<div class="table-responsive">
    <table class="table" id="articles-table">
        <thead>
            <tr>
                <th>Category Id</th>
                <th>User Id</th>
                <th>Name</th>
                <th>Image</th>
                <th>Summary</th>
                <th>Content</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
            <tr>
                <td>{!! $article->category_id !!}</td>
                <td>{!! $article->user_id !!}</td>
                <td>{!! $article->name !!}</td>
                <td>{!! $article->image !!}</td>
                <td>{!! $article->summary !!}</td>
                <td>{!! $article->content !!}</td>
                <td>
                    {{-- @permission('articles.destroy') --}}
                    {!! Form::open(['route' => ['admin.articles.destroy', $article->id], 'method' => 'delete']) !!}
                    {{-- @endpermission --}}
                    <div class='btn-group'>
                        @permission('articles.read')
                        <a href="{!! route('admin.articles.show', [$article->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        @endpermission
                        @permission('articles.update')
                        <a href="{!! route('admin.articles.edit', [$article->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        @endpermission
                        @permission('articles.delete')
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        @endpermission
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
