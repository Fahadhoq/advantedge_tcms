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
                                <h4 class="page-title">CLASS CREATE</h4>
                            </div>
                            
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Training Center Management System</a></li>
                                    <li class="breadcrumb-item active">CLASS </li>
                                    <li class="breadcrumb-item active">CLASS CREATE</li>
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
                                <form action="{{ route( 'class.create' ) }}" method="post" >
                                @csrf

                                <div class="form-group">
                                    <lable style=font-weight:bold>Class Name </lable>
                                    <input type="text" class="form-control" name="ClassName" value="{{ old('ClassName') }}" placeholder="Enter Class name" >
                                </div>

                                <div class="form-group "> 
                                    <label >School / Collage / University</label>
                                        <div >
                                            <select class="form-control" name="AcademicType" id="AcademicType" >
                                                    <option value="">Choose any one </option>
                                                    <option   value="1" > School</option> 
                                                    <option   value="2" > Collage</option> 
                                                    <option   value="3" > University</option> 
                                                    <option   value="4" > Other</option> 
                                            </select>
                                        </div>
                                </div>
                                
                            

                                 <div style=text-align:center class="col-xl-12">
                                         <!-- submit button    -->
                                         <button id="submit" type="submit" class="btn btn-primary">Submit</button>
                                        <!-- button end -->
                                        
                                        </form> 
                                        <!-- from end -->

                                        <!-- cancle from -->
                                        <a href="{{ route( 'class.index' ) }}" class="btn btn-danger"> {{ __('cancle') }}</a>
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