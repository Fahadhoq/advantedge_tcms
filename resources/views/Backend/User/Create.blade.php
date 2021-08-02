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
                                    <h4  class="page-title">USER CREATE </h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Training Center Management System</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">USER</a></li>
                                        <li class="breadcrumb-item active">USER CREATE</li>
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
                                    
                           
                            <form action="{{ route( 'user.create' ) }}" method="post" >
                                 @csrf

                            <!-- 2nd row     -->
                           <div class="row">

                           <!-- 1st part              -->
                                <div class="col-lg-6">
                                    <div class="p-20">

                              
                                            <div class="form-group">
                                                <label>Name</label>
                                                <div>
                                                    <input type="text" name="name" value="{{ old('name') }}"
                                                           class="form-control" required
                                                           placeholder="Enter User Name "/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <div>
                                                  <input type="password" class="form-control" name="password"  placeholder="Enter User Password">
                                                </div>
                                            </div>
    
                                            <div class="form-group">
                                                <label for="Confirm_Password">Confirm Password</label>
                                                <div>
                                                <input type="password" class="form-control" name="password_confirmation"  placeholder="Enter Confirm User Password">
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
                                                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                                           class="form-control" required
                                                           placeholder="Enter User Phone Number "/>
                                                    <span id="phone_number_availability"></span>       
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Email</label>
                                                <div>
                                                    <input type="text" id="email" name="email" value="{{ old('email') }}"
                                                           class="form-control" required
                                                           placeholder="Enter User Email "/>
                                                     <span id="email_availability"></span>      
                                                </div>
                                            </div>

            

                                                <div class="form-group "> 
                                                    <label >Select user type</label>
                                                    <div >
                                                        <select class="form-control" name="UserType" id="UserType" value="{{ old('UserType') }}">
                                                           <option value="">Choose one User Type</option>
                                                            @foreach($user_types as $user_type)
                                                            <option  id="{{$user_type->id}}" value="{{$user_type->id}}">{{$user_type->name}}</option>
                                                            @endforeach
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

@section('script')
<script>
        $(document).ready(function(){
        
        //phone number validation   
        $('#phone').blur(function(){
          var $phone = $(this).val();
          var url = '/user-phone-number-availability-';
         // console.log($phone);
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

        //email validation 
        $('#email').blur(function(){
          var $email = $(this).val();
          var url = '/email-availability-';
         // console.log($phone);
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

      });    
          
</script>
@endsection