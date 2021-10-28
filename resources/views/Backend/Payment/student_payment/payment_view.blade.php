@extends('layouts.MasterDashboard')

@section('css')

<style> 
.mark {
  background-color: #d7ffe7 !important
}

.mark .gsearch{
  font-size: 20px
}

.unmark {
  background-color: #e8e8e8 !important
}

.unmark .gsearch{
  font-size: 10px
}

.marktext
{
 font-weight:bold;
 background-color: antiquewhite;
}
th {
    text-align:center
}
.selectRow
{
    background-color: #b2cdf7;
    color:black;
}
.PaidRow{
    background-color: #9ce5b4;
    color:black;
}
.NonPaidRow{
    background-color: #f95252;
    color:black;
}
.course_table_head_tr{
  background-color: #f0f4f7;
  color:black;
}
.total_course_fee{
    width: 50%;
}
.total_due_course_fee{
    width: 50%;
}

</style>

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
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <h4  class="page-title">STUDENT PAYMENT EDIT</h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Training Center Management System</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">PAYMENT</a></li>
                                        <li class="breadcrumb-item active">STUDENT PAYMENT EDIT</li>
                                    </ol>
                                </div>
                            </div> <!-- end row -->
                        </div>
                        <!-- end page-title -->

   
                        <div class="row">
                           

