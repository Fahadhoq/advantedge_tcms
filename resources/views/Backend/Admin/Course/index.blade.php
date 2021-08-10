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
                                <h4 class="page-title">ALL COURSES </h4>
                            </div>
                            
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Training Center Management System</a></li>
                                    <li class="breadcrumb-item active">COURSES </li>
                                    <li class="breadcrumb-item active">ALL COURSES </li>
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
                                                        <th style=text-align:center> SL</th>
                                                        <th style=text-align:center> ID</th>
                                                        <th style=text-align:center> Class</th>
                                                        <th style=text-align:center> Subject</th>
                                                        <th style=text-align:center> Student Limit</th>
                                                        <th style=text-align:center> Course Fee</th>
                                                        <th style=text-align:center> Enrollment Last Date</th>
                                                        <th style=text-align:center> Status</th>    
                                                        <th style=text-align:center> Action</th>  
                                                    </tr>
                                                </thead>
        
        
                                                <tbody>
                                                @php $i=1 @endphp
                                                @foreach($courses as $course)
                                                    <tr>
                                                        <td style=text-align:center scope="row">{{$i++}}</td> 
                                                        <td style=text-align:center scope="row">{{$course->id}}</td>
                                                        <!-- class -->
                                                        @foreach($Classes as $Class)
                                                          @if($Class->id == $course->class)  
                                                             <td style=text-align:center>{{$Class->name}}</td>
                                                          @endif   
                                                        @endforeach
                                                        <!-- class end -->
                                                        <!-- subject -->
                                                        @foreach($Subjects as $Subject)
                                                          @if($Subject->id == $course->subject)  
                                                             <td style=text-align:center>{{$Subject->name}}</td>
                                                          @endif   
                                                        @endforeach
                                                        <!-- subject end -->
                                                        <td style=text-align:center>{{$course->student_limit}}</td>
                                                        <td style=text-align:center>{{$course->course_fee}}</td>
                                                        <td style=text-align:center>{{$course->enrollment_last_date}}</td>
                                                        <!-- status -->
                                                        @if($course->status == 0)
                                                        <td style=text-align:center>
                                                            <button class="btn btn-danger btn-sm course_status_change" data-id="{{$course->id}}" value="InActive">InActive</button>  
                                                        </td>
                                                        @elseif($course->status == 1)
                                                        <td style=text-align:center>
                                                            <button class="btn btn-success btn-sm course_status_change" data-id="{{$course->id}}" value="Active">Active</button> 
                                                        </td>
                                                          @endif
                                                        <!-- status end  -->

                    
                                                        <td style=text-align:center>
                                                            <!-- <a href="" class="btn btn-info btn-sm" title="View course"><i class="fa fa-eye"></i></a> -->
                                                            <!-- jquery view -->
                                                            <a  name="view" value="view" id="{{$course->id}}" class="btn btn-info btn-sm view_course" title="View course"><i class="fa fa-eye"></i></a>
                                                            <!-- jquery view end-->

                                                            <a href="{{ route('course.edit' , $course->id) }}" class="btn btn-warning btn-sm" title="Edit course"><i class="fa fa-edit"></i></a>
                                                           
                                                            @can('delete')
                                                            <button class="btn btn-danger btn-sm delete" data-id="{{$course->id}}" value="{{$course->id}}"><i
                                                            class="fa fa-trash"></i></button>         
                                                            <!-- <a href="" id="{{$course->id}}" class="btn btn-danger btn-sm remove" title="delete course" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash"></i></a> -->
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

<!-- course view -->
<div id="dataModal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                
                <div class="modal-header">  
                     <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->  
                     <h4 class="modal-title">Course Details</h4>  
                </div>  
                
                <div class="modal-body" id="course_detail">  
                </div>  
                
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>
                  
           </div>  
      </div>  
 </div>
<!-- course view end -->

@endsection   


@section('jquery')
<!-- datatable js link add -->
@include('layouts.partials.datatable-js')
@endsection

@section('script')
<script>
//view class
$(document).ready(function(){  
     
    $(document).on('click', '.view_course', function(){
           var csrf_token = $('input[name=_token]').val();  
           var course_id = $(this).attr("id"); 
           console.log(course_id);
           var url = '/course-show-'; 

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
          
           $.ajax({  
                url: url + course_id,  
                type: 'post',  
                data: {
                    course_id : course_id,
                       "_token": "{{ csrf_token() }}"
                      },  
                success:function(data){  
                    
                     $('#course_detail').html(data);  
                     $('#dataModal').modal("show");  
                }  
           });  
      }); 

  // status  change 
$('#datatable-buttons').delegate('.course_status_change', 'click', function(){
     
     var csrf_token = $('input[name=_token]').val();
     
     var url = '/course-status-change-';
     var value = $(this).val();
     var course_id = $(this).attr("data-id");
     console.log(value);
     
     $.confirm({
                 title: 'Confirm!!!',
                 content: 'Are you sure To change status this course?',
                 buttons: {
                     confirm: function () {
                         $.ajaxSetup({
                     headers: {
                         'X-CSRF-TOKEN': "{{ csrf_token() }}"
                     }
                 });
                     
                 $.ajax({
                     url: url + course_id,
                     type: 'post',
                     data: {
                                 id: course_id,
                                 value: value,
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
 //status  change end

    // delete course 
    $('#datatable-buttons').delegate('.delete', 'click', function(){
    
        var csrf_token = $('input[name=_token]').val();
        var current_tr = $(this).closest('tr');
        var url = '/course-delete-';
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