@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Home Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/permission/home">Home</a></li>
              
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content" style="min-height: 470px;">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-8">
            <div class="card">
              <div class="card-body">

                @canany([$arrayUser['create'],$arrayUser['index'],$arrayUser['edit'],$arrayUser['delete'],$arrayUser['show']])
                <a href="{{ route('users.index') }}" class="card-link">User Management</a>
                @endcanany()
                
                @canany([$arrayProduct['create'],$arrayProduct['index'],$arrayProduct['edit'],$arrayProduct['delete'],$arrayProduct['show']])
                <a href="{{ route('products.index') }}" class="card-link">Product Management</a>
                @endcanany()
                
                @canany([$arrayRole['create'],$arrayRole['index'],$arrayRole['edit'],$arrayRole['delete'],$arrayRole['show']])
                <a href="{{ route('roles.index') }}" class="card-link">Role Management</a>
                @endcanany()
                
                @canany([$arrayPermission['create'],$arrayPermission['index'],$arrayPermission['edit'],$arrayPermission['delete'],$arrayPermission['show']])
                <a href="{{ route('permissions.index') }}" class="card-link">Permission Management</a>
                @endcanany()
                
              </div>
            </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection