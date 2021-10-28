<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Carbon\Carbon;
use App\Models\Course;
use App\Models\User;
use App\Models\Student_Course_Enrollment;
use App\Models\Classes;
use App\Models\StudentPayment;
use App\Models\User_Academic_Info;

class StudentPaymentController extends Controller
{
    public function index()
    {
        $data['StudentsInfos'] = Student_Course_Enrollment::select('user_id')->groupBy('user_id')->get();
        $data['StudentsEnrollmentCourses'] = Student_Course_Enrollment::get();
        $data['StudentsPayment'] = StudentPayment::get();
        
        return view('Backend.Payment.student_payment.index' , $data);
    }

    public function pay(){  
        return view('Backend.Payment.student_payment.pay');
    }

    public function student_course_detials_show(Request $request){
        
        if(isset($request->SearchStudent)){
           
            $SearchStudent = trim($request->SearchStudent);

            $user = User::where('email', $SearchStudent)
                                  ->orWhere('id', $SearchStudent)
                                  ->first();
            
            $Student_Courses_Enrollment = Student_Course_Enrollment::where('user_id', $user->id)->get();
            $offer_Courses = Course::get();
            $total_course_fee = 0;
            $count_total_course_fee = 0;
         
            $output = '
                        <table class="table table-bordered ">
                        <tr>
                            <th>Select</th>
                            <th>ID</th>
                            <th>Class</th>
                            <th>Subject Name</th>
                            <th>Course Fee</th>
                            <th>Enrolled Date</th> 
                        </tr>';
           
            foreach ($offer_Courses as $offer_Course) {
                foreach ($Student_Courses_Enrollment as $Student_Course_Enrollment) {
                   if($offer_Course->id == $Student_Course_Enrollment->course_id){ 
                    // student info
                        if($Student_Course_Enrollment->is_pay == 0){
                             $output .= '<tr class="NonPaidRow">';
                             $output .= '<td align= "center">
                                          <input type="checkbox" class="select_course" id="'.$Student_Course_Enrollment->id.'" value="'.$Student_Course_Enrollment->id.'" >
                                        </td>';
                             $count_total_course_fee = $count_total_course_fee + $offer_Course->course_fee;
                        }else{
                            $output .= '<tr class="PaidRow">';
                            $output .= '<td></td>';
                        }

                        //id    
                            $output .= '<td align= "center">'.$offer_Course->id.'</td>';
                        //id end
                        
                        //class        
                            $output .=  '<td align= "center">'. $offer_Course->classss->name .'</td>';  
                        //class end  

                        //subject        
                        $output .=  '<td align= "center">'. $offer_Course->subjectss->name .'</td>';  
                        //subject end
                        $output .=  '<td align= "center" >'. $offer_Course->course_fee.'</td>
                                    <td align= "center">'. $offer_Course->created_at->format('d-m-Y').'</td>';
                                     
                       
                       $output .=  ' </tr>
                        
                        <input type="hidden" class="course_fee'.$Student_Course_Enrollment->id.'" value="'.$offer_Course->course_fee.'" >';
                        
                        //student info end
                   }
                }
            }

            $total_payment = 0;
            $paid_total_enrolled_course_fee = 0;


            $Student_Courses_Enrollment_paid = Student_Course_Enrollment::where('user_id', $user->id)->where('is_pay' , 1)->get();
            $offer_Courses_paid = Course::get();

            foreach ($offer_Courses_paid as $offer_Course_paid) {
                foreach ($Student_Courses_Enrollment_paid as $Student_Course_Enrollment_paid) {
                   if($offer_Course_paid->id == $Student_Course_Enrollment_paid->course_id){ 
                      $paid_total_enrolled_course_fee = $paid_total_enrolled_course_fee + $offer_Course_paid->course_fee;
                   }
                }
            }

            $Student_Payments = StudentPayment::where('user_id' , $user->id)->get();
            
            foreach ($Student_Payments as $Student_Payment) {
                $total_payment = $total_payment + $Student_Payment->payment_amount;
            }

            $due_payment = $paid_total_enrolled_course_fee - $total_payment;

            if($due_payment > 0){
                $output .= '<tr class="NonPaidRow">
                                <td align= "center">
                                    <input type="checkbox" class="select_course_due_payment" value="'.$due_payment.'" >
                                </td>
                                <td></td>
                                <td></td>
                                <td align= "center">Due Amount</td>             
                                <td align= "center"><input  class="total_due_course_fee" value="'.$due_payment.'" readonly></td> 
                                <td></td>
                            </tr>';
            }else{
                $output .= '<tr class="selectRow">
                                <td align= "center">
                                    <input type="checkbox" class="select_course_due_payment" value="'.$due_payment.'" >
                                </td>
                                <td></td>
                                <td></td>
                                <td align= "center">Due Amount</td>             
                                <td align= "center"><input  class="total_due_course_fee" value="'.$due_payment.'" readonly></td> 
                                <td></td>
                            </tr>';
            } 
            $output .=  '<tr>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td align= "center">Total Amount</td>             
                           <td align= "center"><input  class="total_course_fee" value="'.$total_course_fee.'" readonly></td>
                           <input type="hidden" class="count_total_course_fee" value="'.$count_total_course_fee.'" >
                       </tr>';
      
            $output .= '</table>';

            echo $output;
        }
    }

