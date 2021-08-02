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

   
                        <div class="row">
                           

<!-- div 1 -->                                 
                        <div id="div1" class="col-lg-12">
                                <div class="card m-b-30">
                                    <div class="card-body">
        
                                        
                                  
                                    <!-- message show -->
                                    @include('layouts.partials.message-show')
                                    <!-- message show end -->
                                    
                           
                            <form action="{{ route( 'user.edit' , $user->id ) }}" id="EditForm" method="post" enctype="multipart/form-data">
                                 @csrf

                            <!-- 2nd row     -->
                           <div class="row">

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

                                            <div class="form-group" class="col-md-12">
                                    
                                                <label for="image"> Image </label><br>
                                                <img src="{{url('storage').'/'.@$user->profile_photo_path }}" id="view_uploading_img_src" width="510px" height="150px" class="img-responsive">  
                                                       
                                                <button type="button" data-id="{{$user->id}}" class="remove_button btn btn-danger">x</button>  
                                              

                                                <div>
                                                    <input type="hidden" name="old_pic" value="{{ $user->profile_photo_path }}"><br>    

                                                    <label for="image"> Want to change Image? </label><br>
                                                    <input type="file" name="image" class="form-control" id="image"  placeholder="upload Image">
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

                                            <div class="form-group">
                                                <label>Email</label>
                                                <div>
                                                    <input type="text" name="email" value="{{ $user->email }}"
                                                           class="form-control" required
                                                           placeholder="Enter User Email "/>
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
                                        <a href="{{ route( 'cancle.button' ) }}" class="btn btn-danger"> {{ __('cancle') }}</a>
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

</script>

@endsection
