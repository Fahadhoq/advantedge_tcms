@extends('layouts.MasterDashboard')

@section('css')
  
  <style>
  .box
  {
   width:800px;
   margin:0 auto;
  }
  .active_tab1
  {
   background-color:#fff;
   color:#333;
   font-weight: 600;
  }
  .inactive_tab1
  {
   background-color: #f5f5f5;
   color: #333;
   cursor: not-allowed;
  }
  .has-error
  {
   border-color:#cc0000;
   background-color:#ffff99;
  }
.hide{
    display: none;
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
                                    <h4  class="page-title">USER EDIT </h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Training Center Management System</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">USER</a></li>
                                        <li class="breadcrumb-item active">USER EDIT</li>
                                    </ol>
                                </div>
                            </div> <!-- end row -->
                        </div>
                        <!-- end page-title -->

   
                 <!-- row 1        -->
                <div class="row">           

                     <!-- div 1 -->                                 
                        <div id="div1" class="col-lg-12">
                           
                        <!-- heading -->
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                        <a class="nav-link active_tab1" style="border:1px solid #ccc" id="list_login_details">Login Details</a>
                                </li>
                                <li class="nav-item">
                                        <a class="nav-link inactive_tab1" id="list_personal_details" style="border:1px solid #ccc">Personal Details</a>
                                </li>
                                <li class="nav-item">
                                        <a class="nav-link inactive_tab1" id="list_academic_details" style="border:1px solid #ccc">Academic Details</a>
                                </li>
                            </ul>
                        <!-- heading end -->

                                <div class="card m-b-30">
                                    <div class="card-body">
                                 
                                    <!-- div tab-content start -->
                                    <div class="tab-content" style="margin-top:16px;">        
        
                                        
                                  
                                    <!-- message show -->
                                    @include('layouts.partials.message-show')
                                    <!-- message show end -->
                                    
                           
                            <form action="{{ route( 'user.edit' , $user->id ) }}" id="EditForm" method="post" enctype="multipart/form-data">
                                 @csrf

                            <!-- ********************** login detials ********************************** -->

                            <!-- 2nd row     -->
                            <div class="show" id="login_details">      
                            <div class="panel panel-default">
                            
                                            <div class="panel-heading">Login Details</div>
                            
                            <!-- div panel-body -->
                            <div class="panel-body">

                           <!-- 1st part              -->
                                <div class="col-lg-6">
                                    <div class="p-20">
                                  
                                    <div class="form-group">
                                        <label>Enter Email Address</label>
                                        <input type="text" name="email" id="email" class="form-control" />
                                        <span id="error_email" class="text-danger"></span>
                                    </div>
                                    

                                            <div class="form-group">
                                                <label>Name</label>
                                                <div>
                                                    <input type="text" name="name" value="{{ $user->name }}"
                                                           class="form-control" required
                                                           placeholder="Enter User Name "/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Phone</label>
                                                <div>
                                                    <input type="text" name="phone" value="{{ $user->phone }}"
                                                           class="form-control" required
                                                           placeholder="Enter User Phone Number "/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Email</label>
                                                <div>
                                                    <input type="text" name="email" value="{{ $user->email }}"
                                                           class="form-control" required
                                                           placeholder="Enter User Email "/>
                                                </div>
                                            </div>

                                            <div class="form-group "> 
                                                    <label >Select user type</label>
                                                    <div >
                                                        <select class="form-control" name="UserType" id="UserType" value="{{ old('UserType') }}">
                                                           <option value="">Choose one user type</option>
                                                           @foreach($user_types as $user_type)
                                                               <option  id="{{$user_type->id}}" value="{{$user_type->id}}"  @if ( $user_type->id == $has_user_type->user_type_id ) selected @endif>{{$user_type->name}}</option>
                                                           @endforeach
                                                        </select>
                                                    </div>
                                            </div>

                                            <div class="form-group "> 
                                                    <label >Select user role</label>
                                                    <div >
                                                        <select class="form-control" name="UserRole" id="UserRole" value="{{ old('UserRole') }}">
                                                           <option value="">Choose one user role</option>
                                                           @foreach($roles as $role)
                                                               <option  id="{{$role->id}}" value="{{$role->id}}"  @if ( $role->id == $hasRole->role_id ) selected @endif>{{$role->name}}</option>
                                                           @endforeach
                                                        </select>
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
                                    
                                                <label for="image"> Image </label><br>
                                                <img src="{{url('storage').'/'.@$user->profile_photo_path }}" id="view_uploading_img_src" width="500px" height="250px">  
                                                       
                                                <button type="button" data-id="{{$user->id}}" class="remove_button btn btn-danger">x</button>  
                                              

                                                <div>
                                                    <input type="hidden" name="old_pic" value="{{ $user->profile_photo_path }}"><br>    

                                                    <label for="image"> Want to change Image? </label><br>
                                                    <input type="file" name="image" class="form-control" id="image"  placeholder="upload Image">
                                                </div>

                                            </div>


                                        </div>
                                         <!-- p-20 -->
                                             </div> 
                                             <!-- col-lg-6 -->
            
                                    <!-- 2nd part end     -->   

                                     <!-- button div -->
                                   <div style=text-align:center class="col-xl-12">
                                         <!-- next button    -->
                                         <button name="btn_login_details" id="btn_login_details" class="btn btn-info" type="button" class="btn btn-primary">Next</button>
                                        <!-- next end -->
                                        
                                        <!-- cancle from -->
                                        <a href="{{ route( 'user.index' ) }}" class="btn btn-danger"> {{ __('cancle') }}</a>
                                        <!-- cancle from end -->
                                    </div> 
                                      <!-- button div  end-->
                                    

                                 </div>  <!-- div panel-body end-->

                                     </div>
                                        </div>
                            <!-- 2nd row end                -->  


                            <!-- ********************** login detials end ********************************** -->

                             <!-- ********************** personal details  ********************************** -->

                            <!-- 2nd row     -->
                            <div class="hide" id="personal_details">
                            <div class="panel panel-default">
                                        
                                            <div class="panel-heading">Fill Personal Details</div>
                            <div class="panel-body">

                            <!-- 1st part              -->
                                <div class="col-lg-6">
                                    <div class="p-20">


                                            <div class="form-group">
                                                <label>Father Name</label>
                                                <div>
                                                    <input type="text" name="FatherName" value="{{ $user->name }}"
                                                            class="form-control" required
                                                            placeholder="Enter Your Father Name "/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Address</label>
                                                <div>
                                                    <input type="text" name="Address" value="{{ $user->name }}"
                                                            class="form-control" required
                                                            placeholder="Enter Your Present Address "/>
                                                </div>
                                            </div>

                                            <div class="form-group "> 
                                                    <label >Gender</label>
                                                    <div >
                                                        <select class="form-control" name="UserGender" id="UserGender" value="{{ old('UserGender') }}">
                                                              <option value="">Choose one gender </option>
                                                               <option   value="1">Male</option> 
                                                               <option   value="2">Female</option> 
                                                               <option   value="3">Other</option> 
                                                        </select>
                                                    </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Nationality</label>
                                                <div>
                                                    <input type="text" name="Nationality" value="bangladeshi"
                                                            class="form-control" required
                                                            placeholder="Enter Your Nationality "/>
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
                                                <label>Mother Name</label>
                                                <div>
                                                    <input type="text" name="MotherName" value="{{ $user->name }}"
                                                            class="form-control" required
                                                            placeholder="Enter Your Mother Name "/>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Parent Phone Number</label>
                                                <div>
                                                    <input type="text" name="Parentphone" value="{{ $user->name }}"
                                                            class="form-control" required
                                                            placeholder="Enter Your Parent Phone Number "/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Date Of Birth</label>
                                                <div>
                                                    <input type="text" name="DOB" value="{{ $user->name }}"
                                                            class="form-control" required
                                                            placeholder="Enter Your Parent Phone Number "/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Religion</label>
                                                <div>
                                                    <input type="text" name="Religion" value="{{ $user->name }}"
                                                            class="form-control" required
                                                            placeholder="Enter Your Parent Phone Number "/>
                                                </div>
                                            </div>

                                            
                                            </div>
                                            <!-- col-lg-6 -->
                                        </div> 
                                        <!-- p-20 -->
                                    <!-- 2nd part end     -->   
                                
                                   <!-- div button -->
                                    <div style=text-align:center class="col-xl-12">
                                        <!-- submit button    -->
                                        <button type="button" name="previous_btn_personal_details" id="previous_btn_personal_details" class="btn btn-warning">Previous</button>
                                        <button type="button" name="btn_personal_details" id="btn_personal_details" class="btn btn-info">Next</button>
                                        <!-- button end -->
                                        
                                        <!-- cancle from -->
                                        <a href="{{ route( 'user.index' ) }}" class="btn btn-danger"> {{ __('cancle') }}</a>
                                        <!-- cancle from end -->
                                    </div>  
                                    <!-- div button end  -->

                                </div> 

                                   </div>
                                      </div>
 
                            <!-- 2nd row end                -->  


                            <!-- ********************** personal detials end ********************************** -->


                             <!-- ********************** academic details  ********************************** -->

                            <!-- 2nd row     -->
                            <div class="tab-pane hide" id="academic_details">
                            <div class="panel panel-default">
                                    
                                        <div class="panel-heading">Fill Academic Details</div>
                            <div class="panel-body">

                            <!-- 1st part              -->
                                <div class="col-lg-6">
                                    <div class="p-20">


                                            <div class="form-group">
                                                <label>Name</label>
                                                <div>
                                                    <input type="text" name="name" value="{{ $user->name }}"
                                                            class="form-control" required
                                                            placeholder="Enter User Name "/>
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
                                                <label>Phone</label>
                                                <div>
                                                    <input type="text" name="phone" value="{{ $user->phone }}"
                                                            class="form-control" required
                                                            placeholder="Enter User Phone Number "/>
                                                </div>
                                            </div>

                                            
                                            </div>
                                            <!-- col-lg-6 -->
                                        </div> 
                                        <!-- p-20 -->
                                    <!-- 2nd part end     -->   
                                
                                  <!-- button div -->
                                    <div style=text-align:center class="col-xl-12">
                                        <!-- submit button    -->
                                        <button type="button" name="previous_btn_academic_details" id="previous_btn_academic_details" class="btn btn-warning">Previous</button>
                                        <!-- <button type="button" name="btn_academic_details" id="btn_academic_details" class="btn btn-success btn-lg">Register</button> -->
                                        <button type="submit" id="submit"  class="btn btn-primary">Submit</button>
                                        <!-- button end -->
                                        
                                        </form> 
                                        <!-- from end -->

                                        <!-- cancle from -->
                                        <a href="{{ route( 'cancle.button' ) }}" class="btn btn-danger"> {{ __('cancle') }}</a>
                                        <!-- cancle from end -->
                                    </div> 
                                    <!-- button div end   -->

                                </div> 

                                   </div>
                                      </div>
 
                            <!-- 2nd row end                -->  


                            <!-- ********************** contact detials end ********************************** -->
   
                                    
                                        
                           

                                     </div>  <!-- end card-body -->
                                 </div> <!-- end card-m-b-30 -->
                               </div>  <!-- div tab-content end -->
                            </div> <!-- end div 1 --> 

                        

                        </div> <!-- end row 1-->      

                        
                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- content -->
            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->

@endsection  
 

@section('script')

<script>

// image edit show start

            $("#image").change(function () {
                  readImageURL(this);
               });

          function readImageURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#view_uploading_img_src').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

// image edit show start

//delete img
$(document).on('click', '.remove_button', function(){
   
    var id = $('.remove_button').data("id");
    var csrf_token = $('input[name=_token]').val();
    console.log(id);
    var url = 'user-image-delete-'; 

     $.confirm({
                title: 'Confirm!!!',
                content: 'Are you sure you want to delete?',
                buttons: {
                    confirm: function () {
                        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });

                    $.ajax({
                    url: url + id,
                    type: 'post',
                    data: {
                                id: id,
                               "_token": "{{ csrf_token() }}"
                            },
                            
                    
                    success: function (result) {
                                if (result.error) {
                                    $.growl.error({message: result.error});
                                } else if (result.success) {
                                    
                                   //$.growl({ title: "Growl", message: result.success });
                                    $.growl.notice({message: result.success});
                                    location.reload();
                                }
                            }
                    });
                    return true;

                    },
                    cancel: function () {
                    }
                }

            });
        
});
//delete img end 

