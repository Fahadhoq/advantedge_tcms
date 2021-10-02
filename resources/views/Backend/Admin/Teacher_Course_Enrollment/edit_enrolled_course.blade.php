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

.course_table_head_tr{
  background-color: #f0f4f7;
  color:black;
}

.table_lable{
    text-align:center;
    line-height:150%;
    font-size: 20px;
}
.course_table_lable{
    line-height:150%;
    font-size: 20px;
    margin-left: -15px;
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
                                    <h4  class="page-title">COURSE CREATE </h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Training Center Management System</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">COURSE</a></li>
                                        <li class="breadcrumb-item active">COURSE CREATE</li>
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
                                    
                           
                            <form action="" method="post" id="TeacherCourseEnrollmentForm">
                                 @csrf

                            <!-- 2nd row     -->
                           <div class="row">

                           <!-- 1st part              -->
                                <div class="col-lg-3">
                                    <div class="p-20">
                                  
                                    <div class="col-sm-12 col-lg-12 table_lable">
                                         <label class="page-title">Teacher Info </label> 
                                    </div>
                               
                                      <div class="table-responsive">
                                        <table class="table table-bordered">
                                        
                                                <tr>
                                                    <th class="course_table_head_tr">ID</th>
                                                    <td id="teacher_id" value="{{$teacher->id}}" align= "center">{{$teacher->id}}</td>    
                                                </tr>
                                                <tr>
                                                    <th class="course_table_head_tr">Image</th>
                                                    <td align= "center"> <a href="#"> <img src='storage/'{{$teacher->profile_photo_path}} width="100px" height="80px"></a> </td>   
                                                </tr>
                                                <tr>
                                                    <th class="course_table_head_tr">Name</th>
                                                    <td align= "center">{{$teacher->name}}</td>   
                                                </tr>
                                                <tr>
                                                    <th class="course_table_head_tr">Phone Number</th>
                                                    <td align= "center">{{$teacher->phone}}</td>  
                                                </tr>
                                                <tr>
                                                    <th class="course_table_head_tr">Email</th>
                                                    <td align= "center">{{$teacher->email}}</td> 
                                                </tr>
                                               
                                        </table>
                                      </div>  
                                
                                     

                                    </div>
                                    <!-- p-20    -->
                                        </div>
                                        <!-- col-lg-6 -->
                                        
                                    <!-- 1st part end     -->
                                   

                                    <!-- 2nd part              -->
                                        <div class="col-lg-9">
                                                <div class="p-20">
                                         
                                                <div class="col-sm-12 col-lg-12 course_table_lable">
                                                    <label class="page-title">Course List</label> 
                                                </div>
                                                    

                                                <div class="table-responsive">
                                                    <table class="table table-bordered ">
                                                      <thead>
                                                            <tr class="course_table_head_tr">
                                                                    
                                                                <th>Select</th>
                                                                <th>ID</th>
                                                                <th>Class</th>
                                                                <th>Subject Name</th>
                                                                <th>Day</th>
                                                                <th>Start Time</th>
                                                                <th>End Time</th>
                                                                <th>Class Type</th>
                                                                <th>Limit</th>  
                                                            </tr>
                                                      </thead>   
                                                       
                                                        @foreach($offer_courses as $offer_course)
                                                            
                                                            <tr @foreach($teacher_enrolled_courses as $teacher_enrolled_course) @if($offer_course->id == $teacher_enrolled_course->course_id) class="selectRow" @endif @endforeach>
                                                          
                                                                
                                                                <td align= "center">
                                                                    <input type="checkbox" name="course_checkbox" id="{{$offer_course->id}}" class="select_course" value="{{ $offer_course->id }}" @foreach($teacher_enrolled_courses as $teacher_enrolled_course) @if($offer_course->id == $teacher_enrolled_course->course_id) checked @endif @endforeach />
                                                                </td>
                                      
                                                                <td class="course_id" align= "center">{{ $offer_course->id }}</td>
                                                                <!-- class -->
                                                                <td align= "center">@php 
                                                                                      $class = App\Models\Classes::select('name')->where('id' , $offer_course->class)->first();
                                                                                         echo $class->name;
                                                                                      @endphp</td>
                                                                <!-- class end -->
                                                                <!-- subject name -->
                                                                <td align= "center"> @php 
                                                                                      $subject = App\Models\Subject::select('name')->where('id' , $offer_course->subject)->first();
                                                                                         echo $subject->name;
                                                                                      @endphp  
                                                                </td>
                                                                <!-- subject name end -->
                                                                <!-- day -->
                                                                <td align= "center">
                                                                                    @php 
                                                                                    $offer_course_days = explode(',', $offer_course->day);
                                                                                    $days = App\Models\Day::select('id' ,'name')->get();

                                                                                    foreach($days as $day){
                                                                                        $day_id = $day->id;
                                                                                          foreach($offer_course_days as $offer_course_day){
                                                                                            if($offer_course_day == $day_id){
                                                                                                echo $day->name;
                                                                                                echo '</br>';
                                                                                            }
                                                                                          }
                                                                                    }
                                                                                    @endphp
                                                                </td>
                                                                <!-- day end -->
                                                                <td align= "center">{{ date('h:i:s a', strtotime($offer_course->start_time)) }}</td>
                                                                <td align= "center">{{ date('h:i:s a', strtotime($offer_course->end_time)) }}</td>
                                                                <td align= "center">@if($offer_course->class_type == 0) Offline  @else Online @endif</td>
                                                                <td align= "center"> @php 
                                                                                         $enroll_course = App\Models\Student_Course_Enrollment::where('course_id' , $offer_course->id)->get();
                                                                                         $count_enroll_course = count($enroll_course);
                                                                                     @endphp 
                                                                                        {{ $count_enroll_course }} / {{ $offer_course->student_limit }}
                                                                </td>
                                                               
                                                            </tr>

                                                        @endforeach

                                                    </table>
                                                </div>

                                            </div>
                                            <!-- col-lg-6 -->
                                        </div> 
                                        <!-- p-20 -->
                                    <!-- 2nd part end     -->    

                                 </div>  
                            <!-- 2nd row end                -->  
   
                                    <div style=text-align:center class="col-xl-12">
                                         <!-- submit button    -->
                                         <button type="button" id="TeacherEnrolmentFormsubmit"  class="btn btn-primary">Submit</button>
                                        <!-- button end -->
                                        
                                        </form> 
                                        <!-- from end -->

                                        <!-- cancle from -->
                                        <a href="{{ route( 'user.index' ) }}" class="btn btn-danger"> {{ __('cancle') }}</a>
                                        <!-- cancle from end -->
                                    <div>  
                                        
                           

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

//selected courses
    var selected_courses = [];
    $('input[name="course_checkbox"]:checked').each(function() {
        selected_courses.push($(this).val());
    });
//selected courses end

//drop offer course
$('.select_course').click(function(){
 
      var checked_course =  $(this).val();
     
      jQuery.each(selected_courses, function(i, selected_course){
          
	   if(checked_course == selected_course){
            
            var teacher_id =  $("#teacher_id").text();
            var action = "user_wise_course_drop"; 
            var csrf_token = $('input[name=_token]').val();
            var url = '/teacher-enrolled-course-drop-'; 
            
            if(checked_course != null){

                $.confirm({
                    title: 'Confirm!!!',
                    content: 'Are you sure you want to drop this course?',
                    buttons: {
                        confirm: function () {
                           
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                    }
                            });

                            $.ajax({
                                    url: url + checked_course,
                                    type: 'post',
                                    data:{
                                            course_id : checked_course,
                                            teacher_id : teacher_id,
                                            action : action,
                                                "_token": "{{ csrf_token() }}"
                                        },
                                                
                                            success : function(data)
                                            {
                                                if(data.success) {
                                                    $.growl.notice({message: data.success});
                                                    $('#'+checked_course).closest('tr').removeClass('selectRow');
                                                    $('#'+checked_course).prop('checked', false);
                                                    
                                                    selected_courses.splice($.inArray(data.course_id, selected_courses),1);
                                                    
                                                }
                                            
                                            }                
                            });
                            return true;

                        },
                            cancel: function () {
                                $('#'+checked_course).closest('tr').addClass('selectRow');
                                $('#'+checked_course).prop('checked', true);
                            }
                    }

                 });
              
            }

       }		  
	});
 
});
//drop offer course end             

