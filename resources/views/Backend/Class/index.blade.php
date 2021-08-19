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
                                <h4 class="page-title">ALL CLASSES </h4>
                            </div>
                            
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Training Center Management System</a></li>
                                    <li class="breadcrumb-item active">CLASSES </li>
                                    <li class="breadcrumb-item active">ALL CLASSES </li>
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
                                                        <th style=text-align:center> Academic Type</th>
                                                        <th style=text-align:center>Action</th>    
                                                    </tr>
                                                </thead>
        
        
                                                <tbody>
                                                @php $i=1 @endphp
                                                @foreach($Classes as $Class)
                                                    <tr>
                                                        <td style=text-align:center scope="row">{{$i++}}</td>   
                                                        <td style=text-align:center>{{$Class->name}}</td>
                                                        <td style=text-align:center> 
                                                                @if($Class->academic_type == 1) School
                                                                @elseif($Class->academic_type == 2) Collage
                                                                @elseif($Class->academic_type == 3) University
                                                                @elseif($Class->academic_type == 4) Other
                                                                @endif
                                                       </td>
                                            
                                                        <td style=text-align:center>
                                                            <!-- <a href="{{ route('class.view' , $Class->id) }}" class="btn btn-info btn-sm" title="View Class"><i class="fa fa-eye"></i></a> -->
                                                            <!-- jquery view -->
                                                            <a  name="view" value="view" id="{{$Class->id}}" class="btn btn-info btn-sm view_Class" title="View Class"><i class="fa fa-eye"></i></a>
                                                            <!-- jquery view end-->

                                                            <!-- <a href="{{ route('class.edit' , $Class->id) }}" class="btn btn-warning btn-sm" title="Edit Class"><i class="fa fa-edit"></i></a> -->
                                                            <!-- jquery edit -->  
                                                            <a  name="edit" value="Edit" id="{{$Class->id}}" class="btn btn-warning btn-sm edit_data" title="Edit Class"><i class="fa fa-edit"></i></a>
                                                            <!-- jquery edit end -->

                                                            @can('delete')
                                                            <button class="btn btn-danger btn-sm delete" data-id="{{$Class->id}}" value="{{$Class->id}}"><i
                                                            class="fa fa-trash"></i></button>         
                                                            <!-- <a href="{{ route('class.delete' , $Class->id) }}" id="{{$Class->id}}" class="btn btn-danger btn-sm remove" title="delete Class" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash"></i></a> -->
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
                     <h4 class="modal-title">Class Details</h4>  
                </div>  
                
                <div class="modal-body" id="class_detail">  
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
                     <h4 class="modal-title">EDIT CLASS</h4>  
                </div>  
                <div class="modal-body">
                <form id="insert_form">
                    @csrf    
                          <label> Name</label>  
                              <input type="text" name="name" id="name" class="form-control" />  
                          <br /> 

                          <label> School / Collage / University</label>  
                                            <select class="form-control" name="AcademicType" id="AcademicType" >
                                                    <option value="">Choose any one </option>
                                                    <option id="AcademicType1" value="1" > School</option> 
                                                    <option id="AcademicType2" value="2" > Collage</option> 
                                                    <option id="AcademicType3" value="3" > University</option> 
                                                    <option id="AcademicType4" value="4" > Other</option> 
                                            </select>  
                          <br /> 
                 
                          <input type="hidden" name="class_id" id="class_id" />  
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
//view class
$(document).ready(function(){  
     
    $(document).on('click', '.view_Class', function(){
           var csrf_token = $('input[name=_token]').val();  
           var class_id = $(this).attr("id"); 
           console.log(class_id);
           var url = '/class-show-'; 

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
          
           $.ajax({  
                url: url + class_id,  
                type: 'post',  
                data: {
                    class_id : class_id,
                       "_token": "{{ csrf_token() }}"
                      },  
                success:function(data){  
                    
                     $('#class_detail').html(data);  
                     $('#dataModal').modal("show");  
                }  
           });  
      }); 

    // edit class
    $(document).on('click', '.edit_data', function(){  
            var class_id = $(this).attr("id");  
            var csrf_token = $('input[name=_token]').val();   
            var url = '/class-edit-'; 
            console.log(class_id);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });

            $.ajax({  
                    url: url + class_id,  
                    type: 'post',  
                    data: {
                        id : class_id,
                        "_token": "{{ csrf_token() }}"
                        },    
                    dataType:"json",  
                    success:function(data){  

                        $('#name').val(data.name);
                        $('#class_id').val(data.id);

                        if(data.academic_type == 1){
                            $('#AcademicType1').attr("selected", "selected");          
                        }else if(data.academic_type == 2){
                            $('#AcademicType2').attr("selected", "selected");    
                        }else if(data.academic_type == 3){
                            $('#AcademicType3').attr("selected", "selected");       
                        }else if(data.academic_type == 4){
                            $('#AcademicType4').attr("selected", "selected");             
                        }
                        
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
                var class_id = $('#class_id').val();
                var class_name = $('#name').val();
                var AcademicType = $('#AcademicType').val();
                var csrf_token = $('input[name=_token]').val();
                var url = '/class-update-';
                
                console.log(url+class_id);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                    });

                    $.ajax({  
                        url: url + class_id,  
                        type: 'post', 
                        // dataType: $('#insert_form').serialize(),
                        data : {
                        id : class_id,
                        name : class_name,
                        AcademicType : AcademicType,
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
                                        $.growl.notice({message: "Class Update successfully"});
                                        
                                    }    
                        }  
                    });  
            }  
        });  

    // edit class end

    // delete class 
    $('#datatable-buttons').delegate('.delete', 'click', function(){
    
        var csrf_token = $('input[name=_token]').val();
        var current_tr = $(this).closest('tr');
        var url = '/class-delete-';
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