$(document).ready(function(){
 
 $('#btn_login_details').click(function(){
    
   $('#list_login_details').removeClass('active active_tab1');
   $('#list_login_details').removeAttr('href data-toggle');
   $('#login_details').removeClass('show');
   $('#login_details').addClass('hide');
   $('#list_login_details').addClass('inactive_tab1');
   $('#list_personal_details').removeClass('inactive_tab1');
   $('#list_personal_details').addClass('active_tab1 active');
   $('#list_personal_details').attr('href', '#personal_details');
   $('#list_personal_details').attr('data-toggle', 'tab');
   $('#personal_details').removeClass('hide');
   $('#personal_details').addClass('show');
 });
 
 $('#previous_btn_personal_details').click(function(){

  $('#list_personal_details').removeClass('active active_tab1');
  $('#list_personal_details').removeAttr('href data-toggle');
  $('#personal_details').removeClass('show');
  $('#personal_details').addClass('hide');
  $('#list_personal_details').addClass('inactive_tab1');
  $('#list_login_details').removeClass('inactive_tab1');
  $('#list_login_details').addClass('active_tab1 active');
  $('#list_login_details').attr('href', '#login_details');
  $('#list_login_details').attr('data-toggle', 'tab');
  $('#login_details').removeClass('hide');
  $('#login_details').addClass('show');
 
});
 
 $('#btn_personal_details').click(function(){

   $('#list_personal_details').removeClass('active active_tab1');
   $('#list_personal_details').removeAttr('href data-toggle');
   $('#personal_details').removeClass('show');
   $('#personal_details').addClass('hide');
   $('#list_personal_details').addClass('inactive_tab1');
   $('#list_academic_details').removeClass('inactive_tab1');
   $('#list_academict_details').addClass('active_tab1 active');
   $('#list_academic_details').attr('href', '#academic_details');
   $('#list_academic_details').attr('data-toggle', 'tab');
   $('#academic_details').removeClass('hide');
   $('#academic_details').addClass('show');
  
 });
 
 $('#previous_btn_academic_details').click(function(){
  $('#list_academic_details').removeClass('active active_tab1');
  $('#list_academic_details').removeAttr('href data-toggle');
  $('#academic_details').removeClass('show');
  $('#academic_details').addClass('hide');
  $('#list_academic_details').addClass('inactive_tab1');
  $('#list_personal_details').removeClass('inactive_tab1');
  $('#list_personal_details').addClass('active_tab1 active');
  $('#list_personal_details').attr('href', '#personal_details');
  $('#list_personal_details').attr('data-toggle', 'tab');
  $('#personal_details').removeClass('hide');
  $('#personal_details').addClass('show');
 });
 

});

</script>

@endsection
