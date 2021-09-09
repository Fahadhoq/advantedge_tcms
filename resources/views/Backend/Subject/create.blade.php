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
                                <h4 class="page-title">SUBJECT CREATE</h4>
                            </div>
                            
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Training Center Management System</a></li>
                                    <li class="breadcrumb-item active">SUBJECT </li>
                                    <li class="breadcrumb-item active">SUBJECT CREATE</li>
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
                                <form action="{{ route( 'subject.create' ) }}" method="post" >
                                @csrf
                                    <div class="form-group "> 
                                        <label >Class</label>
                                            <div >
                                                <select class="form-control" name="Class" id="Class" value="{{ old('Class') }}">
                                                    <option value="">Choose one class </option>
                                                    @foreach($Classes as $Class)
                                                     <option  id="{{$Class->id}}" value="{{$Class->id}}">{{$Class->name}}</option>
                                                    @endforeach          
                                                </select>
                                            </div>
                                    </div>        

                                    <div class="form-group">
                                        <lable style=font-weight:bold>Subject Name </lable>
                                        
                                          <input type="text" class="form-control mt-2" name="SubjectName" value="{{ old('SubjectName') }}" placeholder="Enter Subject name" >
                                        
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