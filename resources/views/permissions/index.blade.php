
@extends('layouts.app')


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Permissions</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/home">Home</a></li>
              <li class="breadcrumb-item active">Permissions</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-10">

            <div class="pull-right">
                @can('permission-create')
                <a class="btn btn-success" href="{{ route('permissions.create') }}"> Create New Permission</a>
                @endcan
            </div>
    @if ($message = Session::get('success'))
    <br>
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
<br>
            
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($permissions as $permission)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $permission->name }}</td>
	        <td>
                <form action="{{ route('permissions.destroy',$permission->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('permissions.show',$permission->id) }}">Show</a>
                    @can('permission-edit')
                    <a class="btn btn-primary" href="{{ route('permissions.edit',$permission->id) }}">Edit</a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('permission-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $permissions->links() !!}
</div>
</div>
</div>
</div>
</div>
@endsection