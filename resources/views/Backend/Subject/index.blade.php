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
                                <h4 class="page-title">ALL SUBJECTS </h4>
                            </div>
                            
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Training Center Management System</a></li>
                                    <li class="breadcrumb-item active">SUBJECTS </li>
                                    <li class="breadcrumb-item active">ALL SUBJECTS </li>
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
                                                        <th style=text-align:center> Name</th>
                                                        <th style=text-align:center>Action</th>    
                                                    </tr>
                                                </thead>
        
        
                                                <tbody>
                                                @php $i=1 @endphp
                                                @foreach($subjects as $subject)
                                                    <tr>
                                                        <td style=text-align:center scope="row">{{$i++}}</td>   
                                                        <td style=text-align:center>{{$subject->name}}</td>
                                            
                                                        <td style=text-align:center>
                                                            <!-- <a href="{{ route('subject.view' , $subject->id) }}" class="btn btn-info btn-sm" title="View subject"><i class="fa fa-eye"></i></a> -->
                                                            <!-- jquery view -->
                                                            <a  name="view" value="view" id="{{$subject->id}}" class="btn btn-info btn-sm view_subject" title="View subject"><i class="fa fa-eye"></i></a>
                                                            <!-- jquery view end-->

                                                            <!-- <a href="{{ route('subject.edit' , $subject->id) }}" class="btn btn-warning btn-sm" title="Edit subject"><i class="fa fa-edit"></i></a> -->
                                                            <!-- jquery edit -->  
                                                            <a  name="edit" value="Edit" id="{{$subject->id}}" class="btn btn-warning btn-sm edit_data" title="Edit subject"><i class="fa fa-edit"></i></a>
                                                            <!-- jquery edit end -->

                                                            @can('delete')
                                                            <button class="btn btn-danger btn-sm delete" data-id="{{$subject->id}}" value="{{$subject->id}}"><i
                                                            class="fa fa-trash"></i></button>         
                                                            <!-- <a href="{{ route('subject.delete' , $subject->id) }}" id="{{$subject->id}}" class="btn btn-danger btn-sm remove" title="delete subject" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash"></i></a> -->
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

<!-- class view -->
<div id="dataModal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                
                <div class="modal-header">  
                     <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->  
                     <h4 class="modal-title">Subject Details</h4>  
                </div>  
                
                <div class="modal-body" id="subject_detail">  
                </div>  
                
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>
                  
           </div>  
      </div>  
 </div>
<!-- class view end -->

<!-- edit table -->
<div id="add_data_Modal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                     <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->  
                     <h4 class="modal-title">EDIT SUBJECT</h4>  
                </div>  
                <div class="modal-body">
                <form id="insert_form">
                    @csrf    
                          <label> Name</label>  
                          <input type="text" name="name" id="name" class="form-control" />  
                          <br />  
                 
                          <input type="hidden" name="subject_id" id="subject_id" />  
                          <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />  
                     </form>  
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>  
           </div>  
      </div>  
 </div>
 <!-- edit table end -->

@endsection   


@section('jquery')
<!-- datatable js link add -->
@include('layouts.partials.datatable-js')
@endsection

@section('script')
<script>

$(document).ready(function(){  

 //view subject    
    $(document).on('click', '.view_subject', function(){
           var csrf_token = $('input[name=_token]').val();  
           var subject_id = $(this).attr("id"); 
           console.log(subject_id);
           var url = '/subject-show-'; 

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
          
           $.ajax({  
                url: url + subject_id,  
                type: 'post',  
                data: {
                    subject_id : subject_id,
                       "_token": "{{ csrf_token() }}"
                      },  
                success:function(data){  
                    
                     $('#subject_detail').html(data);  
                     $('#dataModal').modal("show");  
                }  
           });  
      });
     //view subject end  

    // edit subject
    $(document).on('click', '.edit_data', function(){  
            var subject_id = $(this).attr("id");  
            var csrf_token = $('input[name=_token]').val();   
            var url = '/subject-edit-'; 
            console.log(subject_id);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });

            $.ajax({  
                    url: url + subject_id,  
                    type: 'post',  
                    data: {
                        id : subject_id,
                        "_token": "{{ csrf_token() }}"
                        },    
                    dataType:"json",  
                    success:function(data){  

                        $('#name').val(data.name);
                        $('#subject_id').val(data.id);  
                        $('#insert').val("Update");  
                        $('#add_data_Modal').modal('show');  
                    }  
            });  
    });  
        
        $('#insert_form').on("submit", function(event){  
            event.preventDefault();  
            if($('#name').val() == "")  
            {  
                    $.growl.error({message: "Name is required"});
                    //alert("Name is required");  
            }  
            else  
            {  
                var subject_id = $('#subject_id').val();
                var subject_name = $('#name').val();
                var csrf_token = $('input[name=_token]').val();
                var url = '/subject-update-';
                
                console.log(url+subject_id);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                    });

                    $.ajax({  
                        url: url + subject_id,  
                        type: 'post', 
                        // dataType: $('#insert_form').serialize(),
                        data : {
                        id : subject_id,
                        name : subject_name,
                        "_token": "{{ csrf_token() }}"
                        }, 
                        beforeSend:function(){  
                            $('#insert').val("Inserting");  
                        },  
                        success:function(result){
                                if (result.error) {
                                        $.growl.error({message: result.error});
                                        $('#insert').val("Update");  
                                    } else if (result) {
                                        $('#insert_form')[0].reset();  
                                        $('#add_data_Modal').modal('hide');
                                        $('#dataModal').modal('hide');  
                                        $('#datatable-buttons').html(result);
                                        // console.log(result);
                                        $.growl.notice({message: "Subject Update successfully"});
                                        
                                    }    
                        }  
                    });  
            }  
        });  

    // edit subject end

    // delete subject 
    $('#datatable-buttons').delegate('.delete', 'click', function(){
    
        var csrf_token = $('input[name=_token]').val();
        var current_tr = $(this).closest('tr');
        var url = '/subject-delete-';
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
    // delete class end

});
//view class end



</script>
@endsection