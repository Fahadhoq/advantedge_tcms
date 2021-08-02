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
                                <h4 class="page-title">ROLE CREATE</h4>
                            </div>
                            
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Training Center Management System</a></li>
                                    <li class="breadcrumb-item active">ROLE </li>
                                    <li class="breadcrumb-item active">ROLE CREATE</li>
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
                             <div class="col-xl-6">
                                <form action="{{ route( 'roles.create' ) }}" method="post" >
                                @csrf
                                <div class="form-group">
                                    <lable style=font-weight:bold>Role Name </lable>
                                    <input type="text" class="form-control" name="RoleName" value="{{ old('RoleName') }}" placeholder="Enter Role name" >
                                </div>
                                
                                <div class="form-group">
                                    <lable style=font-weight:bold>Permission Name List </lable></br></br>
                                    
                                    @foreach($Permissions as $permission)
                                    <input type="checkbox" name="permission[]" value="{{$permission->id}}" > {{$permission->name}} <br>
                                    @endforeach
                                </div>

                                 <div style=text-align:center class="col-xl-12">
                                         <!-- submit button    -->
                                         <button id="submit" type="submit" class="btn btn-primary">Submit</button>
                                        <!-- button end -->
                                        
                                        </form> 
                                        <!-- from end -->

                                        <!-- cancle from -->
                                        <a href="{{ route( 'roles.index' ) }}" class="btn btn-danger"> {{ __('cancle') }}</a>
                                        <!-- cancle from end -->
                                    <div> 


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