//select offer course
$('.select_course').click(function(){
   
        if($(this).is(':checked'))
        {
            $(this).closest('tr').addClass('selectRow');
        }
        else
        {
            $(this).closest('tr').removeClass('selectRow');
        }
});
//select offer course end 


//check selected course is clash (day,time) for teacher

//backend selected coures with db 
$('.select_course').click(function(){
    
      if($(this).is(':checked')){

            var select_course_id =  $(this).val();
            var select_teacher_id =  $("#teacher_id").text();
            var csrf_token = $('input[name=_token]').val();
            var url = '/teacher-course-enrollment-check-teacher-course-is-clash-'; 
              
                $.ajaxSetup({
                headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                });

                $.ajax({
                        url: url + select_teacher_id,
                        type: 'post',
                        data:{
                            student_id : select_teacher_id,
                            course_id : select_course_id,
                                "_token": "{{ csrf_token() }}"
                            },
                                    
                                success : function(data)
                                {
                                    if(data.error) {
                                          $.growl.error({message: data.error});
                                           $('#'+select_course_id).closest('tr').removeClass('selectRow');
                                           $('#'+select_course_id).prop('checked', false);
                                           selected_courses.splice($.inArray(select_course_id, selected_courses),1);
                                           console.log("is backend"+selected_courses);
                                    }
                                }                
                });
           
        }
});
//backend selected coures with db