    public function payment_store(Request $request){

        $payment_type = $request->payment_type;
        $payment_mobile_number = $request->payment_mobile_number;
        $payment_transaction_number = $request->payment_transaction_number;
        $cheque_transit_number = $request->cheque_transit_number;
        $payment_remark = $request->payment_remark;
     
        if( ($payment_type == 2) || ($payment_type == 3) ){
            if( ($payment_mobile_number == null) && ($payment_transaction_number == null) ){
                 return response()->json([ 'error' => 'Please enter bkash number and transaction number']);
            }elseif( $payment_mobile_number == null ){
                 return response()->json([ 'error' => 'Please enter bkash number']);
            }elseif( $payment_transaction_number == null ){
                return response()->json([ 'error' => 'Please enter transaction number']);
            }elseif( ($payment_mobile_number != null) && ($payment_transaction_number != null) ){

                $payment_transaction_number_validator = Validator::make($request->all(), [
                    'payment_transaction_number' => 'required|min:4|max:4',
                ]);

                $payment_mobile_number_validator = Validator::make($request->all(), [
                    'payment_mobile_number' => 'required|regex:/(01)[0-9]{9}/|min:11|max:11',
                ]);
        
                if($payment_transaction_number_validator->fails()){
                    return response()->json([ 'error' => 'payment transaction number is not valid']);
                }elseif ($payment_mobile_number_validator->fails()){
                    return response()->json([ 'error' => 'payment mobile number is not valid']);
                }else{
                    if(isset($request->student_id)){
                        $student_id = $request->student_id;
            
                        if($request->payment_name == "new payment"){
                            if(count($request->select_enroll_course_ids) != 0){
                                
                                $select_enroll_course_ids = $request->select_enroll_course_ids;
                                $Total_Enroll_Course_Fee = 0;
                                
                                foreach ($select_enroll_course_ids as  $select_enroll_course_id){
                                    //calculate selected offer course
                                      $Student_Course_Enrollment = Student_Course_Enrollment::select('course_id')->where('id' , $select_enroll_course_id)->first();
                                      $Student_Enroll_Course_Fee = Course::select('course_fee')->where('id' , $Student_Course_Enrollment->course_id)->first();
                                      $Total_Enroll_Course_Fee = $Total_Enroll_Course_Fee + $Student_Enroll_Course_Fee->course_fee;
                                    //calculate selected offer course end
                                }
            
            
                                if($request->Pay_Amount <= $Total_Enroll_Course_Fee){
            
                                    foreach ($select_enroll_course_ids as  $select_enroll_course_id){
                                        //Student Course Enrollment table update
                                          $Student_Course_Enrollment = Student_Course_Enrollment::find($select_enroll_course_id);
                                          $Student_Course_Enrollment->is_pay = 1;
                                          $Student_Course_Enrollment->save();
                                    }
            
                                    //Student payment table insert
                                    $Student_Payment = new StudentPayment;
                                    $Student_Payment->user_id = $student_id;
                                    $Student_Payment->payment_amount = $request->Pay_Amount;
                                    $Student_Payment->payment_type = $request->payment_type;
                                    $Student_Payment->payment_date = $request->payment_date;
                                    $Student_Payment->payment_mobile_number = $request->payment_mobile_number;
                                    $Student_Payment->payment_transaction_number = $request->payment_transaction_number;
                                    if($payment_remark != null){
                                        $Student_Payment->payment_remark = $request->payment_remark;
                                    }
                                    $Student_Payment->save();
            
                                }else{
                                    return response()->json([ 'error' => 'You Are Pay More Than Your Payment Amount']);
                                }
            
                            }
                        }elseif ($request->payment_name == "due payment"){
            
                            $due_course_fee_values = $request->due_course_fee_values;
                                 
                            foreach ($due_course_fee_values as  $due_course_fee_value){
                                if($request->Pay_Amount <= $due_course_fee_value){
                                    //Student payment table insert
                                    $Student_Payment = new StudentPayment;
                                    $Student_Payment->user_id = $student_id;
                                    $Student_Payment->payment_amount = $request->Pay_Amount;
                                    $Student_Payment->payment_type = $request->payment_type;
                                    $Student_Payment->payment_date = $request->payment_date;
                                    $Student_Payment->payment_mobile_number = $request->payment_mobile_number;
                                    $Student_Payment->payment_transaction_number = $request->payment_transaction_number;
                                    if($payment_remark != null){
                                        $Student_Payment->payment_remark = $request->payment_remark;
                                    }
                                    $Student_Payment->save();
                                }else{
                                    return response()->json([ 'error' => 'You Are Pay More Than Your Payment Amount']);
                                }
                            }  
                        }elseif ($request->payment_name == "new and due payment"){
            
                            $due_course_fee_values = $request->due_course_fee_values;
                            $select_enroll_course_ids = $request->select_enroll_course_ids;
                            $Total_Enroll_Course_Fee = 0;
                            $due_course_fee = 0;
                            
                            //selected course fee
                            foreach ($select_enroll_course_ids as  $select_enroll_course_id){
                                //calculate selected offer course
                                    $Student_Course_Enrollment = Student_Course_Enrollment::select('course_id')->where('id' , $select_enroll_course_id)->first();
                                    $Student_Enroll_Course_Fee = Course::select('course_fee')->where('id' , $Student_Course_Enrollment->course_id)->first();
                                    $Total_Enroll_Course_Fee = $Total_Enroll_Course_Fee + $Student_Enroll_Course_Fee->course_fee;
                                //calculate selected offer course end
                            }
                            //selected course fee end
                             
                            //due course fee
                            foreach ($due_course_fee_values as  $due_course_fee_value){
                                $due_course_fee = $due_course_fee + $due_course_fee_value;
                            }
                            //due course fee end
            
                            $due_course_fee_and_Total_Enroll_Course_Fee = $Total_Enroll_Course_Fee + $due_course_fee;
            
                            if($request->Pay_Amount <= $due_course_fee_and_Total_Enroll_Course_Fee){
                                
                                foreach ($select_enroll_course_ids as  $select_enroll_course_id){
                                    //Student Course Enrollment table update
                                      $Student_Course_Enrollment = Student_Course_Enrollment::find($select_enroll_course_id);
                                      $Student_Course_Enrollment->is_pay = 1;
                                      $Student_Course_Enrollment->save();
                                }
            
                                //Student payment table insert
                                $Student_Payment = new StudentPayment;
                                $Student_Payment->user_id = $student_id;
                                $Student_Payment->payment_amount = $request->Pay_Amount;
                                $Student_Payment->payment_type = $request->payment_type;
                                $Student_Payment->payment_date = $request->payment_date;
                                $Student_Payment->payment_mobile_number = $request->payment_mobile_number;
                                $Student_Payment->payment_transaction_number = $request->payment_transaction_number;
                                if($payment_remark != null){
                                    $Student_Payment->payment_remark = $request->payment_remark;
                                }
                                $Student_Payment->save();
                            
                            }else{
                                return response()->json([ 'error' => 'You Are Pay More Than Your Payment Amount']);
                            }
            
                        }
            
                      echo  $this->SetMessage('Payment Successfull' , 'success');
                      return response()->json([ 'success' => 'Payment Successfull']);
            
                    }else{
                        return response()->json([ 'error' => 'Select One Student']);
                    }
                }

            }
        }elseif($payment_type == 4){
             if( $cheque_transit_number == null){
                  return response()->json([ 'error' => 'Please enter cheque transit number']);
            }else {

                $cheque_transit_number_validator = Validator::make($request->all(), [
                    'cheque_transit_number' => 'required|min:9|max:9',
                ]);
        
                if($cheque_transit_number_validator->fails()){
                    return response()->json([ 'error' => 'payment cheque transit number is not valid']);
                }else{
                    
                    if(isset($request->student_id)){
                        $student_id = $request->student_id;
            
                        if($request->payment_name == "new payment"){
                            if(count($request->select_enroll_course_ids) != 0){
                                
                                $select_enroll_course_ids = $request->select_enroll_course_ids;
                                $Total_Enroll_Course_Fee = 0;
                                
                                foreach ($select_enroll_course_ids as  $select_enroll_course_id){
                                    //calculate selected offer course
                                      $Student_Course_Enrollment = Student_Course_Enrollment::select('course_id')->where('id' , $select_enroll_course_id)->first();
                                      $Student_Enroll_Course_Fee = Course::select('course_fee')->where('id' , $Student_Course_Enrollment->course_id)->first();
                                      $Total_Enroll_Course_Fee = $Total_Enroll_Course_Fee + $Student_Enroll_Course_Fee->course_fee;
                                    //calculate selected offer course end
                                }
            
            
                                if($request->Pay_Amount <= $Total_Enroll_Course_Fee){
            
                                    foreach ($select_enroll_course_ids as  $select_enroll_course_id){
                                        //Student Course Enrollment table update
                                          $Student_Course_Enrollment = Student_Course_Enrollment::find($select_enroll_course_id);
                                          $Student_Course_Enrollment->is_pay = 1;
                                          $Student_Course_Enrollment->save();
                                    }
            
                                    //Student payment table insert
                                    $Student_Payment = new StudentPayment;
                                    $Student_Payment->user_id = $student_id;
                                    $Student_Payment->payment_amount = $request->Pay_Amount;
                                    $Student_Payment->payment_type = $request->payment_type;
                                    $Student_Payment->payment_date = $request->payment_date;
                                    $Student_Payment->cheque_transit_number  = $request->cheque_transit_number;
                                    if($payment_remark != null){
                                        $Student_Payment->payment_remark = $request->payment_remark;
                                    }
                                    $Student_Payment->save();
            
                                }else{
                                    return response()->json([ 'error' => 'You Are Pay More Than Your Payment Amount']);
                                }
            
                            }
                        }elseif ($request->payment_name == "due payment"){
            
                            $due_course_fee_values = $request->due_course_fee_values;
                                 
                            foreach ($due_course_fee_values as  $due_course_fee_value){
                                if($request->Pay_Amount <= $due_course_fee_value){
                                    //Student payment table insert
                                    $Student_Payment = new StudentPayment;
                                    $Student_Payment->user_id = $student_id;
                                    $Student_Payment->payment_amount = $request->Pay_Amount;
                                    $Student_Payment->payment_type = $request->payment_type;
                                    $Student_Payment->payment_date = $request->payment_date;
                                    $Student_Payment->cheque_transit_number = $request->cheque_transit_number;
                                    if($payment_remark != null){
                                        $Student_Payment->payment_remark = $request->payment_remark;
                                    }
                                    $Student_Payment->save();
                                }else{
                                    return response()->json([ 'error' => 'You Are Pay More Than Your Payment Amount']);
                                }
                            }  
                        }elseif ($request->payment_name == "new and due payment"){
            
                            $due_course_fee_values = $request->due_course_fee_values;
                            $select_enroll_course_ids = $request->select_enroll_course_ids;
                            $Total_Enroll_Course_Fee = 0;
                            $due_course_fee = 0;
                            
                            //selected course fee
                            foreach ($select_enroll_course_ids as  $select_enroll_course_id){
                                //calculate selected offer course
                                    $Student_Course_Enrollment = Student_Course_Enrollment::select('course_id')->where('id' , $select_enroll_course_id)->first();
                                    $Student_Enroll_Course_Fee = Course::select('course_fee')->where('id' , $Student_Course_Enrollment->course_id)->first();
                                    $Total_Enroll_Course_Fee = $Total_Enroll_Course_Fee + $Student_Enroll_Course_Fee->course_fee;
                                //calculate selected offer course end
                            }
                            //selected course fee end
                             
                            //due course fee
                            foreach ($due_course_fee_values as  $due_course_fee_value){
                                $due_course_fee = $due_course_fee + $due_course_fee_value;
                            }
                            //due course fee end
            
                            $due_course_fee_and_Total_Enroll_Course_Fee = $Total_Enroll_Course_Fee + $due_course_fee;
            
                            if($request->Pay_Amount <= $due_course_fee_and_Total_Enroll_Course_Fee){
                                
                                foreach ($select_enroll_course_ids as  $select_enroll_course_id){
                                    //Student Course Enrollment table update
                                      $Student_Course_Enrollment = Student_Course_Enrollment::find($select_enroll_course_id);
                                      $Student_Course_Enrollment->is_pay = 1;
                                      $Student_Course_Enrollment->save();
                                }
            
                                //Student payment table insert
                                $Student_Payment = new StudentPayment;
                                $Student_Payment->user_id = $student_id;
                                $Student_Payment->payment_amount = $request->Pay_Amount;
                                $Student_Payment->payment_type = $request->payment_type;
                                $Student_Payment->payment_date = $request->payment_date;
                                $Student_Payment->cheque_transit_number  = $request->cheque_transit_number;
                                if($payment_remark != null){
                                    $Student_Payment->payment_remark = $request->payment_remark;
                                }
                                $Student_Payment->save();
                            
                            }else{
                                return response()->json([ 'error' => 'You Are Pay More Than Your Payment Amount']);
                            }
            
                        }
            
                      echo  $this->SetMessage('Payment Successfull' , 'success');
                      return response()->json([ 'success' => 'Payment Successfull']);
            
                    }else{
                        return response()->json([ 'error' => 'Select One Student']);
                    }
                }

            }
        }elseif( ($payment_type == 5) || ($payment_type == 1) ){

            if( ($payment_remark == null) && ($payment_type == 5) ){
                  return response()->json([ 'error' => 'Please write payment remark']);
            }else {
               if(isset($request->student_id)){
                    $student_id = $request->student_id;
        
                    if($request->payment_name == "new payment"){
                        if(count($request->select_enroll_course_ids) != 0){
                            
                            $select_enroll_course_ids = $request->select_enroll_course_ids;
                            $Total_Enroll_Course_Fee = 0;
                            
                            foreach ($select_enroll_course_ids as  $select_enroll_course_id){
                                //calculate selected offer course
                                  $Student_Course_Enrollment = Student_Course_Enrollment::select('course_id')->where('id' , $select_enroll_course_id)->first();
                                  $Student_Enroll_Course_Fee = Course::select('course_fee')->where('id' , $Student_Course_Enrollment->course_id)->first();
                                  $Total_Enroll_Course_Fee = $Total_Enroll_Course_Fee + $Student_Enroll_Course_Fee->course_fee;
                                //calculate selected offer course end
                            }
        
        
                            if($request->Pay_Amount <= $Total_Enroll_Course_Fee){
        
                                foreach ($select_enroll_course_ids as  $select_enroll_course_id){
                                    //Student Course Enrollment table update
                                      $Student_Course_Enrollment = Student_Course_Enrollment::find($select_enroll_course_id);
                                      $Student_Course_Enrollment->is_pay = 1;
                                      $Student_Course_Enrollment->save();
                                }
        
                                //Student payment table insert
                                $Student_Payment = new StudentPayment;
                                $Student_Payment->user_id = $student_id;
                                $Student_Payment->payment_amount = $request->Pay_Amount;
                                $Student_Payment->payment_type = $request->payment_type;
                                $Student_Payment->payment_date = $request->payment_date;
                                if($payment_remark != null){
                                    $Student_Payment->payment_remark = $request->payment_remark;
                                }
                                $Student_Payment->save();
        
                            }else{
                                return response()->json([ 'error' => 'You Are Pay More Than Your Payment Amount']);
                            }
        
                        }
                    }elseif ($request->payment_name == "due payment"){
        
                        $due_course_fee_values = $request->due_course_fee_values;
                             
                        foreach ($due_course_fee_values as  $due_course_fee_value){
                            if($request->Pay_Amount <= $due_course_fee_value){
                                //Student payment table insert
                                $Student_Payment = new StudentPayment;
                                $Student_Payment->user_id = $student_id;
                                $Student_Payment->payment_amount = $request->Pay_Amount;
                                $Student_Payment->payment_type = $request->payment_type;
                                $Student_Payment->payment_date = $request->payment_date;
                                if($payment_remark != null){
                                    $Student_Payment->payment_remark = $request->payment_remark;
                                }
                                $Student_Payment->save();
                            }else{
                                return response()->json([ 'error' => 'You Are Pay More Than Your Payment Amount']);
                            }
                        }  
                    }elseif ($request->payment_name == "new and due payment"){
        
                        $due_course_fee_values = $request->due_course_fee_values;
                        $select_enroll_course_ids = $request->select_enroll_course_ids;
                        $Total_Enroll_Course_Fee = 0;
                        $due_course_fee = 0;
                        
                        //selected course fee
                        foreach ($select_enroll_course_ids as  $select_enroll_course_id){
                            //calculate selected offer course
                                $Student_Course_Enrollment = Student_Course_Enrollment::select('course_id')->where('id' , $select_enroll_course_id)->first();
                                $Student_Enroll_Course_Fee = Course::select('course_fee')->where('id' , $Student_Course_Enrollment->course_id)->first();
                                $Total_Enroll_Course_Fee = $Total_Enroll_Course_Fee + $Student_Enroll_Course_Fee->course_fee;
                            //calculate selected offer course end
                        }
                        //selected course fee end
                         
                        //due course fee
                        foreach ($due_course_fee_values as  $due_course_fee_value){
                            $due_course_fee = $due_course_fee + $due_course_fee_value;
                        }
                        //due course fee end
        
                        $due_course_fee_and_Total_Enroll_Course_Fee = $Total_Enroll_Course_Fee + $due_course_fee;
        
                        if($request->Pay_Amount <= $due_course_fee_and_Total_Enroll_Course_Fee){
                            
                            foreach ($select_enroll_course_ids as  $select_enroll_course_id){
                                //Student Course Enrollment table update
                                  $Student_Course_Enrollment = Student_Course_Enrollment::find($select_enroll_course_id);
                                  $Student_Course_Enrollment->is_pay = 1;
                                  $Student_Course_Enrollment->save();
                            }
        
                            //Student payment table insert
                            $Student_Payment = new StudentPayment;
                            $Student_Payment->user_id = $student_id;
                            $Student_Payment->payment_amount = $request->Pay_Amount;
                            $Student_Payment->payment_type = $request->payment_type;
                            $Student_Payment->payment_date = $request->payment_date;
                            if($payment_remark != null){
                                $Student_Payment->payment_remark = $request->payment_remark;
                            }
                            $Student_Payment->save();
                        
                        }else{
                            return response()->json([ 'error' => 'You Are Pay More Than Your Payment Amount']);
                        }
        
                    }
        
                  echo  $this->SetMessage('Payment Successfull' , 'success');
                  return response()->json([ 'success' => 'Payment Successfull']);
        
                }else{
                    return response()->json([ 'error' => 'Select One Student']);
                }
            }
        }

    }

