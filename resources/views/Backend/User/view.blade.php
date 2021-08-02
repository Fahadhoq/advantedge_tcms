@extends('layouts.MasterDashboard')

@section('css')

@endsection

@section('container')

<!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content">               
                 <div class="container-fluid">
                    

                    <!-- start page-title -->
                    <div class="page-title-box">
                        
                        <!-- start row -->
                        <div class="row align-items-center">
                            
                            <div class="col-sm-4">
                                <h4 class="page-title">USER DETAILS </h4>
                            </div>
                            
                            <div class="col-sm-3" style="background-color:#92cd00">
                                <h4 class="page-title" style=text-align:center>@if(isset($is_deleted))  THE USER WAS DELETED  @endif </h4>
                            </div>

                            <div class="col-sm-5">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Training Center Management System</a></li>
                                    <li class="breadcrumb-item active">USER </li>
                                    <li class="breadcrumb-item active"> USER DETAILS </li>
                                </ol>
                            </div>
                       
                        </div>
                        <!-- end row -->
                     </div>
                    <!-- end page-title -->


                    <!-- main contaner start -->
               
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card m-b-30">
                                
                                <div class="card-body">
                                   
                                    
                                    <!-- message show -->
                                    @include('layouts.partials.message-show')
                                    <!-- message show end -->

                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead class="thead-default">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>USER Name</th>
                                                        <th>USER profile photo</th>
                                                        <th>USER Phnoe</th>
                                                        <th>USER Email</th>
                                                        <th>USER Role</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">{{$user->id}}</th>
                                                        <td>{{$user->name}}</td>
                                                        <td>
                                                            <img src="{{ url('storage').'/'.@$user->profile_photo_path }}" width="100px" height="80px">
                                                        </td>
                                                        <td>{{$user->phone}}</td>
                                                        <td>{{$user->email}}</td>
                                                        
                                                        
                                                        <td>
                                                        {{$role->name}}
                                                        </td>
                                                                                                           
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                        </div>

                                </div>

                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->


                    <!-- main  contaner end -->
                
                </div>
                <!-- container-fluid -->
            </div>
            <!-- content  -->
        </div>
        <!-- ============================================================== -->
        <!-- End Right content here -->
        <!-- ============================================================== -->

@endsection        