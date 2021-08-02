@extends('layouts.MasterDashboard')

@section('css')
<!-- datatable css link add -->
         @include('layouts.partials.datatable-css')
<style>  
.hover:hover{
    text-decoration: underline;
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
                            
                            <div class="col-sm-6">
                                <h4 class="page-title">ALL USERS </h4>
                            </div>
                            
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Training Center Management System</a></li>
                                    <li class="breadcrumb-item active">USER </li>
                                    <li class="breadcrumb-item active">ALL USERS </li>
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
                                  
                                    
                                    <!-- message show -->
                                    @include('layouts.partials.message-show')
                                    <!-- message show end -->


                                   <div class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer col-md-12">
                                     
                                      <div class="col-sm-12 col-md-10 dataTables_filter"> 
                                          User Create: From
                                           <input name="from_date" id="from_date" class="form-control col-sm-12 col-md-3" type="date" value="from date" placeholder="From Date">
                                          To
                                           <input name="to_date" id="to_date" class="form-control col-sm-12 col-md-3" type="date" value="To date" placeholder="To Date">
                                           <input type="button" name="filter" id="filter" value="Filter" class="btn btn-info col-sm-12 col-md-2" />  
                                      </div> 
                                       
                                      
                                      <div style="clear:both"></div>                 
                                      <br />
                                      
                                    </div>

                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                                <thead class="thead-default">
                                                    <tr>
                                                        <th style=text-align:center>SL</th>
                                                        <th style=text-align:center>profile photo </th>
                                                        <th style=text-align:center>User ID</th>
                                                        <th style=text-align:center>User Name</th>
                                                        <th style=text-align:center>User Create at</th>
                                                        <th style=text-align:center>User is Active</th>
                                                        <th style=text-align:center>Action</th>
                                                        <th style=text-align:center>verify</th>    
                                                    </tr>
                                                </thead>
        
        
                                                <tbody id="TableData">
                                                @php $i=1 @endphp
                                                @foreach($users as $user)
                                                    <tr>
                                                        <td style=text-align:center scope="row">{{$i++}}</td>   
                                                        <td style=text-align:center>
                                                            <img class="rounded-circle z-depth-2" width="60px" height="60px" src="{{ url('storage').'/'.@$user->profile_photo_path }}"
                                                            data-holder-rendered="true">
                                                        </td>
                                                        <td style=text-align:center>{{$user->id}}</td>
                                                        <td style=text-align:center>
                                                        <label><a href="{{ route('user.view' , $user->id) }}" class="hover" id="{{$user->id}}">{{$user->name}}</a></label>    
                                                        </td>
                                                        <td style=text-align:center>{{$user->created_at->format("m/d/Y")}}</td>
                                                        <td style=text-align:center>not make</td>
                                                        
                                                        <td style=text-align:center>

                                                        <a href="{{ route('user.view' , $user->id) }}" class="btn btn-info btn-sm" title="View USer"><i class="fa fa-eye"></i></a>
                                                        @can('user edit')
                                                        <a href="{{ route('user.edit' , $user->id) }}" class="btn btn-warning btn-sm" title="Edit User"><i class="fa fa-edit"></i></a>
                                                        @endcan
                                                        
                                                        @can('delete')<!-- 
                                                        <a href="{{ route('user.delete' , $user->id) }}" class="btn btn-danger btn-sm" title="delete User" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash"></i></a> -->
                                                        <!-- jquery delete -->
                                                        <button class="btn btn-danger btn-sm delete" data-id="{{$user->id}}" value="{{$user->id}}"><i
                                                        class="fa fa-trash"></i></button>
                                                        <!-- jquery delete end -->
                                                        @endcan
                                                       
                                                        </td>

                                                        
                                                        <!-- change status -->
                                                        <td style=text-align:center>
                                                    @if ($user->is_verified==1)
                                                    
                                                            @foreach($User_Infos as $User_Info)
                                                              @if($user->id == $User_Info->user_id)
                                                               @php $verified_by = App\Models\User::select('id','name')->where('id' , $User_Info->verified_by)->first() @endphp
                                                                  @if($verified_by != null)
                                                                  <a href="{{ route('user.view' , $verified_by->id) }}" class="btn btn-outline-info" title="View verifyed by user info">{{$verified_by->name}}</a>
                                                                       
                                                                  @else
                                                                    @foreach($de_users as $de_user)
                                                                     @if($de_user->id == $User_Info->verified_by)
                                                                     <a href="{{ route('user.view' , $de_user->id) }}" class="btn btn-outline-info" title="View verifyed by user info">{{$de_user->name}}</a>
                                                                     @endif    
                                                                    @endforeach
                                                                  @endif
                                                              @endif
                                                            @endforeach
                                                        
                                                    @elseif ($user->is_verified==0)
                                                    <a class="status-btn btn btn-success btn-sm" data-id="{{$user->id}}" title="verify user"><i class="fa fa-check" aria-hidden="true"></i></a>
                                                    @endif
                                                        </td>
                                                        <!-- change status end --> 

                                                    </tr>
                                                @endforeach    
                                                </tbody>
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
<@include('layouts.partials.datatable-js')


@endsection


@section('script')
<script>
$(document).ready(function(){ 

//user view tooltip
$('#datatable-buttons').delegate('.hover', 'mouseenter', function(){
       $('.hover').tooltip({
         title: fetchData,
         html: true,
         placement: 'right'
      });
});

  function fetchData()
  {
   var csrf_token = $('input[name=_token]').val(); 
   var fetch_data = '';
   var url = '/user-view-tooltip-';
   var element = $(this);
   var id = element.attr("id");

   $.ajax({
    url: url + id,
    type:'post',
    async: false,
    data:{
          id:id,
          "_token": "{{ csrf_token() }}"
         },
    success:function(data)
    {
     fetch_data = data;
    }
   });   
   
   return fetch_data;
  
  }
 //user view tooltip end     

// filter created_at date

           $('#filter').click(function(){  
                var csrf_token = $('input[name=_token]').val();
                var from_date = $('#from_date').val();  
                var to_date = $('#to_date').val(); 
                console.log(to_date); 
              
                if(from_date != '' && to_date != '')  
                {  
                     $.ajax({  
                          url: '/create-at-date-filter',  
                          type: 'post',  
                          data:{
                               from_date:from_date,
                               to_date:to_date,
                               "_token": "{{ csrf_token() }}"
                               },  
                          success:function(data)  
                          {  
                               $('#datatable-buttons').html(data);
                                
                          }  
                     });  
                }  
                else  
                {  
                     alert("Please Select Date");  
                }  
           });
// filter created_at date end             

// delete user 
$('#datatable-buttons').delegate('.delete', 'click', function(){
   
    var csrf_token = $('input[name=_token]').val();
    var current_tr = $(this).closest('tr');
    var url = '/user-delete-';
    var data_id = $(this).attr("data-id");
            
    console.log(data_id);

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
                    url: url + data_id,
                    type: 'post',
                    data: {
                                id: data_id,
                               "_token": "{{ csrf_token() }}"
                            },
                            
                    
                    success: function (result) {
                                if (result.error) {
                                    $.growl.error({message: result.error});
                                } else if (result.success) {
                                    
                                   //$.growl({ title: "Growl", message: result.success });
                                    $.growl.notice({message: result.success});
                                    current_tr.remove();
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
// delete user end

// verify user 
$('#datatable-buttons').delegate('.status-btn', 'click', function(){
     
    var csrf_token = $('input[name=_token]').val();
    
    var url = '/user-verify-';
    var data_id = $(this).attr("data-id");
   // var table = $('#datatable-buttons').DataTable();
            
    console.log(data_id);

    $.confirm({
                title: 'Confirm!!!',
                content: 'Are you sure To verify this user?',
                buttons: {
                    confirm: function () {
                        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
                    
                $.ajax({
                    url: url + data_id,
                    type: 'post',
                    data: {
                                id: data_id,
                               "_token": "{{ csrf_token() }}"
                            },
                            
                    
                    success: function (result) {
                                if (result.error) {
                                    $.growl.error({message: result.error});
                                } else if (result.success) {
                                    
                                    location.reload();
                                    $.growl.notice({message: result.success});

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
// verify user end
 

});    



</script>
@endsection