
@extends('layouts.app')


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Users</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/permission/home">Home</a></li>
              <li class="breadcrumb-item active">users</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-10">

        <div class="pull-right">
          @can($arrayUser['create'])
            <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
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
   <th>Email</th>
   <th>Roles</th>
   <th width="280px">Action</th>
 </tr>
 @foreach ($data as $key => $user)
  <tr>
    
      <td>{{ ++$i }}</td>
      <td>{{ $user->name }}</td>
      <td>{{ $user->email }}</td>
      <td>
        @if(!empty($user->getRoleNames()))
          @foreach($user->getRoleNames() as $v)
            <label class="badge badge-success">{{ $v }}</label>
          @endforeach
        @endif
      </td>
      <td>
        @can($arrayUser['show'])
        <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
        @endcan
        @can($arrayUser['edit'])
        <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
        @endcan
        @can($arrayUser['delete'])
          {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
              {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
          {!! Form::close() !!}
        @endcan
      </td>
    
  </tr>
 @endforeach
</table>


{!! $data->render() !!}
</div>
</div>
</div>
</div>
</div>

@endsection