@extends('layouts.MasterDashboard')

@section('css')
<!-- datatable css link add -->
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
                            
                            <div class="col-sm-6">
                                <h4 class="page-title">ALL ROLES </h4>
                            </div>
                            
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Training Center Management System</a></li>
                                    <li class="breadcrumb-item active">ROLE </li>
                                    <li class="breadcrumb-item active">ALL ROLES </li>
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

                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead class="thead-default">
                                                    <tr>
                                                        <th style=text-align:center>SL</th>
                                                        <th style=text-align:center>ROLL Name</th>
                                                        <th style=text-align:center>Action</th>    
                                                    </tr>
                                                </thead>
        
        
                                                <tbody>
                                                @php $i=1 @endphp
                                                @foreach($Roles as $Role)
                                                    <tr>
                                                        <td style=text-align:center scope="row">{{$i++}}</td>   
                                                        <td style=text-align:center>{{$Role->name}}</td>
                                                        <td style=text-align:center>
                                                        <!-- <a href="{{ route('Role.view' , $Role->id) }}" class="btn btn-info btn-sm" title="View Role"><i class="fa fa-eye"></i></a> -->
                                                        <!-- jquery view -->
                                                        <a  name="view" value="view" id="{{$Role->id}}" class="btn btn-info btn-sm view_role" title="View Role"><i class="fa fa-eye"></i></a>
                                                        <!-- jquery view end-->
                                                        <a href="{{ route('Role.edit' , $Role->id) }}" class="btn btn-warning btn-sm" title="Edit Role"><i class="fa fa-edit"></i></a>

                                                        @can('delete')

                                                        <button class="btn btn-danger btn-sm delete" data-id="{{$Role->id}}" value="{{$Role->id}}"><i
                                                        class="fa fa-trash"></i></button>
                                            
                                                        <!-- <a href="{{ route('Role.delete' , $Role->id) }}" id="{{$Role->id}}" class="btn btn-danger btn-sm remove" title="delete Role" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash"></i></a> -->
                                                        @endcan
                                                       
                                                        </td> 
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

<!-- role view -->
<div id="dataModal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                
                <div class="modal-header">  
                     <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->  
                     <h4 class="modal-title">Role Details</h4>  
                </div>  
                
                <div class="modal-body" id="role_detail">  
                </div>  
                
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>
                  
           </div>  
      </div>  
 </div>
<!-- role view end -->

@endsection   


@section('jquery')
<!-- datatable js link add -->
@include('layouts.partials.datatable-js')
@endsection

@section('script')
<script>
//view role
$(document).ready(function(){  
      $('.view_role').click(function(){
           var csrf_token = $('input[name=_token]').val();  
           var role_id = $(this).attr("id"); 
           console.log(role_id);
           var url = '/role-show-'; 

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
          
           $.ajax({  
                url: url + role_id,  
                type: 'post',  
                data: {
                      role_id:role_id,
                       "_token": "{{ csrf_token() }}"
                      },  
                success:function(data){  
                    
                     $('#role_detail').html(data);  
                     $('#dataModal').modal("show");  
                }  
           });  
      });  
 });
//view role end

// delete role 
$('#datatable-buttons').delegate('.delete', 'click', function(){
   
    var csrf_token = $('input[name=_token]').val();
    var current_tr = $(this).closest('tr');
    var url = '/role-delete-';
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


</script>
@endsection