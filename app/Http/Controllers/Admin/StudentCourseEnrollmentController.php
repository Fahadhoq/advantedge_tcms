<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\User_Info;
use App\Models\User_Type;
use App\Models\User_Academic_Info;
use App\Models\Classes;
use App\Models\Course;
use App\Models\Student_Course_Enrollment;
use DB;
use Carbon\Carbon;

class StudentCourseEnrollmentController extends Controller
{
    public function index()
    {
        $data['StudentsEnrollmentCourses'] = Student_Course_Enrollment::get();
        
        return view('Backend.Admin.Student_Course_Enrollment.index' , $data);
    }

    public function enroll(){
        
        $today_date = Carbon::now()->format('Y-m-d');
       
        $offer_courses = Course::where('enrollment_last_date', '>=' , $today_date)->where('status' , 1)->get();
      //  dd($offer_courses);
        
        return view('Backend.Admin.Student_Course_Enrollment.enroll')->with('offer_courses', $offer_courses);
       // return view('Backend.Admin.Student_Enrollment.enroll' , $data);
    }

    public function student_search(Request $request){
        
        if(isset($request->SearchStudent))
        {   
            $SearchStudent = trim($request->SearchStudent);

            $data['User_Type'] = User_Type::select('id')->where('name','LIKE','student')
                                                  ->orWhere('name','LIKE','Student')
                                                  ->orWhere('name','LIKE','STUDENT')
                                                  ->first();

            $User_Infos = User_Info::select('user_id')->where('user_type_id', $data['User_Type']->id)->get();
            
            $array_user_infos = array();                                      
            foreach($User_Infos as $User_Info){  
                array_push($array_user_infos, $User_Info->user_id);
            }

            // $data['users'] = User::select('id','email')->where('is_verified' , 1)
            //                                             ->where('id','LIKE','%'.$SearchStudent.'%')
            //                                             ->orWhere('email','LIKE','%'.$SearchStudent.'%')
            //                                             ->get();

              $data['users_is_verified'] = User::select('id')->where('is_verified' , 1)->get();

              $data['users'] = User::select('id','email')
                                                        ->where('id','LIKE','%'.$SearchStudent.'%')
                                                        ->orWhere('email','LIKE','%'.$SearchStudent.'%')
                                                        ->get();
            
            $array_users = array();    
            foreach($data['users_is_verified'] as $user_is_verified){
                foreach($data['users'] as $users){
                    if($user_is_verified->id == $users->id){
                        array_push($array_users, $users); 
                    }
                }
            }
                                                     

            $output = '';
            $student_found = 0;
            foreach ($array_user_infos as $user_id) {
                foreach($array_users as $row){
                    if($user_id == $row->id){
                        $output .= '
                        <li class="list-group-item contsearch">
                            <a href="javascript:void(0)" class="gsearch" style="color:#333;text-decoration:none;">'.$row->email.'</a> 
                        </li>
                    ';
                      $student_found++;
                    }      
                }
           }

           if($student_found == 0){
            $output .= '
                <li class="list-group-item contsearch">
                <a href="javascript:void(0)" class="gsearch_non" style="color:#333;text-decoration:none;">No Student Found</a>
                </li>
           ';
          }
                
                    echo $output;
        }
           
                                                 
            
    }

