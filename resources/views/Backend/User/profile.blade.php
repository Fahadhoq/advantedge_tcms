@extends('layouts.MasterDashboard')

@section('css')
<style> 

.profile-nav, .profile-info{
    margin-top:30px;   
}

.profile-nav .user-heading {
    background: #fbc02d;
    color: #fff;
    border-radius: 4px 4px 0 0;
    -webkit-border-radius: 4px 4px 0 0;
    padding: 20px;
    text-align: center;
}

.profile-nav .user-heading.round a  {
    border-radius: 50%;
    -webkit-border-radius: 50%;
    border: 10px solid rgba(255,255,255,0.3);
    display: inline-block;
}

.profile-nav .user-heading a img {
    width: 200px;
    height: 200px;
    border-radius: 100%;
    -webkit-border-radius: 100%;
}

.profile-nav .user-heading h1 {
    font-size: 22px;
    font-weight: 300;
    margin-bottom: 5px;
}

.profile-nav .user-heading p {
    font-size: 12px;
}

.profile-nav ul {
    margin-top: 1px;
}

.profile-nav ul > li {
    border-bottom: 1px solid #ebeae6;
    margin-top: 0;
    line-height: 30px;
}

.profile-nav ul > li:last-child {
    border-bottom: none;
}

.profile-nav ul > li > a {
    border-radius: 0;
    -webkit-border-radius: 0;
    color: #89817f;
    border-left: 5px solid #fff;
}

.profile-nav ul > li > a:hover, .profile-nav ul > li > a:focus, .profile-nav ul li.active  a {
    background: #f8f7f5 !important;
    border-left: 5px solid #fbc02d;
    color: #89817f !important;
}

.profile-nav ul > li:last-child > a:last-child {
    border-radius: 0 0 4px 4px;
    -webkit-border-radius: 0 0 4px 4px;
}

.profile-nav ul > li > a > i{
    font-size: 16px;
    padding-right: 10px;
    color: #bcb3aa;
}

.r-activity {
    margin: 6px 0 0;
    font-size: 12px;
}


.profile-info .panel-footer {
    background-color:#f8f7f5 ;
    border-top: 1px solid #e7ebee;
}

.profile-info .panel-footer ul li a {
    color: #7a7a7a;
}

.bio-graph-heading {
    background: #fbc02d;
    color: #fff;
    text-align: center;
    font-style: italic;
    padding: 10px 30px;
    border-radius: 4px 4px 0 0;
    -webkit-border-radius: 4px 4px 0 0;
    font-size: 16px;
    font-weight: 300;
}
.account-graph-heading {
    background: #fbc02d;
    color: #fff;
    text-align: center;
    font-style: italic;
    padding: 10px 30px;
    border-radius: 4px 4px 0 0;
    -webkit-border-radius: 4px 4px 0 0;
    font-size: 16px;
    font-weight: 300;
    margin-top: 10px;
}

.bio-graph-info {
    background: #89817e;
}


.bio-graph-info h1 {
    font-size: 22px;
    font-weight: 300;
    margin: 0 0 20px;
}

.bio-row {
    width: 50%;
    /* float: left; */
    padding:0 60px;
    color: #ffffff;
    
    font-size: 16px;
    font-weight: 300;
}

.bio-row p span {
    width: 100px;
    display: inline-block;
}

.bio-chart, .bio-desk {
    float: left;
}

.bio-chart {
    width: 40%;
}

.bio-desk {
    width: 60%;
}

.bio-desk h4 {
    font-size: 15px;
    font-weight:400;
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
                        
                        <!-- start row -->
                        <div class="row align-items-center">
                            
                            <div class="col-sm-4">
                                <h4 class="page-title">USER DETAILS </h4>
                            </div>
                            
                            <div class="col-sm-3" style="background-color:#92cd00">
                                <h4 class="page-title" style=text-align:center>@if(isset($is_deleted))  THE USER WAS DELETED  @endif </h4>
                            </div>

                            <div class="col-sm-5">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Training Center Management System</a></li>
                                    <li class="breadcrumb-item active">USER </li>
                                    <li class="breadcrumb-item active"> USER DETAILS </li>
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

<div class="container bootstrap snippets bootdey">
<div class="row">

  <div class="profile-nav col-md-3">
      <div class="panel">
          <div class="user-heading round">
              <a href="#">
                  <img src="{{ url('storage').'/'.@$user->profile_photo_path }}" width="100px" height="80px">
              </a>
              <h1>{{$user->name}}</h1>
              <p>{{$user->email}}</p>
          </div>

          <ul class="nav nav-pills nav-stacked">
              <li><a href="{{ route('user.edit' , $user->id) }}"> <i class="fa fa-edit"></i> Edit profile</a></li>
          </ul>
      </div>
  </div>
  
  <div class="profile-info col-md-9">
      
      <div class="panel">
        
        <div class="bio-graph-heading">
              Basic info
          </div>
          
          
          <div class="panel-body bio-graph-info">
              <div class="row">
                  
                  <div class="bio-row">
                      <p><span> ID </span>: {{$user->id}}</p>
                  </div>

                  <div class="bio-row">
                      <p><span>Email </span>: {{$user->email}}</p>
                  </div>
                  
                  <div class="bio-row">
                      <p><span> Name </span>: {{$user->name}}</p>
                  </div>
                  
                  <div class="bio-row">
                      <p><span>Mobile </span>: {{$user->phone}}</p>
                  </div>

                  <div class="bio-row">
                      <p><span>User Type </span>: {{$user_type->name}}</p>
                  </div>

                  <div class="bio-row">
                      <p><span>User Role </span>: {{$role->name}}</p>
                  </div>

              </div>
          </div>

         </div>

      

      <div class="panel">
        
        <div class="account-graph-heading">
              Account info
          </div>
          
          
          <div class="panel-body bio-graph-info">
              <div class="row">
              
                  <div class="bio-row">
                      <p><span> Created At </span>: {{$user->created_at->format("m/d/Y")}}</p>
                  </div>
              
                  <div class="bio-row">
                    @if(isset($is_deleted))
                      <p><span>Deleted At </span>:  {{$user_is_deleted->deleted_at->format("m/d/Y")}}</p>
                    @endif  
                  </div>
                  
                  
                  <div class="bio-row">
                      <p>
                           <span>Verified By </span>: @if(isset($verified_by->name)) 
                                                           {{$verified_by->name}} 
                                                      @else
                                                         not verify yet!!!
                                                      @endif        
                      </p>
                  </div>

              </div>
          </div>

         </div>

      </div>


       


</div>
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