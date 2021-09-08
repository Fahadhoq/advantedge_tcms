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
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <h4  class="page-title">COURSE EDIT </h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Training Center Management System</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">COURSE</a></li>
                                        <li class="breadcrumb-item active">COURSE EDIT</li>
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
                                    
                           
                            <form action="{{ route( 'course.edit' , $course->id )  }}" method="post" >
                                 @csrf

                            <!-- 2nd row     -->
                           <div class="row">

                           <!-- 1st part              -->
                                <div class="col-lg-6">
                                    <div class="p-20">

                                               <div class="form-group "> 
                                                    <label >Class</label>
                                                    <div >
                                                        <select class="form-control" name="Class" id="Class" value="{{ old('Class') }}">
                                                                      <option value="">Choose One Class</option>
                                                                @foreach($Classes as $Classe)
                                                                    @if($Classe->id == $course->class)
                                                                       <option  id="{{$Classe->id}}" value="{{$Classe->id}}" selected>{{$Classe->name}}</option>    
                                                                    @else
                                                                       <option  id="{{$Classe->id}}" value="{{$Classe->id}}">{{$Classe->name}}</option>
                                                                    @endif
                                                                @endforeach
                                                        </select>
                                                    </div>
                                               </div>

                                               <div class="form-group"> 
                                                    <label >Subject</label>
                                                    <div >
                                                        <select class="form-control" name="Subject" id="Subject" value="{{ old('Subject') }}">
                                                                      <option value="">Choose One Subject</option>
                                                                @foreach($Subjects as $Subject)
                                                                    @if($Subject->id == $course->subject)
                                                                       <option  id="{{$Subject->id}}" value="{{$Subject->id}}" selected>{{$Subject->name}}</option>    
                                                                    @else
                                                                       <option  id="{{$Subject->id}}" value="{{$Subject->id}}">{{$Subject->name}}</option>
                                                                    @endif
                                                                @endforeach
                                                        </select>
                                                    </div>
                                               </div>

                                               <div class="form-group">
                                                    <label>Day</label>
                                                    <div> 
                                                        <select class="form-control" id="Course_days" name="Course_days[]" multiple >
                                                                @foreach($Days as $Day)
                                                                    <option  id="{{$Day->id}}" value="{{$Day->id}}"
                                                                   @foreach($course_days as $course_day)
                                                                     @if($Day->id == $course_day)
                                                                        selected
                                                                     @endif  
                                                                   @endforeach
                                                                       >{{$Day->name}}</option>
                                                                @endforeach   
                                                        </select>
                                                    </div>
                                               </div>
        
                                                <div class="form-group">
                                                    <label>Start Time</label>
                                                    <div>
                                                         <input class="form-control" type="time" value="{{ $course->start_time }}" name="start_time" id="course_start_time"> 
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>End time</label>
                                                    <div>
                                                            <input class="form-control" type="time" value="{{ $course->end_time }}" name="end_time" id="course_end_time">
                                                    </div>
                                                </div>

                                        

                                    </div>
                                    <!-- col-lg-6 -->
                                        </div>
                                        <!-- p-20    -->
                                    <!-- 1st part end     -->
                                   

                                    <!-- 2nd part              -->
                                        <div class="col-lg-6">
                                                <div class="p-20">
                                            
                                                <div class="form-group">
                                                    <label  class="value">Class Type</label></br> 
                                                    <div>
                                                        <select id="ClassType" name="ClassType" class="form-control"  >  
                                                                    <option value="">Choose Class Type</option> 
                                                                    @if($course->class_type == 1)
                                                                        <option  id="" value="1" selected>Online</option>
                                                                        <option  id="" value="0">Offline</option> 
                                                                    @elseif($course->class_type == 0)
                                                                        <option  id="" value="1">Online</option>
                                                                        <option  id="" value="0" selected>Offline</option> 
                                                                    @endif
                                                                             
                                                        </select>
                                                    </div>    
                                               </div>

                                            <div class="form-group">
                                                <label>Student limite</label>
                                                <div>
                                                    <input type="text" id="StudentLimite" name="StudentLimite" value="{{ $course->student_limit }}"
                                                           class="form-control"
                                                           placeholder="Enter Student Limite "/>    
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Course Fee </label>
                                                <div>
                                                    <input type="text" id="CourseFee" name="CourseFee" value="{{ $course->course_fee }}"
                                                           class="form-control" 
                                                           placeholder="Enter Course Fee "/>    
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Enrollment Last Date </label>
                                                <div>
                                                    
                                                     <input class="form-control" type="date" value="{{ $course->enrollment_last_date }}" name="EnrollmentLastDate" id="EnrollmentLastDate">
                                                </div>
                                            </div>

                                            <div class="form-group "> 
                                                <label >Status</label>
                                                <div >
                                                    <select class="form-control" name="CourseStatus" id="CourseStatus" >
                                                           <option value="">Choose Course Status</option>
                                                        @if($course->status == 1)
                                                           <option  id="" value="1" selected>Active</option>
                                                           <option  id="" value="0">Inactive</option>
                                                        @elseif($course->status == 0)
                                                           <option  id="" value="1">Active</option>
                                                           <option  id="" value="0" selected>Inactive</option>  
                                                        @endif               
                                                    </select>
                                                </div>
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
                                         <button id="submit" type="submit" class="btn btn-primary">Submit</button>
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
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> -->
@endsection

@section('script')
<script>
$(document).ready(function(){
        
        //phone number validation   
        $('#phone').blur(function(){
          var $phone = $(this).val();
          var url = '/user-phone-number-availability-';
          if($phone != 0){
          var csrf_token = $('input[name=_token]').val();
  
               $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });

          $.ajax({
            url: url+$phone,
            type: 'post',
            data:{
                  Number: $phone,
                  "_token": "{{ csrf_token() }}"
                 },
            
            success:function (data) {
              //console.log(html);
              $('#phone_number_availability').html(data);
            }

          });
  
        }      
        
        });
        //phone number validation end

        //email validation 
        $('#email').blur(function(){
          var $email = $(this).val();
          var url = '/email-availability-';
          if($email != 0){
          var csrf_token = $('input[name=_token]').val();
  
               $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });

          $.ajax({
            url: url+$email,
            type: 'post',
            data:{
                  email: $email,
                  "_token": "{{ csrf_token() }}"
                 },
            
            success:function (data) {
              //console.log(html);
              $('#email_availability').html(data);
            }

          });
  
        }      
        
        }); 
         //email validation  end 

         //  multiselete
            $('#Course_days').multiselect({
                nonSelectedText: 'Select Coures Days',
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                buttonWidth:'580px',
            });
        // multiselete end

});    
          
</script>
@endsection