    public function student_detials_show(Request $request){
        
        if(isset($request->SearchStudent)){
           
            $SearchStudent = trim($request->SearchStudent);

            $data['users'] = User::where('email', $SearchStudent)
                                  ->orWhere('id', $SearchStudent)
                                  ->get();
            
            // student info                      
            $output = '
            <div class="col-sm-12">
               <h5 style="text-align: center"  class="page-title">Student Info </h5>
            </div>

            <table class="table table-bordered table-striped">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email</th>
            </tr>
            ';

            foreach($data['users'] as $row_users)
            {
            $output .= '
            <tr> 
            <td id="student_id" align= "center">'.$row_users->id.'</td>
            <td align= "center"> <a href="#"> <img src="storage/'.@$row_users->profile_photo_path. '" width="100px" height="80px"></a> </td>
            <td align= "center">'.$row_users->name.'</td>
            <td align= "center">'.$row_users->phone.'</td>
            <td align= "center">'.$row_users->email.'</td>
         
            </tr>
            ';
              $data['User_Academic_Info'] = User_Academic_Info::select('user_academic_type','user_class','user_institute_name')
                                                               ->where('user_id', $row_users->id)
                                                               ->get();
              
            }
            $output .= '</table>';
            //student info end
      
            //student academic info
            
            $output .= '
            <div class="col-sm-12">
               <h5 style="text-align: center"  class="page-title">Student Academic Info </h5>
            </div>

            <table class="table table-bordered table-striped">
            <tr>
                <th>Academic Type</th>
                <th>Class</th>
                <th>Institute Name</th>
            </tr>
            ';
        
       

            foreach($data['User_Academic_Info'] as $User_Academic_Info)
            {
                //academic_type
                if($User_Academic_Info->user_academic_type == 1){
                    $academic_type = "School";
                }elseif($User_Academic_Info->user_academic_type == 2){
                    $academic_type = "Collage";
                }elseif($User_Academic_Info->user_academic_type == 3){
                    $academic_type = "University";
                }elseif($User_Academic_Info->user_academic_type == 4){
                    $academic_type = "Other";
                }
                //academic_type end

                //class
                $class = Classes::select('name')->where('id' , $User_Academic_Info->user_class)->first();
                //class end

            $output .= '
            <tr>
                <td align= "center">'.$academic_type.'</td>
                <td align= "center">'.$class->name .'</td>
                <td align= "center">'.$User_Academic_Info->user_institute_name.'</td>
            </tr>
            ';
            }
            $output .= '</table>';
        
            //student academic info end

            echo $output;
        }
    }

    public function check_sit_limit(Request $request){
            
        $Total_student_Course_Enrollment = Student_Course_Enrollment::where('course_id' , $request->course_id)->count();

        $Check_total_student_Course_Enrollment = $Total_student_Course_Enrollment + 1;

        $offer_courses = Course::select('student_limit')->where('id' , $request->course_id)->first();

        if( $Check_total_student_Course_Enrollment >  $offer_courses->student_limit ){
            return response()->json([ 'error' => 'Course Limit Full']);
         //  echo $Check_total_student_Course_Enrollment;
        }
     //   echo $offer_courses->student_limit;
        
    }

    public function check_student_is_enrolled(Request $request){
            
        $Student_is_enrolled = Student_Course_Enrollment::where('user_id' , $request->student_id)
                                                                    ->where('course_id' , $request->course_id)->first();

        if( $Student_is_enrolled != null ){
            return response()->json([ 'error' => 'Already Enrolled This Course']);
         //  echo $Check_total_student_Course_Enrollment;
        }
      //  echo $Student_is_enrolled;
        
    }

