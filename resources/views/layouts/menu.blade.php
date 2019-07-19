<li>
    <a href="{!! route('admin.users.index') !!}"><i class="fa fa-edit"></i><span>Users</span></a>
</li>

<li>
    <a href="{!! route('admin.categories.index') !!}"><i class="glyphicon glyphicon-list-alt"></i><span>Categories</span></a>
</li>

<li>
    <a href="{!! route('admin.articles.index') !!}"><i class="glyphicon glyphicon-th-list"></i><span>Articles</span></a>
</li>


<li class="{{ Request::is('roles*') ? 'active' : '' }}">
    <a href="{!! route('roles.index') !!}"><i class="fa fa-edit"></i><span>Roles</span></a>
</li>

