@extends('layouts.MasterDashboard')

@section('css')

<style> 
.mark {
  background-color: #d7ffe7 !important
}

.mark .gsearch{
  font-size: 20px
}

.unmark {
  background-color: #e8e8e8 !important
}

.unmark .gsearch{
  font-size: 10px
}

.marktext
{
 font-weight:bold;
 background-color: antiquewhite;
}
th {
    text-align:center
}
.selectRow
{
    background-color: #b2cdf7;
    color:black;
}
.PaidRow{
    background-color: #9ce5b4;
    color:black;
}
.NonPaidRow{
    background-color: #f95252;
    color:black;
}
.course_table_head_tr{
  background-color: #f0f4f7;
  color:black;
}
.total_course_fee{
    width: 50%;
}
.total_due_course_fee{
    width: 50%;
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
                                    <h4  class="page-title">STUDENT PAYMENT EDIT</h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Training Center Management System</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">PAYMENT</a></li>
                                        <li class="breadcrumb-item active">STUDENT PAYMENT EDIT</li>
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
                                    
                           
                            <form action="" method="post" id="StudentCourseEnrollmentForm">
                                 @csrf

                            <!-- 2nd row     -->
                           <div class="row">

                           <!-- 1st part              -->
                                <div class="col-lg-4">
                                    <div class="p-20">
                                       
                                    <div class="col-sm-12 col-lg-12 table_lable">
                                         <label class="page-title">Student Info </label> 
                                    </div>
                               
                                      <div class="table-responsive ">
                                        <table class="table table-bordered">
                                        
                                                <tr>
                                                    <th class="course_table_head_tr">ID</th>
                                                    <td id="student_id" value="{{$student->id}}" align= "center">{{$student->id}}</td>    
                                                </tr>
                                                <tr>
                                                    <th class="course_table_head_tr">Image</th>
                                                    <td align= "center"> <a href="#"> <img src='storage/'{{$student->profile_photo_path}} width="100px" height="80px"></a> </td>   
                                                </tr>
                                                <tr>
                                                    <th class="course_table_head_tr">Name</th>
                                                    <td align= "center">{{$student->name}}</td>   
                                                </tr>
                                                <tr>
                                                    <th class="course_table_head_tr">Phone Number</th>
                                                    <td align= "center">{{$student->phone}}</td>  
                                                </tr>
                                                <tr>
                                                    <th class="course_table_head_tr">Email</th>
                                                    <td align= "center">{{$student->email}}</td> 
                                                </tr>
                                               
                                        </table>
                                      </div>  
                                    

                                   </br></br>

                                    <div class="col-sm-12 col-lg-12 table_lable">
                                         <label class="page-title">Student Academic Info </label> 
                                    </div>

                                     <div class="table-responsive">
                                        <table class="table table-bordered">
                                        
                                                <tr>
                                                    <th class="course_table_head_tr">Academic Type</th>
                                                    <td  align= "center">
                                                       @if(@$student_academic_info->user_academic_type == 1)
                                                            School
                                                       @elseif(@$student_academic_info->user_academic_type == 2)
                                                            Collage
                                                       @elseif(@$student_academic_info->user_academic_type == 3)
                                                            University
                                                       @elseif(@$student_academic_info->user_academic_type == 4)
                                                             Other
                                                       @endif
                                                       
                                                    </td>    
                                                </tr>
                                                <tr>
                                                    <th class="course_table_head_tr">Class</th>
                                                    @php $student_academic_Type = App\Models\Classes::select('name')->where('id' , @$student_academic_info->user_class)->first(); @endphp
                                                    <td align= "center">{{@$student_academic_Type->name}}</td>   
                                                </tr>
                                                <tr>
                                                    <th class="course_table_head_tr">Institute Name</th>
                                                    <td align= "center">{{@$student_academic_info->user_institute_name}}</td>  
                                                </tr>
                                               
                                        </table>
                                     </div>

                                    </div>
                                    <!-- p-20 -->
                                </div>
                                        <!-- col-lg-6    -->
                                    <!-- 1st part end     -->
                                   

                                    <!-- 2nd part              -->
                                        <div class="col-lg-8">
                                                <div class="p-20">
                                                       <label>Course List </label>

                                                    <div id="StudentCourdsdetail"></div>

                                            </div>
                                            <!-- col-lg-6 -->
                                        </div> 
                                        <!-- p-20 -->
                                    <!-- 2nd part end     -->    

                                 </div>  
                            <!-- 2nd row end                -->  
   
                                    <div style=text-align:center class="col-xl-12">
                                         <!-- submit button    -->
                                         <button type="button" id="Paymentsubmit"  class="btn btn-primary">Submit</button>
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

<!-- view payment table -->
<div id="dataModal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                
                <div class="modal-header">  
                     <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->  
                     <h4 class="modal-title">Payment Details</h4>  
                </div>  
                
                <div class="modal-body" id="Payment_Details">  
                        
                        <div class="form-group">
                            <lable style=font-weight:bold>PAY AMOUNT </lable>
                            <input type="text" class="form-control" name="Pay_Amount" id="Pay_Amount" value="" placeholder="Enter Payment Amount">
                        </div>

                        <div class="form-group">
                            <lable style=font-weight:bold>PAYMENT TYPE</lable>
                            <select class="form-control" id="payment_type" name="payment_type">
                                <option value="0">Choose One Type</option>
                                <option id="payment_type_CASH" value="1">CASH</option>
                                <option id="payment_type_BKash"value="2">BKash</option>
                                <option id="payment_type_Rocket" value="3">Rocket</option>
                                <option id="payment_type_Cheque" value="4">Cheque</option>
                                <option id="payment_type_OTHER" value="5">OTHER</option>
                            </select>
                        </div>

                        <div class="form-group BKash_Or_Rocket">
                            <label>MOBILE NUMBER</label>
                            <div>
                                <input class="form-control" type="text" name="payment_mobile_number" id="payment_mobile_number"> 
                            </div>
                            <label>TRANSACTION NUMBER <small>(last 4 digit)</small></label>
                            <div>
                                <input class="form-control" type="text" name="payment_transaction_number" id="payment_transaction_number"> 
                            </div>
                        </div>

                        <div class="form-group cheque_transit_number">
                            <label>CHEQUE TRANSIT NUMBER <small>(last 9 digit)</small></label>
                            <div>
                                <input class="form-control" type="text" name="cheque_transit_number" id="cheque_transit_number"> 
                            </div>
                        </div>

                        <div class="form-group remark">
                            <label>REMARK</label>
                            <div>
                                <input class="form-control" type="text" name="payment_remark" id="payment_remark"> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label>PAYMENT DATE</label>
                            <div>
                                <input class="form-control" type="date" name="payment_date" id="payment_date"> 
                            </div>
                        </div>

                </div>  
                
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" id="Pay_Submit" data-dismiss="modal">Pay</button>
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>
                  
           </div>  
      </div>  
 </div>
<!-- view payment table end -->

@endsection        

@section('jquery')
<script src="{{URL::to('assets/js/admin/Student_Enrollment/JsLocalSearch.js')}}" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>  
@endsection

@section('script')
<script>
$(document).ready(function(){

//student course detials show start

var url = '/student-payment-student-course-detials-show-';   
var SearchStudent = $("#student_id").text();
// console.log(SearchStudent);
var csrf_token = $('input[name=_token]').val();

$.ajaxSetup({
          headers: {
                      'X-CSRF-TOKEN': "{{ csrf_token() }}"
                  }
      });

$.ajax({
      url: url+SearchStudent,
      type: 'post',
      data:{
          SearchStudent : SearchStudent,
              "_token": "{{ csrf_token() }}"
           },
                  
              success:function(data)
              {
                  $('#StudentCourdsdetail').html(data);
                 // $('#student_id').val(data.id);
                // console.log(data);
              }
 });



//student course detials show end

//select offer course
$(document).on('click', '.select_course', function(){
    
    var offer_Course_id = $(this).val();
    var course_fee = $('.course_fee'+offer_Course_id).val();
    var total_course_fee = $('.total_course_fee').val();

   if($(this).is(':checked'))
   {
       $(this).closest('tr').removeClass('NonPaidRow');
       $(this).closest('tr').addClass('selectRow');

       total_course_fee = parseInt(total_course_fee) + parseInt(course_fee);
       $(".total_course_fee").val(total_course_fee);
       
   }
   else
   {
       $(this).closest('tr').removeClass('selectRow');
       $(this).closest('tr').addClass('NonPaidRow');

       total_course_fee = parseInt(total_course_fee) - parseInt(course_fee);
       $(".total_course_fee").val(total_course_fee);
   }

});
//select offer course end 

var select_course_due_payment = 0;
//calculate due amount
$(document).on('click', '.select_course_due_payment', function(){

    var due_payment = $('.select_course_due_payment').val();
    var total_course_fee = $('.total_course_fee').val();

    if($(this).is(':checked'))
    {
        if(due_payment > 0){
            $(this).closest('tr').removeClass('NonPaidRow');
            $(this).closest('tr').addClass('selectRow');
        }
        total_course_fee = parseInt(total_course_fee) + parseInt(due_payment);
        $(".total_course_fee").val(total_course_fee);

        select_course_due_payment = 1;
        
    }else{
        if(due_payment > 0){
            $(this).closest('tr').removeClass('selectRow');
            $(this).closest('tr').addClass('NonPaidRow');
        }

        total_course_fee = parseInt(total_course_fee) - parseInt(due_payment);
        $(".total_course_fee").val(total_course_fee);

        select_course_due_payment = 0;
    }
});
//calculate due amount end

//view payment detials
$(document).on('click', '#Paymentsubmit', function(){
        var select_student =  $("#student_id").text(); 
        var total_course_fee = $(".total_course_fee").val();

        if(select_student.length != 0){
            if(total_course_fee > 0){
                $('#dataModal').modal("show"); 
                $("#Pay_Amount").val(total_course_fee);
            }else{
                $.growl.error({message: "Your Payment Is Not Sufficient"});
            }
        }else{
            $.growl.error({message: "Select One Student"});
        }

});

$('.BKash_Or_Rocket').hide();
$('.cheque_transit_number').hide();
$(document).on('click', '#payment_type', function(){
        var payment_type =  $(this).val(); 
       
        if( (payment_type == 2) || (payment_type == 3) ){
            $('.BKash_Or_Rocket').show();
            $('.cheque_transit_number').hide();     
        }else if(payment_type == 4){
            $('.cheque_transit_number').show();
            $('.BKash_Or_Rocket').hide();
        }else if((payment_type == 1) || (payment_type == 5)){
            $('.cheque_transit_number').hide();
            $('.BKash_Or_Rocket').hide();
        }

});
//view payment detials end

//payment store
$("#Pay_Submit").click(function(){        
       var select_student =  $("#student_id").text();
       var select_enroll_course_checkbox = $('.select_course:checked');
       var Pay_Amount =  $("#Pay_Amount").val();
       var payment_type =  $("#payment_type").val();
       var payment_date =  $("#payment_date").val();
       var count_total_course_fee =  $(".count_total_course_fee").val();
       var select_course_due_payment = $('.select_course_due_payment:checked');

       var payment_mobile_number =  $("#payment_mobile_number").val();
       var payment_transaction_number =  $("#payment_transaction_number").val();
       var cheque_transit_number =  $("#cheque_transit_number").val();
       var payment_remark =  $("#payment_remark").val(); console.log(payment_mobile_number);

       var csrf_token = $('input[name=_token]').val();
       var url = '/student-payment-store'; 
      // console.log(count_total_course_fee);

       if(Pay_Amount <= 0){
             $.growl.error({message: "You Are Not Pay Much Amount"});
       }else if(payment_type == 0){
             $.growl.error({message: "Select a payment type"});
       }else if(!$("#payment_date").val()){
             $.growl.error({message: "Select a payment date"});
       }else{
        //stor
         
            if( (select_enroll_course_checkbox.length > 0) && (select_course_due_payment.length > 0) ){

                var payment_name = "new and due payment";
                
                //select enroll course
                var select_enroll_course_checkbox_value = [];
                $(select_enroll_course_checkbox).each(function(){
                    select_enroll_course_checkbox_value.push($(this).val());
                });
                //select enroll course end

                //due payment
                var select_due_course_fee_value = [];
                $(select_course_due_payment).each(function(){
                    select_due_course_fee_value.push($(this).val());
                });
                //due payment

                // console.log(select_enroll_course_checkbox_value);

                $.ajaxSetup({
                headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                });

                $.ajax({
                        url: url,
                        type: 'post',
                        data:{
                            student_id : select_student,
                            select_enroll_course_ids : select_enroll_course_checkbox_value,
                            due_course_fee_values : select_due_course_fee_value,
                            Pay_Amount : Pay_Amount,
                            payment_name : payment_name,
                            payment_mobile_number : payment_mobile_number,
                            payment_transaction_number : payment_transaction_number,
                            cheque_transit_number : cheque_transit_number,
                            payment_remark : payment_remark,
                            payment_type : payment_type,
                            payment_date : payment_date,

                                "_token": "{{ csrf_token() }}"
                            },
                                    
                                success : function(data)
                                {
                                    if(data.error) {
                                        $.growl.error({message: data.error});
                                    }else if(data.success){
                                    
                                        $.growl.notice({message: data.success});
                                     window.location.href = "/students-payment-list";
                                    }
                                }         
                });

            }else if(select_enroll_course_checkbox.length > 0){

                    var payment_name = "new payment";
                   
                    var select_enroll_course_checkbox_value = [];
                    $(select_enroll_course_checkbox).each(function(){
                        select_enroll_course_checkbox_value.push($(this).val());
                    });

                   // console.log(select_enroll_course_checkbox_value);

                    $.ajaxSetup({
                    headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            }
                    });

                    $.ajax({
                            url: url,
                            type: 'post',
                            data:{
                                student_id : select_student,
                                select_enroll_course_ids : select_enroll_course_checkbox_value,
                                Pay_Amount : Pay_Amount,
                                payment_name : payment_name,
                                payment_type : payment_type,
                                payment_mobile_number : payment_mobile_number,
                                payment_transaction_number : payment_transaction_number,
                                cheque_transit_number : cheque_transit_number,
                                payment_date : payment_date,

                                    "_token": "{{ csrf_token() }}"
                                },
                                        
                                    success : function(data)
                                    {
                                        if(data.error) {
                                            $.growl.error({message: data.error});
                                        }else if(data.success){
                                        
                                            $.growl.notice({message: data.success});
                                            window.location.href = "/students-payment-list";
                                        }
                                    }         
                    });

                }else if(select_course_due_payment.length > 0){

                    var select_due_course_fee_value = [];
                    $(select_course_due_payment).each(function(){
                        select_due_course_fee_value.push($(this).val());
                    });

                      // console.log(select_due_course_fee_value);
                        var payment_name = "due payment";
                      
                        $.ajaxSetup({
                        headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                }
                        });

                        $.ajax({
                                url: url,
                                type: 'post',
                                data:{
                                    student_id : select_student,
                                    due_course_fee_values : select_due_course_fee_value,
                                    payment_name : payment_name,
                                    Pay_Amount : Pay_Amount,
                                    payment_type : payment_type,
                                    payment_mobile_number : payment_mobile_number,
                                    payment_transaction_number : payment_transaction_number,
                                    cheque_transit_number : cheque_transit_number,
                                    payment_date : payment_date,

                                        "_token": "{{ csrf_token() }}"
                                    },
                                            
                                        success : function(data)
                                        {
                                            if(data.error) {
                                                $.growl.error({message: data.error});
                                            }else if(data.success){
                                            
                                                $.growl.notice({message: data.success});
                                                window.location.href = "/students-payment-list";
                                            }
                                        }         
                        });    

                }else{
                    $.growl.error({message: "Select At Least One Payment"});
                }

       }
       //stor end

    });
//payment store end

});    
          
</script>
@endsection