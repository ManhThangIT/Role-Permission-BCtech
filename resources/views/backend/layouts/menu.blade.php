<li class="treeview">
	<a href="#">
		<i class="glyphicon glyphicon-user"></i>
		<span>Manager</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu" style="display: none;">
		<li><a href="{!! route('admin.roles.index') !!}"><i class="glyphicon glyphicon-cog"></i><span>Roles</span></a></li>
		<li><a href="{!! route('admin.users.index') !!}"><i class="glyphicon glyphicon-education"></i><span>Users</span></a></li>
	</ul>
</li>

<li>
    <a href="{!! route('admin.categories.index') !!}"><i class="glyphicon glyphicon-list-alt"></i><span>Categories</span></a>
</li>

<li>
    <a href="{!! route('admin.articles.index') !!}"><i class="glyphicon glyphicon-th-list"></i><span>Articles</span></a>
</li>