//forntend selected course
// var frontend_select_course_checkbox_value = [];
$('.select_course').click(function(){
    
    var select_teacher_id =  $("#teacher_id").text();
    var csrf_token = $('input[name=_token]').val();
    var url = '/teacher-course-enrollment-check-selected-courses-is-clash';
    
    if ($(this).is(':checked')) {
        var forntend_select_course_id = $(this).val();
        selected_courses.push(forntend_select_course_id);
        var uncheck_request = 0; console.log(selected_courses);
    }
    //  else {
    //     var uncheck_course_id = ($(this).val()); 
    //     frontend_select_course_checkbox_value.splice($.inArray(uncheck_course_id, frontend_select_course_checkbox_value),1);
    //     uncheck_request = 1; 
    // }

        if(uncheck_request == 0){
                $.ajaxSetup({
                    headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            }
                    });

                    $.ajax({
                            url: url,
                            type: 'post',
                            data:{
                                teacher_id : select_teacher_id,
                                frontend_select_course_checkbox_value : selected_courses,
                                    "_token": "{{ csrf_token() }}"
                                },
                                        
                                    success : function(data)
                                    {
                                        if(data.error) {
                                                $.growl.error({message: data.error});
                                                $('#'+forntend_select_course_id).closest('tr').removeClass('selectRow');
                                                $('#'+forntend_select_course_id).prop('checked', false);
                                                selected_courses.splice($.inArray(forntend_select_course_id, selected_courses),1);
                                                console.log("is foentend"+selected_courses);
                                        }
                                    }                
                    });
            }

});
//forntend selected course end 

//check selected course is clash (day,time) for student end 

//offer course update
$("#TeacherEnrolmentFormsubmit").click(function(){        
       // $("#myForm").submit(); // Submit the form
       var select_teacher =  $("#teacher_id").text();
       var select_course_checkbox = $('.select_course:checked');
       var csrf_token = $('input[name=_token]').val();
       var url = '/teacher-enrollment-course-update'; 
       //console.log(select_student);

        if(select_teacher.length != 0){

            if(select_course_checkbox.length > 0){
                var select_course_checkbox_value = [];
                $(select_course_checkbox).each(function(){
                    select_course_checkbox_value.push($(this).val());
                });

                $.ajaxSetup({
                headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                });

                $.ajax({
                        url: url,
                        type: 'post',
                        data:{
                            teacher_id : select_teacher,
                            select_course_ids : select_course_checkbox_value,
                                "_token": "{{ csrf_token() }}"
                            },
                                    
                                success : function(data)
                                {
                                    if(data.error) {
                                          $.growl.error({message: data.error});
                                    }else if(data.success){
                                    
                                        $.growl.notice({message: data.success});
                                        window.location.href = "/teachers-enrolled-courses";
                                    }
                                }
                                
                });
            
            }else{
                $.growl.notice({message: "Coures Updated Successfull"});
                window.location.href = "/teachers-enrolled-courses";
            }

        }else{
            $.growl.error({message: "Select One Student"});
        }
        
    });
//offer course update end

});    
          
</script>
@endsection