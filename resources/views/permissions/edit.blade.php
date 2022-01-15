
@extends('layouts.app')


@section('content')
     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Permission</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/permission/home">Home</a></li>
              <li class="breadcrumb-item active">Permissions</li>
              <li class="breadcrumb-item active">Edit Permission</li>
            </ol>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('permissions.index') }}"> Back</a>
            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
<div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-10">


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


     <form action="{{ route('permissions.update',$permission->id) }}" method="POST">
      @csrf
        @method('PUT')


         <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Permission Name:</strong>
                <input type="text" name="name" value="{{ $permission->name }}" class="form-control" placeholder="Name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Slug:</strong>
                <input type="text" name="slug" value="{{ $permission->slug }}" class="form-control" placeholder="Name">
            </div>
        </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Http Uri:</strong>
                <select name="http_uri[]" class="form-control" multiple> 
                  @foreach ($routeAdmin as  $route)
                  @if($route->getPrefix() == 'permission'  && ($route->methods()[0]=='GET' || $route->methods()[0]=='DELETE'))
                    <option value="{{ $route->methods()[0].'::'.$route->uri() }}">{{$route->methods()[0].'::'.$route->uri()}}</option>
                  @endif
                  @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>


    </form>
</div>
</div>
</div>
</div>
</div>
@endsection