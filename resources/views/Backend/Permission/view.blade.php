@extends('layouts.MasterDashboard')

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
                            
                            <div class="col-sm-6">
                                <h4 class="page-title">PERMISSION DETIALS </h4>
                            </div>
                            
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Training Center Management System</a></li>
                                    <li class="breadcrumb-item active"> PERMISSION  </li>
                                    <li class="breadcrumb-item active"> PERMISSION DETIALS</li>
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
                                                        <th>Permission Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">{{$permission->id}}</th>
                                                        <td>{{$permission->name}}</td>
                                                        <td>
                                                        <a href="{{ route('permission.edit' , $permission->id) }}" class="btn btn-warning btn-sm" title="Edit Role"><i class="fa fa-edit"></i></a>
                                                        
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