
@extends('layouts.app')


@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Roles</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/permission/home">Home</a></li>
              <li class="breadcrumb-item active">Roles</li>
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
         @can($arrayRole['create'])
            <a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role</a>
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
    @foreach ($roles as $key => $role)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $role->name }}</td>
        <td>
          @can($arrayRole['show'])
            <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
          @endcan
              @can($arrayRole['edit'])
                <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
              @endcan
              @can($arrayRole['delete'])
                {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}

                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
              @endcan
        </td>
    </tr>
    @endforeach
</table>


{!! $roles->render() !!}
</div>
</div>
</div>
</div>
</div>


@endsection