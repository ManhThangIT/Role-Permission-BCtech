<div class="table-responsive">
    <table class="table" id="roles-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Display Name</th>
                <th>Description</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
            <tr>
                <td>{!! $role->name !!}</td>
                <td>{!! $role->display_name !!}</td>
                <td>{!! $role->description !!}</td>
                <td>
                    {{-- @if($role->name <> 'SuperAdmin') --}}
                    {!! Form::open(['route' => ['admin.roles.destroy', $role->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        {{-- @permission('roles.read') --}}
                        <a href="{!! route('admin.roles.show', [$role->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        {{-- @endpermission
                        @permission('roles.update') --}}
                        <a href="{!! route('admin.roles.edit', [$role->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {{-- @endpermission
                        @permission('roles.delete') --}}
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        {{-- @endpermission --}}
                    </div>
                    {!! Form::close() !!}
                </td>
                {{-- @endif --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