    public function student_payment_view(Request $request , $student_id){
        
                if(isset($student_id)){
        
                $student = User::where('id', $student_id)->first();
                $student_academic_info = User_Academic_Info::select('user_academic_type','user_class','user_institute_name')
                                                                       ->where('user_id', $student_id)
                                                                       ->first();
             
                $Student_Payments = StudentPayment::where('user_id', $student_id)->get(); 
                $Total_Paid_Amount = 0;
                foreach ($Student_Payments as $Student_Payment) {
                    $Total_Paid_Amount = $Total_Paid_Amount + $Student_Payment->payment_amount;
                }
                
                $Student_Enrolled_Courses = Student_Course_Enrollment::where('user_id', $student_id)->get(); 
                $Total_Enroll_Course_Fee = 0;
                foreach ($Student_Enrolled_Courses as $Student_Enrolled_Course) {
                    $Student_Enroll_Course_Fee = Course::select('course_fee')->where('id' , $Student_Enrolled_Course->course_id)->first();
                    $Total_Enroll_Course_Fee = $Total_Enroll_Course_Fee + $Student_Enroll_Course_Fee->course_fee;
                }
        
                return view('Backend.Payment.student_payment.payment_view')->with('student', $student)
                                                                   ->with('student_academic_info', $student_academic_info)
                                                                   ->with('Student_Payments', $Student_Payments)
                                                                   ->with('Total_Enroll_Course_Fee', $Total_Enroll_Course_Fee)
                                                                   ->with('Total_Paid_Amount', $Total_Paid_Amount);                                                       
                }
    }

    public function edit(Request $request){

        if(isset($request->id)){
        
        $student_id = $request->id;

        $student = User::where('id', $student_id)->first();
        $student_academic_info = User_Academic_Info::select('user_academic_type','user_class','user_institute_name')
                                                               ->where('user_id', $student_id)
                                                               ->first();

        return view('Backend.Payment.student_payment.edit')->with('student', $student)
                                                           ->with('student_academic_info', $student_academic_info);                                                       
        }
    }

}