    public function check_student_courde_is_clash(Request $request){
            
        $student_enrolled_offer_courses = Student_Course_Enrollment::select('course_id')->where('user_id' , $request->student_id)->get();
        
        $select_offer_course = Course::select('day', 'start_time', 'end_time')->where('id' , $request->course_id)->first(); 

        $select_offer_course_start_time = $select_offer_course->start_time;
        $select_offer_course_end_time = $select_offer_course->end_time;

        // offer courses days,time exect check

        //offer courses day check 
        $select_offer_course_days_array = array();
        $select_offer_course_days = explode(',', $select_offer_course->day);
         
        foreach($select_offer_course_days as $select_offer_course_day){
             $select_offer_course_day = str_replace(' ' , '' , $select_offer_course_day);
             array_push($select_offer_course_days_array, $select_offer_course_day);        
        }
        
        foreach ($student_enrolled_offer_courses as $student_enrolled_offer_course) {
            
            $offer_course_days = Course::select('day')->where('id' , $student_enrolled_offer_course->course_id)->first(); 

            $offer_course_days_array = array();
            $offer_course_days = explode(',', $offer_course_days->day);
            
            foreach($offer_course_days as $offer_course_day){
                $offer_course_day = str_replace(' ' , '' , $offer_course_day);
                array_push($offer_course_days_array, $offer_course_day);        
            }
            
            foreach($offer_course_days_array as $offer_course_day){
                foreach($select_offer_course_days_array as $select_offer_course_day){
                    if($offer_course_day == $select_offer_course_day){
                        if($offer_course_day == 1){
                            $offer_courses_time_exect = Course::select('start_time', 'end_time')->where('id' , $student_enrolled_offer_course->course_id)
                                                                                         ->where('day' , 'LIKE','%1%')
                                                                                         ->get();

                             // time check
                             foreach($offer_courses_time_exect as $offer_course_time_exect){
                                 $offer_courses_start_time_exect = $offer_course_time_exect->start_time;
                                 $offer_courses_end_time_exect = $offer_course_time_exect->end_time;

                                if($select_offer_course_start_time == $offer_courses_start_time_exect){
                                    return response()->json([ 'error' => 'Time Clash']);
                                }elseif($select_offer_course_end_time == $offer_courses_end_time_exect){
                                    return response()->json([ 'error' => 'Time Clash']);
                                }elseif( ($select_offer_course_start_time > $offer_courses_start_time_exect) && ($offer_courses_end_time_exect > $select_offer_course_start_time) ){
                                    return response()->json([ 'error' => 'Time Clash']);
                                }elseif( ($select_offer_course_end_time > $offer_courses_start_time_exect) && ($select_offer_course_end_time < $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash']);
                                }elseif( ($select_offer_course_start_time < $offer_courses_start_time_exect) && ($select_offer_course_end_time > $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash']);
                                }
                        
                             }
                             // time check end 

                        }elseif ($offer_course_day == 2) {
                            $offer_courses_time_exect = Course::select('start_time', 'end_time')->where('id' , $student_enrolled_offer_course->course_id)
                                                                                         ->where('day' , 'LIKE','%2%')
                                                                                         ->get(); 
                           
                            // time check
                            foreach($offer_courses_time_exect as $offer_course_time_exect){
                                $offer_courses_start_time_exect = $offer_course_time_exect->start_time;
                                $offer_courses_end_time_exect = $offer_course_time_exect->end_time;

                               if($select_offer_course_start_time == $offer_courses_start_time_exect){
                                    return response()->json([ 'error' => 'Time Clash']); 
                               }elseif($select_offer_course_end_time == $offer_courses_end_time_exect){
                                    return response()->json([ 'error' => 'Time Clash']);
                               }elseif( ($select_offer_course_start_time > $offer_courses_start_time_exect) && ($offer_courses_end_time_exect > $select_offer_course_start_time) ){
                                    return response()->json([ 'error' => 'Time Clash']);
                               }elseif( ($select_offer_course_end_time > $offer_courses_start_time_exect) && ($select_offer_course_end_time < $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash']);
                               }elseif( ($select_offer_course_start_time < $offer_courses_start_time_exect) && ($select_offer_course_end_time > $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash']);
                               }
                       
                            }
                            // time check end 
                        }elseif ($offer_course_day == 3) {
                            $offer_courses_time_exect = Course::select('start_time', 'end_time')->where('id' , $student_enrolled_offer_course->course_id)
                                                                                         ->where('day' , 'LIKE','%3%')
                                                                                         ->get(); 
                         
                            // time check
                            foreach($offer_courses_time_exect as $offer_course_time_exect){
                                $offer_courses_start_time_exect = $offer_course_time_exect->start_time;
                                $offer_courses_end_time_exect = $offer_course_time_exect->end_time;

                               if($select_offer_course_start_time == $offer_courses_start_time_exect){
                                    return response()->json([ 'error' => 'Time Clash']);  
                               }elseif($select_offer_course_end_time == $offer_courses_end_time_exect){
                                   return response()->json([ 'error' => 'Time Clash']);
                               }elseif( ($select_offer_course_start_time > $offer_courses_start_time_exect) && ($offer_courses_end_time_exect > $select_offer_course_start_time) ){
                                    return response()->json([ 'error' => 'Time Clash']);
                               }elseif( ($select_offer_course_end_time > $offer_courses_start_time_exect) && ($select_offer_course_end_time < $offer_courses_end_time_exect) ){
                                   return response()->json([ 'error' => 'Time Clash']);
                               }elseif( ($select_offer_course_start_time < $offer_courses_start_time_exect) && ($select_offer_course_end_time > $offer_courses_end_time_exect) ){
                                   return response()->json([ 'error' => 'Time Clash']);
                               }
                       
                            }
                            // time check end 
                        }elseif ($offer_course_day == 4) {
                            $offer_courses_time_exect = Course::select('start_time', 'end_time')->where('id' , $student_enrolled_offer_course->course_id)
                                                                                         ->where('day' , 'LIKE','%4%')
                                                                                         ->get();
                        
                            // time check
                            foreach($offer_courses_time_exect as $offer_course_time_exect){
                                $offer_courses_start_time_exect = $offer_course_time_exect->start_time;
                                $offer_courses_end_time_exect = $offer_course_time_exect->end_time;

                               if($select_offer_course_start_time == $offer_courses_start_time_exect){
                                      return response()->json([ 'error' => 'Time Clash']);  
                               }elseif($select_offer_course_end_time == $offer_courses_end_time_exect){
                                      return response()->json([ 'error' => 'Time Clash']);
                               }elseif( ($select_offer_course_start_time > $offer_courses_start_time_exect) && ($offer_courses_end_time_exect > $select_offer_course_start_time) ){
                                      return response()->json([ 'error' => 'Time Clash']);
                               }elseif( ($select_offer_course_end_time > $offer_courses_start_time_exect) && ($select_offer_course_end_time < $offer_courses_end_time_exect) ){
                                      return response()->json([ 'error' => 'Time Clash']);
                               }elseif( ($select_offer_course_start_time < $offer_courses_start_time_exect) && ($select_offer_course_end_time > $offer_courses_end_time_exect) ){
                                      return response()->json([ 'error' => 'Time Clash']);
                               }
                       
                            }
                            // time check end 
                        }elseif ($offer_course_day == 5) {
                            $offer_courses_time_exect = Course::select('start_time', 'end_time')->where('id' , $student_enrolled_offer_course->course_id)
                                                                                         ->where('day' , 'LIKE','%5%')
                                                                                         ->get(); 
                            print_r("5");
                            // time check
                            foreach($offer_courses_time_exect as $offer_course_time_exect){
                                $offer_courses_start_time_exect = $offer_course_time_exect->start_time;
                                $offer_courses_end_time_exect = $offer_course_time_exect->end_time;

                               if($select_offer_course_start_time == $offer_courses_start_time_exect){
                                     return response()->json([ 'error' => 'Time Clash']); 
                               }elseif($select_offer_course_end_time == $offer_courses_end_time_exect){
                                     return response()->json([ 'error' => 'Time Clash']);
                               }elseif( ($select_offer_course_start_time > $offer_courses_start_time_exect) && ($offer_courses_end_time_exect > $select_offer_course_start_time) ){
                                     return response()->json([ 'error' => 'Time Clash']);
                               }elseif( ($select_offer_course_end_time > $offer_courses_start_time_exect) && ($select_offer_course_end_time < $offer_courses_end_time_exect) ){
                                     return response()->json([ 'error' => 'Time Clash']);
                               }elseif( ($select_offer_course_start_time < $offer_courses_start_time_exect) && ($select_offer_course_end_time > $offer_courses_end_time_exect) ){
                                     return response()->json([ 'error' => 'Time Clash']);
                               }
                       
                            }
                            // time check end 
                        }elseif ($offer_course_day == 6) {
                            $offer_courses_time_exect = Course::select('start_time', 'end_time')->where('id' , $student_enrolled_offer_course->course_id)
                                                                                         ->where('day' , 'LIKE','%6%')
                                                                                         ->get();
                           
                            // time check
                            foreach($offer_courses_time_exect as $offer_course_time_exect){
                                $offer_courses_start_time_exect = $offer_course_time_exect->start_time;
                                $offer_courses_end_time_exect = $offer_course_time_exect->end_time;

                               if($select_offer_course_start_time == $offer_courses_start_time_exect){
                                    return response()->json([ 'error' => 'Time Clash']); 
                               }elseif($select_offer_course_end_time == $offer_courses_end_time_exect){
                                    return response()->json([ 'error' => 'Time Clash']);
                               }elseif( ($select_offer_course_start_time > $offer_courses_start_time_exect) && ($offer_courses_end_time_exect > $select_offer_course_start_time) ){
                                    return response()->json([ 'error' => 'Time Clash']);
                               }elseif( ($select_offer_course_end_time > $offer_courses_start_time_exect) && ($select_offer_course_end_time < $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash']);
                               }elseif( ($select_offer_course_start_time < $offer_courses_start_time_exect) && ($select_offer_course_end_time > $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash']);
                               }
                       
                            }
                            // time check end 
                        }elseif ($offer_course_day == 7) {
                            $offer_courses_time_exect = Course::select('start_time', 'end_time')->where('id' , $student_enrolled_offer_course->course_id)
                                                                                         ->where('day' , 'LIKE','%7%')
                                                                                         ->get(); 
                           
                            // time check
                            foreach($offer_courses_time_exect as $offer_course_time_exect){
                                $offer_courses_start_time_exect = $offer_course_time_exect->start_time;
                                $offer_courses_end_time_exect = $offer_course_time_exect->end_time;

                               if($select_offer_course_start_time == $offer_courses_start_time_exect){
                                    return response()->json([ 'error' => 'Time Clash']);
                               }elseif($select_offer_course_end_time == $offer_courses_end_time_exect){
                                    return response()->json([ 'error' => 'Time Clash']);
                               }elseif( ($select_offer_course_start_time > $offer_courses_start_time_exect) && ($offer_courses_end_time_exect > $select_offer_course_start_time) ){
                                    return response()->json([ 'error' => 'Time Clash']);
                               }elseif( ($select_offer_course_end_time > $offer_courses_start_time_exect) && ($select_offer_course_end_time < $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash']);
                               }elseif( ($select_offer_course_start_time < $offer_courses_start_time_exect) && ($select_offer_course_end_time > $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash']);
                               }
                       
                            }
                            // time check end 
                        }
                    }
                }
            }
        }

      //  echo $output;
      // dd();
        
        //offer courses day check end
    
    // offer courses days,time exect check end
        
        
    }
    

    public function enroll_store(Request $request){

        if(isset($request->student_id)){
            if(count($request->select_course_ids) != 0){
                $select_course_ids = $request->select_course_ids;
                $student_id = $request->student_id;
    
                foreach ($select_course_ids as  $select_course_id){
                    //Student Course Enrollment table insert
                    $Student_Course_Enrollment = new Student_Course_Enrollment;
                    $Student_Course_Enrollment->course_id = $select_course_id;
                    $Student_Course_Enrollment->user_id = $student_id;
                    $Student_Course_Enrollment->save();
                }
              echo  $this->SetMessage('Coures Inserted Successfull' , 'success');
              return response()->json([ 'success' => 'course inserted']);
              
            }else{
                return response()->json([ 'error' => 'Select At Lest One Course']);
            }    
        }else{
            return response()->json([ 'error' => 'Select One Student']);
        }
    }

    public function status_change(Request $request){
        try{

           $id = $request->enrolled_course_id;
  
            $enrolled_course = Student_Course_Enrollment::find($id);

            if($request->value == "Active"){
                $enrolled_course->status = 0;
            }elseif($request->value == "InActive"){
                $enrolled_course->status = 1;
            }
            
            $enrolled_course->save();
         
            return response()->json([ 'success' => 'Enrolled Course Status Change Successfull']);
            
        
        } catch (Exception $e){
            return response()->json([ 'error' => 'something wrong.... Enrolled course is not verifyed']);
         }

     }

     public function drop_course(Request $request, $id){
                  
        $Student_Course_Enrollment = Student_Course_Enrollment::find($id);

        $Student_Course_Enrollment->delete();

        return response()->json([ 'success' => 'Course drop Successfull']);

     }

}