<!-- div 1 -->                                 
                        <div id="div1" class="col-lg-12">
                                <div class="card m-b-30">
                                    <div class="card-body">
        
                                        
                                  
                                    <!-- message show -->
                                    @include('layouts.partials.message-show')
                                    <!-- message show end -->
                                    
                           
                            <form action="" method="post" id="StudentCourseEnrollmentForm">
                                 @csrf

                            <!-- 2nd row     -->
                           <div class="row">

                           <!-- 1st part              -->
                                <div class="col-lg-4">
                                    <div class="p-20">
                                       
                                    <div class="col-sm-12 col-lg-12 table_lable">
                                         <label class="page-title">Student Info </label> 
                                    </div>
                               
                                      <div class="table-responsive ">
                                        <table class="table table-bordered">
                                        
                                                <tr>
                                                    <th class="course_table_head_tr">ID</th>
                                                    <td id="student_id" value="{{$student->id}}" align= "center">{{$student->id}}</td>    
                                                </tr>
                                                <tr>
                                                    <th class="course_table_head_tr">Image</th>
                                                    <td align= "center"> <a href="#"> <img src='storage/'{{$student->profile_photo_path}} width="100px" height="80px"></a> </td>   
                                                </tr>
                                                <tr>
                                                    <th class="course_table_head_tr">Name</th>
                                                    <td align= "center">{{$student->name}}</td>   
                                                </tr>
                                                <tr>
                                                    <th class="course_table_head_tr">Phone Number</th>
                                                    <td align= "center">{{$student->phone}}</td>  
                                                </tr>
                                                <tr>
                                                    <th class="course_table_head_tr">Email</th>
                                                    <td align= "center">{{$student->email}}</td> 
                                                </tr>
                                               
                                        </table>
                                      </div>  
                                    

                                   </br></br>

                                    <div class="col-sm-12 col-lg-12 table_lable">
                                         <label class="page-title">Student Academic Info </label> 
                                    </div>

                                     <div class="table-responsive">
                                        <table class="table table-bordered">
                                        
                                                <tr>
                                                    <th class="course_table_head_tr">Academic Type</th>
                                                    <td  align= "center">
                                                       @if(@$student_academic_info->user_academic_type == 1)
                                                            School
                                                       @elseif(@$student_academic_info->user_academic_type == 2)
                                                            Collage
                                                       @elseif(@$student_academic_info->user_academic_type == 3)
                                                            University
                                                       @elseif(@$student_academic_info->user_academic_type == 4)
                                                             Other
                                                       @endif
                                                       
                                                    </td>    
                                                </tr>
                                                <tr>
                                                    <th class="course_table_head_tr">Class</th>
                                                    @php $student_academic_Type = App\Models\Classes::select('name')->where('id' , @$student_academic_info->user_class)->first(); @endphp
                                                    <td align= "center">{{@$student_academic_Type->name}}</td>   
                                                </tr>
                                                <tr>
                                                    <th class="course_table_head_tr">Institute Name</th>
                                                    <td align= "center">{{@$student_academic_info->user_institute_name}}</td>  
                                                </tr>
                                               
                                        </table>
                                     </div>

                                    </div>
                                    <!-- p-20 -->
                                </div>
                                        <!-- col-lg-6    -->
                                    <!-- 1st part end     -->
                                   

                                    <!-- 2nd part              -->
                                        <div class="col-lg-8">
                                                <div class="p-20">
                                                       <label>Course Payment List </label>

                                            <div>
                                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">           
                                                     <thead class="thead-default all_enrollment_course_show">
                                                        <tr>
                                                            <th style=text-align:center> SL</th>
                                                            <th style=text-align:center> Invoice Number</th>
                                                            <th style=text-align:center> Payment Amount</th>
                                                            <th style=text-align:center> Payment Type </th>
                                                            <th style=text-align:center> Payment Mobile Number </th>
                                                            <th style=text-align:center> Payment Transaction Number </th>
                                                            <th style=text-align:center> Cheque Transit Number </th>
                                                            <th style=text-align:center> Remark </th>
                                                            <th style=text-align:center> Payment Date </th>
                                                        </tr>
                                                     </thead>
        
                                          <!-- all_enrollment_course_show div -->
                                                <tbody class="all_enrollment_course_show">
                                                @php $i=1 ; $total_course_fee = 0 ; $total_paid_amount = 0 ; $total_due_amount = 0 @endphp
                                                @foreach($Student_Payments as $Student_Payment)
                                                    <tr>
                                                        <td style=text-align:center scope="row">{{$i++}}</td> 
                                                        
                                                        <!-- payment info -->
                                                        <td style=text-align:center scope="row">{{$Student_Payment->id}}</td>
                                                        <td style=text-align:center scope="row">{{$Student_Payment->payment_amount}}</td>
                                                        <td style=text-align:center scope="row">  @if($Student_Payment->payment_type == 1) Cashe
                                                                                                  @elseif($Student_Payment->payment_type == 2) BKash
                                                                                                  @elseif($Student_Payment->payment_type == 3) Rocket
                                                                                                  @elseif($Student_Payment->payment_type == 4) Cheque
                                                                                                  @elseif($Student_Payment->payment_type == 5) Other
                                                                                                  @endif
                                                        </td>
                                                        <td style=text-align:center scope="row">{{$Student_Payment->payment_mobile_number}}</td>
                                                        <td style=text-align:center scope="row">{{$Student_Payment->payment_transaction_number}}</td>
                                                        <td style=text-align:center scope="row">{{$Student_Payment->cheque_transit_number}}</td>
                                                        <td style=text-align:center scope="row">{{$Student_Payment->payment_remark}}</td>
                                                        <td style=text-align:center scope="row">{{$Student_Payment->payment_date}}</td>
                                                        <!-- payment info end -->   
                                                    </tr>
                                                @endforeach  
                                                    <!-- total sum   -->
                                                      <tr>
                                                          <th style=text-align:right>Total</th>
                                                          <th style=text-align:center;color:blue>Course Fee = {{$Total_Enroll_Course_Fee}}</th>
                                                          <th style=text-align:center;color:green>Paid = {{$Total_Paid_Amount}}</th>
                                                          <th style=text-align:center;color:red> Due = {{$Total_Enroll_Course_Fee - $Total_Paid_Amount}}</th>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                      </tr>
                                                    <!-- total sum end -->
                                                </tbody>
                                                <!-- all_enrollment_course_show div end -->


                                        </table>
                                    </div>

                                            </div>
                                            <!-- col-lg-6 -->
                                        </div> 
                                        <!-- p-20 -->
                                    <!-- 2nd part end     -->    

                                 </div>  
                            <!-- 2nd row end                -->  
   

                                    </div>
                                </div>
                            </div> <!-- end col -->

                        

                        </div> <!-- end row -->      

                        
                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- content -->
            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->

@endsection        

@section('jquery')
<script src="{{URL::to('assets/js/admin/Student_Enrollment/JsLocalSearch.js')}}" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>  
@endsection

@section('script')
<script>
$(document).ready(function(){

//student course detials show start

var url = '/student-payment-student-course-detials-show-';   
var SearchStudent = $("#student_id").text();
// console.log(SearchStudent);
var csrf_token = $('input[name=_token]').val();

$.ajaxSetup({
          headers: {
                      'X-CSRF-TOKEN': "{{ csrf_token() }}"
                  }
      });

$.ajax({
      url: url+SearchStudent,
      type: 'post',
      data:{
          SearchStudent : SearchStudent,
              "_token": "{{ csrf_token() }}"
           },
                  
              success:function(data)
              {
                  $('#StudentCourdsdetail').html(data);
                 // $('#student_id').val(data.id);
                // console.log(data);
              }
 });

//student course detials show end


});    
          
</script>
@endsection