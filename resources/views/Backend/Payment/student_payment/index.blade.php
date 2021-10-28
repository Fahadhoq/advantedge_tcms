@extends('layouts.MasterDashboard')

@section('css')
<!-- datatable css link add -->
        <style>
            #filter_by_dropdown{
                margin-left : 520px; 
                pointer-events: all;
                position: absolute;
                z-index : 1;
            }
        
        </style>
        @include('layouts.partials.datatable-css')
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
                            
                            <div class="col-sm-5">
                                <h4 class="page-title">ALL STUDENTS ENROLLMENT COURSES </h4>
                            </div>
                            
                            <div class="col-sm-7">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Training Center Management System</a></li>
                                    <li class="breadcrumb-item active">Coures Enrollment </li>
                                    <li class="breadcrumb-item active">Student Coure Enrollment </li>
                                    <li class="breadcrumb-item active">All Students Enrollment Coures</li>
                                </ol>
                            </div>
                       
                        </div>
                        <!-- end row -->
                     </div>
                    <!-- end page-title -->


                    <!-- main contaner start -->
               
                    <div class="row">
                        <div class="col-12">
                            <div class="card m-b-30">
                                
                                <div class="card-body">
                                        
                                        <!-- filter by dropdown -->
                                                <!-- <div class="form-group col-3" id="filter_by_dropdown">  
                                                    <div >
                                                        <select class="form-control" name="" id="select_filter_by_dropdown">
                                                           <option value="0">Filter By </option>
                                                           <option value="1">All Enrollment courses </option>
                                                           <option value="2">Individual User </option>    
                                                        </select>
                                                    </div>
                                                </div> -->
                                        <!-- filter by dropdown end-->        
                                
                                    <!-- message show -->
                                    @include('layouts.partials.message-show')
                                    <!-- message show end -->
                                    

                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">           
                                                <thead class="thead-default all_enrollment_course_show">
                                                    <tr>
                                                        <th style=text-align:center> SL</th>
                                                        <th style=text-align:center> Student ID</th>
                                                        <th style=text-align:center> Student Name</th>
                                                        <th style=text-align:center> Total Course </th>
                                                        <th style=text-align:center> Total Course Fee</th>
                                                        <th style=text-align:center> Paid Amount </th>
                                                        <th style=text-align:center> Due Amount</th>    
                                                        <th style=text-align:center> Action</th>  
                                                    </tr>
                                                </thead>
        
                                          <!-- all_enrollment_course_show div -->
                                                <tbody class="all_enrollment_course_show">
                                                @php $i=1 ; $total_course_fee = 0 ; $total_paid_amount = 0 ; $total_due_amount = 0 @endphp
                                                @foreach($StudentsInfos as $StudentsInfo)
                                                    <tr>
                                                        <td style=text-align:center scope="row">{{$i++}}</td> 
                                                        
                                                        <!-- student info -->
                                                        <td style=text-align:center scope="row">{{$StudentsInfo->user->id}}</td>
                                                        <td style=text-align:center scope="row">{{$StudentsInfo->user->name}}</td>
                                                        <!-- student info end -->

                                                        <!-- course info -->
                                                             @php $courses = App\Models\Student_Course_Enrollment::select('course_id')->where('user_id' , $StudentsInfo->user_id)->count(); @endphp
                                                        <td style=text-align:center scope="row">{{$courses}}</td>
                                                        
                                                        @php $student_total_course_fee = 0  @endphp
                                                        @foreach($StudentsEnrollmentCourses as $StudentsEnrollmentCourse)
                                                             @if($StudentsEnrollmentCourse->user_id == $StudentsInfo->user->id)
                                                                @php $courses_fee = App\Models\Course::select('course_fee')->where('id' , $StudentsEnrollmentCourse->course_id)->first(); @endphp
                                                                
                                                                  @php $student_total_course_fee = $student_total_course_fee + $courses_fee->course_fee; @endphp
                                                               
                                                             @endif
                                                        @endforeach
                                                        <td style=text-align:center scope="row">{{$student_total_course_fee}}</td>
                                                        @php $total_course_fee = $total_course_fee + $student_total_course_fee; @endphp
                                                        <!-- course info end -->
                                                        
                                                        <!--  amount -->
                                                        <!-- paid ammount -->
                                                        @php $student_paid_amount = 0 @endphp
                                                        @foreach($StudentsPayment as $StudentPayment)
                                                             @if($StudentPayment->user_id == $StudentsInfo->user->id) 
                                                                  @php $student_paid_amount = $student_paid_amount + $StudentPayment->payment_amount; @endphp
                                                             @endif
                                                        @endforeach
                                                        <td style=text-align:center scope="row">{{$student_paid_amount}}</td>
                                                        @php $total_paid_amount = $total_paid_amount + $student_paid_amount; @endphp
                                                        <!-- paid ammount end -->

                                                        <!-- due amount -->
                                                        @php $student_due_amount = $student_total_course_fee - $student_paid_amount @endphp
                                                        <td style=text-align:center scope="row">{{$student_due_amount}}</td>
                                                        @php $total_due_amount = $total_course_fee - $total_paid_amount; @endphp
                                                        <!-- due amount end -->
                                                        <!-- amount end  -->
                                                        
                                                        <td style=text-align:center>

                                                            <a href="{{ route('StudentPayment.view' , $StudentsInfo->user->id) }}" class="btn btn-info btn-sm" title="View Payment details"><i class="fa fa-eye"></i></a>
                                                          
                                                            <a href="{{ route('student_payment.edit' , $StudentsInfo->user->id) }}" class="btn btn-warning btn-sm" title="Edit Payment"><i class="fa fa-edit"></i></a>
                                                       
                                                        </td> 
                                                    </tr>
                                                @endforeach  
                                                    <!-- total sum   -->
                                                      <tr>
                                                          <th style=text-align:right colspan="4">Total</th>
                                                          <th style=text-align:center;color:blue>{{$total_course_fee}}</th>
                                                          <th style=text-align:center;color:green>{{$total_paid_amount}}</th>
                                                          <th style=text-align:center;color:red>{{$total_due_amount}}</th>
                                                          <td></td>
                                                      </tr>
                                                    <!-- total sum end -->
                                                </tbody>
                                                <!-- all_enrollment_course_show div end -->


                                               <!-- Individual_user_enrollment_courses_show div -->
                                               <!-- <thead class="thead-default individual_user_enrollment_courses_thead">
                                                    <tr>
                                                        <th style=text-align:center> SL</th>
                                                        <th style=text-align:center> Student ID</th>
                                                        <th style=text-align:center> Student Name</th>
                                                        <th style=text-align:center> Total Enrolled Courses </th>   
                                                        <th style=text-align:center> Action</th>  
                                                    </tr>
                                                </thead>

                                                <tbody class="individual_user_enrollment_courses_show">
                                                 
                                                </tbody> -->
                                                <!-- Individual_user_enrollment_courses_show div end -->


                                        </table>
                                    

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


@section('jquery')
<!-- datatable js link add -->
@include('layouts.partials.datatable-js')
@endsection

@section('script')
<script>

$(document).ready(function(){
    
    //$('.individual_user_enrollment_courses_thead').hide(); 

  
    //filter
    // $(document).on('click', '#select_filter_by_dropdown', function(){ 
    //     var filter_type = $(this).val();

    //     if(filter_type == 1){
    //         location.reload();

    //     } else if(filter_type == 2){
    //         var url = '/student-enrolled-course-index-filter-';
    //         var csrf_token = $('input[name=_token]').val();  

    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': "{{ csrf_token() }}"
    //             }
    //         });

    //         $.ajax({  
    //                 url: url + filter_type,  
    //                 type: 'post',  
    //                 data: {
    //                     filter_type : filter_type,
    //                     "_token": "{{ csrf_token() }}"
    //                     },  
    //                 success:function(data){  
    //                         $('.all_enrollment_course_show').hide();

    //                         $('.individual_user_enrollment_courses_show').html(data);
    //                         $('.individual_user_enrollment_courses_show').show();
    //                         $('.individual_user_enrollment_courses_thead').show();      
    //                 }  
    //         });
    //     }

    // });
    //filter

});


</script>
@endsection