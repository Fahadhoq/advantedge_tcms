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
                                <h4 class="page-title">ROLE DETAILS</h4>
                            </div>
                            
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Training Center Management System</a></li>
                                    <li class="breadcrumb-item active">ROLE </li>
                                    <li class="breadcrumb-item active"> ROLE DETAILS </li>
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
                                                        <th>ROLL Name</th>
                                                        <th>ROLL HAS PERMISSION</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">{{$Role->id}}</th>
                                                        <td>{{$Role->name}}</td>
                                                        <td>
                                                        @foreach($PerName as $key => $PerName)
                                                          @foreach($PerName as $PerNam)
                                                               {{@$PerNam->name}}</br>
                                                          @endforeach
                                                        @endforeach
                                                        </td>
                                                        <td>
                                                        <a href="{{ route('Role.edit' , $Role->id) }}" class="btn btn-warning btn-sm" title="Edit Role"><i class="fa fa-edit"></i></a>
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