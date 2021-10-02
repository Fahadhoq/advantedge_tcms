<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\User_Info;
use App\Models\User_Type;
use App\Models\Classes;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Teacher_Course_Enrollment;
use DB;
use Carbon\Carbon;

class TeacherCourseEnrollmentController extends Controller
{
    public function index()
    {
        $data['TeachersEnrollmentCourses'] = Teacher_Course_Enrollment::get();
        
        return view('Backend.Admin.Teacher_Course_Enrollment.index' , $data);
    }

    public function enroll(){
        
        $TeachersEnrollmentCourses = Teacher_Course_Enrollment::select('course_id')->get();
        $offer_courses = Course::get();

        $Teachers_Enrollment_Courses_array = array();
        foreach ($TeachersEnrollmentCourses as $TeachersEnrollmentCourse) {
            array_push($Teachers_Enrollment_Courses_array , $TeachersEnrollmentCourse->course_id);
        } 

        $offer_courses_array = array();
        foreach ($offer_courses as $offer_course){
            if(!in_array($offer_course->id, $Teachers_Enrollment_Courses_array)){
                array_push($offer_courses_array , $offer_course);
            }
        }
        
        return view('Backend.Admin.Teacher_Course_Enrollment.enroll')->with('offer_courses', $offer_courses_array);
       // return view('Backend.Admin.Student_Enrollment.enroll' , $data);
    }

    public function teacher_search(Request $request){
        
        if(isset($request->SearchTeacher))
        {   
            $SearchTeacher = trim($request->SearchTeacher);

            $data['User_Type'] = User_Type::select('id')->where('name','LIKE','teacher')
                                                  ->orWhere('name','LIKE','Teacher')
                                                  ->orWhere('name','LIKE','TEACHER')
                                                  ->first();

            $User_Infos = User_Info::select('user_id')->where('user_type_id', $data['User_Type']->id)->get();
            
            $array_user_infos = array();                                      
            foreach($User_Infos as $User_Info){  
                array_push($array_user_infos, $User_Info->user_id);
            }

              $data['users_is_verified'] = User::select('id')->where('is_verified' , 1)->get();

              $data['users'] = User::select('id','email')
                                                        ->where('id','LIKE','%'.$SearchTeacher.'%')
                                                        ->orWhere('email','LIKE','%'.$SearchTeacher.'%')
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
            $teacher_found = 0;
            foreach ($array_user_infos as $user_id) {
                foreach($array_users as $row){
                    if($user_id == $row->id){
                        $output .= '
                        <li class="list-group-item contsearch">
                            <a href="javascript:void(0)" class="gsearch" style="color:#333;text-decoration:none;">'.$row->email.'</a> 
                        </li>
                    ';
                      $teacher_found++;
                    }      
                }
           }

           if($teacher_found == 0){
            $output .= '
                <li class="list-group-item contsearch">
                <a href="javascript:void(0)" class="gsearch_non" style="color:#333;text-decoration:none;">No Teacher Found</a>
                </li>
           ';
          }
                
                    echo $output;
        }
                                                    
    }

    public function teacher_detials_show(Request $request){
        
        if(isset($request->SearchTeacher)){
           
            $SearchTeacher = trim($request->SearchTeacher);

            $data['users'] = User::where('email', $SearchTeacher)
                                  ->orWhere('id', $SearchTeacher)
                                  ->first();
            
            // Teacher info                      
            $output = '
            <div class="col-sm-12">
               <h5 style="text-align: center"  class="page-title">Teacher Info </h5>
            </div>

            <table class="table table-bordered">
            
            ';

            
            $output .= '
            <tr>
                <th class="teacher_info_table_th">ID</th> 
                <td id="teacher_id" align= "center">'.$data['users']->id.'</td>
            </tr>
           
            <tr>
               <th class="teacher_info_table_th">Image</th>
               <td align= "center"> <a href="#"> <img src="storage/'.@$data['users']->profile_photo_path. '" width="100px" height="80px"></a> </td>
            </tr>
            
            <tr>
              <th class="teacher_info_table_th">Name</th>
              <td align= "center">'.$data['users']->name.'</td>
            </tr>
            
            <tr>
               <th class="teacher_info_table_th">Phone Number</th>
               <td align= "center">'.$data['users']->phone.'</td>
            </tr>

            <tr>
                <th class="teacher_info_table_th">Email</th>
                <td align= "center">'.$data['users']->email.'</td>
            </tr>
            ';
            
            $output .= '</table>';
            //Teacher info end
      
            echo $output;
        }
    }

    //frontend day,time clash check
    public function check_selected_courses_is_clash(Request $request){ 
        $sizeof_select_course_ids = $request->frontend_select_course_checkbox_value;
        $select_course_ids = $request->frontend_select_course_checkbox_value;
       
        for($i = 0 ; $i < sizeof($sizeof_select_course_ids) ; $i++ ){

            //1st index
            $select_first_course_id = $select_course_ids[0]; 
            $select_first_offer_course = Course::select('day', 'start_time', 'end_time')->where('id' , $select_first_course_id)->first();
            $select_first_offer_course_start_time = $select_first_offer_course->start_time;
            $select_first_offer_course_end_time = $select_first_offer_course->end_time;
            
           // offer courses day check 
            $select_first_course_days_array = array();
            $select_first_course_days = explode(',', $select_first_offer_course->day);
            
            foreach($select_first_course_days as $select_first_course_day){
                $select_first_course_day = str_replace(' ' , '' , $select_first_course_day);
                array_push($select_first_course_days_array, $select_first_course_day);        
            }
            //1st index end

            //rest of index
            array_splice($select_course_ids, 0, 1);

            foreach ($select_course_ids as $select_course_id) {
                $select_offer_course = Course::select('id' , 'day')->where('id' , $select_course_id)->first();
               
                $select_offer_course_days_array = array();
                $select_offer_course_days = explode(',', $select_offer_course->day);
                
                foreach($select_offer_course_days as $select_offer_course_day){
                    $select_offer_course_day = str_replace(' ' , '' , $select_offer_course_day);
                    array_push($select_offer_course_days_array, $select_offer_course_day);        
                }
               
                foreach($select_first_course_days_array as $select_first_course_day_array){
                    foreach($select_offer_course_days_array as $select_offer_course_day){

                        if($select_first_course_day_array == $select_offer_course_day){
                                if($select_first_course_day_array == 1){
                                    $select_offer_courses_time = Course::select('start_time', 'end_time')->where('id' , $select_offer_course->id)
                                                                                         ->where('day' , 'LIKE','%1%')
                                                                                         ->get();

                                    // time check
                                    foreach($select_offer_courses_time as $select_offer_course_time){
                                        $select_offer_course_start_time = $select_offer_course_time->start_time;
                                        $select_offer_course_end_time = $select_offer_course_time->end_time;

                                        if($select_first_offer_course_start_time == $select_offer_course_start_time){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif($select_first_offer_course_end_time == $select_offer_course_end_time){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_start_time > $select_offer_course_start_time) && ($select_offer_course_end_time > $select_first_offer_course_start_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_end_time > $select_offer_course_start_time) && ($select_first_offer_course_end_time < $select_offer_course_end_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_start_time < $select_offer_course_start_time) && ($select_first_offer_course_end_time > $select_offer_course_end_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }
                                
                                    }
                                    // time check end 
                                }elseif ($select_first_course_day_array == 2) {
                                    $select_offer_courses_time = Course::select('start_time', 'end_time')->where('id' , $select_offer_course->id)
                                                                                         ->where('day' , 'LIKE','%2%')
                                                                                         ->get();

                                    // time check
                                    foreach($select_offer_courses_time as $select_offer_course_time){
                                        $select_offer_course_start_time = $select_offer_course_time->start_time;
                                        $select_offer_course_end_time = $select_offer_course_time->end_time;

                                        if($select_first_offer_course_start_time == $select_offer_course_start_time){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif($select_first_offer_course_end_time == $select_offer_course_end_time){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_start_time > $select_offer_course_start_time) && ($select_offer_course_end_time > $select_first_offer_course_start_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_end_time > $select_offer_course_start_time) && ($select_first_offer_course_end_time < $select_offer_course_end_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_start_time < $select_offer_course_start_time) && ($select_first_offer_course_end_time > $select_offer_course_end_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }
                                
                                    }
                                    // time check end 
                                }elseif ($select_first_course_day_array == 3) {
                                    $select_offer_courses_time = Course::select('start_time', 'end_time')->where('id' , $select_offer_course->id)
                                                                                         ->where('day' , 'LIKE','%3%')
                                                                                         ->get();

                                    // time check
                                    foreach($select_offer_courses_time as $select_offer_course_time){
                                        $select_offer_course_start_time = $select_offer_course_time->start_time;
                                        $select_offer_course_end_time = $select_offer_course_time->end_time;

                                        if($select_first_offer_course_start_time == $select_offer_course_start_time){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif($select_first_offer_course_end_time == $select_offer_course_end_time){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_start_time > $select_offer_course_start_time) && ($select_offer_course_end_time > $select_first_offer_course_start_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_end_time > $select_offer_course_start_time) && ($select_first_offer_course_end_time < $select_offer_course_end_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_start_time < $select_offer_course_start_time) && ($select_first_offer_course_end_time > $select_offer_course_end_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }
                                
                                    }
                                    // time check end 
                                }elseif ($select_first_course_day_array == 4) {
                                    $select_offer_courses_time = Course::select('start_time', 'end_time')->where('id' , $select_offer_course->id)
                                                                                         ->where('day' , 'LIKE','%4%')
                                                                                         ->get();

                                    // time check
                                    foreach($select_offer_courses_time as $select_offer_course_time){
                                        $select_offer_course_start_time = $select_offer_course_time->start_time;
                                        $select_offer_course_end_time = $select_offer_course_time->end_time;

                                        if($select_first_offer_course_start_time == $select_offer_course_start_time){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif($select_first_offer_course_end_time == $select_offer_course_end_time){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_start_time > $select_offer_course_start_time) && ($select_offer_course_end_time > $select_first_offer_course_start_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_end_time > $select_offer_course_start_time) && ($select_first_offer_course_end_time < $select_offer_course_end_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_start_time < $select_offer_course_start_time) && ($select_first_offer_course_end_time > $select_offer_course_end_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }
                                
                                    }
                                    // time check end 
                                }elseif ($select_first_course_day_array == 5) {
                                    $select_offer_courses_time = Course::select('start_time', 'end_time')->where('id' , $select_offer_course->id)
                                                                                         ->where('day' , 'LIKE','%5%')
                                                                                         ->get();

                                    // time check
                                    foreach($select_offer_courses_time as $select_offer_course_time){
                                        $select_offer_course_start_time = $select_offer_course_time->start_time;
                                        $select_offer_course_end_time = $select_offer_course_time->end_time;

                                        if($select_first_offer_course_start_time == $select_offer_course_start_time){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif($select_first_offer_course_end_time == $select_offer_course_end_time){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_start_time > $select_offer_course_start_time) && ($select_offer_course_end_time > $select_first_offer_course_start_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_end_time > $select_offer_course_start_time) && ($select_first_offer_course_end_time < $select_offer_course_end_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_start_time < $select_offer_course_start_time) && ($select_first_offer_course_end_time > $select_offer_course_end_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }
                                
                                    }
                                    // time check end 
                                }elseif ($select_first_course_day_array == 6) {
                                    $select_offer_courses_time = Course::select('start_time', 'end_time')->where('id' , $select_offer_course->id)
                                                                                         ->where('day' , 'LIKE','%6%')
                                                                                         ->get();

                                    // time check
                                    foreach($select_offer_courses_time as $select_offer_course_time){
                                        $select_offer_course_start_time = $select_offer_course_time->start_time;
                                        $select_offer_course_end_time = $select_offer_course_time->end_time;

                                        if($select_first_offer_course_start_time == $select_offer_course_start_time){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif($select_first_offer_course_end_time == $select_offer_course_end_time){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_start_time > $select_offer_course_start_time) && ($select_offer_course_end_time > $select_first_offer_course_start_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_end_time > $select_offer_course_start_time) && ($select_first_offer_course_end_time < $select_offer_course_end_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_start_time < $select_offer_course_start_time) && ($select_first_offer_course_end_time > $select_offer_course_end_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }
                                
                                    }
                                    // time check end 
                                }elseif ($select_first_course_day_array == 7) {
                                   $select_offer_courses_time = Course::select('start_time', 'end_time')->where('id' , $select_offer_course->id)
                                                                                         ->where('day' , 'LIKE','%7%')
                                                                                         ->get();

                                    // time check
                                    foreach($select_offer_courses_time as $select_offer_course_time){
                                        $select_offer_course_start_time = $select_offer_course_time->start_time;
                                        $select_offer_course_end_time = $select_offer_course_time->end_time;

                                        if($select_first_offer_course_start_time == $select_offer_course_start_time){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif($select_first_offer_course_end_time == $select_offer_course_end_time){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_start_time > $select_offer_course_start_time) && ($select_offer_course_end_time > $select_first_offer_course_start_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_end_time > $select_offer_course_start_time) && ($select_first_offer_course_end_time < $select_offer_course_end_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }elseif( ($select_first_offer_course_start_time < $select_offer_course_start_time) && ($select_first_offer_course_end_time > $select_offer_course_end_time) ){
                                            return response()->json([ 'error' => 'Time Clash with selected courses']);
                                        }
                                
                                    }
                                    // time check end 
                                }
                                
                        }

                    }
                }
            }
            //rest of index

           //offer courses day check end
        }
        
    }
    //frontend day,time clash check end

     //backend day,time clash check
     public function check_teacher_courde_is_clash(Request $request){
            
        $teacher_enrolled_offer_courses = Teacher_Course_Enrollment::select('course_id')->where('user_id' , $request->teacher_id)->get();
        
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
        
        foreach ($teacher_enrolled_offer_courses as $teacher_enrolled_offer_course) {
            
            $offer_course_days = Course::select('day')->where('id' , $teacher_enrolled_offer_course->course_id)->first(); 

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
                            $offer_courses_time_exect = Course::select('start_time', 'end_time')->where('id' , $teacher_enrolled_offer_course->course_id)
                                                                                         ->where('day' , 'LIKE','%1%')
                                                                                         ->get();

                             // time check
                             foreach($offer_courses_time_exect as $offer_course_time_exect){
                                 $offer_courses_start_time_exect = $offer_course_time_exect->start_time;
                                 $offer_courses_end_time_exect = $offer_course_time_exect->end_time;

                                if($select_offer_course_start_time == $offer_courses_start_time_exect){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif($select_offer_course_end_time == $offer_courses_end_time_exect){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_start_time > $offer_courses_start_time_exect) && ($offer_courses_end_time_exect > $select_offer_course_start_time) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_end_time > $offer_courses_start_time_exect) && ($select_offer_course_end_time < $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_start_time < $offer_courses_start_time_exect) && ($select_offer_course_end_time > $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }
                        
                             }
                             // time check end 

                        }elseif ($offer_course_day == 2) {
                            $offer_courses_time_exect = Course::select('start_time', 'end_time')->where('id' , $teacher_enrolled_offer_course->course_id)
                                                                                         ->where('day' , 'LIKE','%2%')
                                                                                         ->get(); 
                           
                            // time check
                            foreach($offer_courses_time_exect as $offer_course_time_exect){
                                $offer_courses_start_time_exect = $offer_course_time_exect->start_time;
                                $offer_courses_end_time_exect = $offer_course_time_exect->end_time;

                                if($select_offer_course_start_time == $offer_courses_start_time_exect){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif($select_offer_course_end_time == $offer_courses_end_time_exect){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_start_time > $offer_courses_start_time_exect) && ($offer_courses_end_time_exect > $select_offer_course_start_time) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_end_time > $offer_courses_start_time_exect) && ($select_offer_course_end_time < $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_start_time < $offer_courses_start_time_exect) && ($select_offer_course_end_time > $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }
                       
                            }
                            // time check end 
                        }elseif ($offer_course_day == 3) {
                            $offer_courses_time_exect = Course::select('start_time', 'end_time')->where('id' , $teacher_enrolled_offer_course->course_id)
                                                                                         ->where('day' , 'LIKE','%3%')
                                                                                         ->get(); 
                         
                            // time check
                            foreach($offer_courses_time_exect as $offer_course_time_exect){
                                $offer_courses_start_time_exect = $offer_course_time_exect->start_time;
                                $offer_courses_end_time_exect = $offer_course_time_exect->end_time;

                                if($select_offer_course_start_time == $offer_courses_start_time_exect){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif($select_offer_course_end_time == $offer_courses_end_time_exect){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_start_time > $offer_courses_start_time_exect) && ($offer_courses_end_time_exect > $select_offer_course_start_time) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_end_time > $offer_courses_start_time_exect) && ($select_offer_course_end_time < $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_start_time < $offer_courses_start_time_exect) && ($select_offer_course_end_time > $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }
                       
                            }
                            // time check end 
                        }elseif ($offer_course_day == 4) {
                            $offer_courses_time_exect = Course::select('start_time', 'end_time')->where('id' , $teacher_enrolled_offer_course->course_id)
                                                                                         ->where('day' , 'LIKE','%4%')
                                                                                         ->get();
                        
                            // time check
                            foreach($offer_courses_time_exect as $offer_course_time_exect){
                                $offer_courses_start_time_exect = $offer_course_time_exect->start_time;
                                $offer_courses_end_time_exect = $offer_course_time_exect->end_time;

                                if($select_offer_course_start_time == $offer_courses_start_time_exect){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif($select_offer_course_end_time == $offer_courses_end_time_exect){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_start_time > $offer_courses_start_time_exect) && ($offer_courses_end_time_exect > $select_offer_course_start_time) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_end_time > $offer_courses_start_time_exect) && ($select_offer_course_end_time < $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_start_time < $offer_courses_start_time_exect) && ($select_offer_course_end_time > $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }
                       
                            }
                            // time check end 
                        }elseif ($offer_course_day == 5) {
                            $offer_courses_time_exect = Course::select('start_time', 'end_time')->where('id' , $teacher_enrolled_offer_course->course_id)
                                                                                         ->where('day' , 'LIKE','%5%')
                                                                                         ->get(); 
                            print_r("5");
                            // time check
                            foreach($offer_courses_time_exect as $offer_course_time_exect){
                                $offer_courses_start_time_exect = $offer_course_time_exect->start_time;
                                $offer_courses_end_time_exect = $offer_course_time_exect->end_time;

                                if($select_offer_course_start_time == $offer_courses_start_time_exect){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif($select_offer_course_end_time == $offer_courses_end_time_exect){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_start_time > $offer_courses_start_time_exect) && ($offer_courses_end_time_exect > $select_offer_course_start_time) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_end_time > $offer_courses_start_time_exect) && ($select_offer_course_end_time < $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_start_time < $offer_courses_start_time_exect) && ($select_offer_course_end_time > $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }
                       
                            }
                            // time check end 
                        }elseif ($offer_course_day == 6) {
                            $offer_courses_time_exect = Course::select('start_time', 'end_time')->where('id' , $teacher_enrolled_offer_course->course_id)
                                                                                         ->where('day' , 'LIKE','%6%')
                                                                                         ->get();
                           
                            // time check
                            foreach($offer_courses_time_exect as $offer_course_time_exect){
                                $offer_courses_start_time_exect = $offer_course_time_exect->start_time;
                                $offer_courses_end_time_exect = $offer_course_time_exect->end_time;

                                if($select_offer_course_start_time == $offer_courses_start_time_exect){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif($select_offer_course_end_time == $offer_courses_end_time_exect){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_start_time > $offer_courses_start_time_exect) && ($offer_courses_end_time_exect > $select_offer_course_start_time) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_end_time > $offer_courses_start_time_exect) && ($select_offer_course_end_time < $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_start_time < $offer_courses_start_time_exect) && ($select_offer_course_end_time > $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }
                       
                            }
                            // time check end 
                        }elseif ($offer_course_day == 7) {
                            $offer_courses_time_exect = Course::select('start_time', 'end_time')->where('id' , $teacher_enrolled_offer_course->course_id)
                                                                                         ->where('day' , 'LIKE','%7%')
                                                                                         ->get(); 
                           
                            // time check
                            foreach($offer_courses_time_exect as $offer_course_time_exect){
                                $offer_courses_start_time_exect = $offer_course_time_exect->start_time;
                                $offer_courses_end_time_exect = $offer_course_time_exect->end_time;

                                if($select_offer_course_start_time == $offer_courses_start_time_exect){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif($select_offer_course_end_time == $offer_courses_end_time_exect){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_start_time > $offer_courses_start_time_exect) && ($offer_courses_end_time_exect > $select_offer_course_start_time) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_end_time > $offer_courses_start_time_exect) && ($select_offer_course_end_time < $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
                                }elseif( ($select_offer_course_start_time < $offer_courses_start_time_exect) && ($select_offer_course_end_time > $offer_courses_end_time_exect) ){
                                    return response()->json([ 'error' => 'Time Clash with enrolled courses']);
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
    //backend day,time clash check end


    public function enroll_store(Request $request){
        
        if(isset($request->teacher_id)){ 
            if(count($request->select_course_ids) != 0){ 
                $select_course_ids = $request->select_course_ids;
                $teacher_id = $request->teacher_id;
    
                foreach ($select_course_ids as  $select_course_id){
                    //teacher Course Enrollment table insert
                    $Teacher_Course_Enrollment = new Teacher_Course_Enrollment;
                    $Teacher_Course_Enrollment->course_id = $select_course_id;
                    $Teacher_Course_Enrollment->user_id = $teacher_id;
                    $Teacher_Course_Enrollment->save();
                    
                }
              echo  $this->SetMessage('Teacher Coures Enrolled Successfull' , 'success');
              return response()->json([ 'success' => 'Teacher courses Enrolled']);
              
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
  
            $enrolled_course = Teacher_Course_Enrollment::find($id);

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

     public function drop_course(Request $request){
                   
        if($request->action == "user_wise_course_drop"){
            $teacher_enrolled_course = Teacher_Course_Enrollment::where('user_id' , $request->teacher_id)
                                                                ->where('course_id' , $request->course_id)
                                                                ->first();
                                                                

            if($teacher_enrolled_course != null){
                $teacher_enrolled_course->delete();
                return response()->json(
                    [ 
                       'success' => 'Course drop Successfull',
                       'course_id' => $request->course_id,
                    ]
                );
            }else{
                return response()->json(
                    [ 
                       'success' => 'Course unselected Successfull',
                       'course_id' => $request->course_id,
                    ]
                );

            }

        }elseif($request->action == "individual_course_drop"){
            $teacher_enrolled_course = Teacher_Course_Enrollment::find($request->enrolled_course_id); 
            $teacher_enrolled_course->delete();
            
            return response()->json(
                [ 
                   'success' => 'Course drop Successfull',
                   'course_id' => $request->course_id,
                ]
            );
        }

     }

     public function course_index_filter(Request $request){

        $output = '';
        $i = 1;
                  
       if($request->filter_type == 2){

          $Teacher_Enroll_Courses = Teacher_Course_Enrollment::select('user_id')->groupBy('user_id')->get();

           
           foreach($Teacher_Enroll_Courses as $Teacher_Enroll_Course){
            $Teacher_total_Enroll_Courses = Teacher_Course_Enrollment::select('course_id')->where('user_id' , $Teacher_Enroll_Course->user_id)->count();
                    
                    $output .= '<tr>
                                        <td style=text-align:center scope="row">' .$i++. '</td> 
                                        
                                        <!-- teacher info -->
                                        <td style=text-align:center scope="row">' .$Teacher_Enroll_Course->user->id. '</td>
                                        <td style=text-align:center scope="row">' .$Teacher_Enroll_Course->user->name. '</td>
                                        <!-- teacher info end -->

                                        <td style=text-align:center scope="row">' .$Teacher_total_Enroll_Courses. '</td>

                                        <td style=text-align:center>
                                            <!-- <a href="" class="btn btn-info btn-sm" title="View course"><i class="fa fa-eye"></i></a> -->
                                            <!-- jquery view -->
                                            <a  name="view" value="view" id="'.$Teacher_Enroll_Course->user->id.'" class="btn btn-info btn-sm view_enrolled_course" title="View enrolled course"><i class="fa fa-eye"></i></a>
                                            <!-- jquery view end-->

                                            <a href="/teacher-enrolled-course-edit-'.$Teacher_Enroll_Course->user->id.'" class="btn btn-warning btn-sm" title="Edit enrolled course"><i class="fa fa-edit"></i></a>
                                        </td>
                                
                                    </tr>';         
           }

       }

       echo $output;

     }

     public function enrolled_course_edit($teacher_id){

        $data['teacher'] = User::where('id', $teacher_id)->first();

        $data['offer_courses'] = Course::get();
        $data['teacher_enrolled_courses'] = Teacher_Course_Enrollment::select('course_id')->where('user_id' , $teacher_id)->get();
      
        return view('Backend.Admin.Teacher_Course_Enrollment.edit_enrolled_course' , $data);
       
     }

     public function enroll_course_update(Request $request){

        if(isset($request->teacher_id)){
            if(count($request->select_course_ids) != 0){  

                $select_course_ids = $request->select_course_ids;
                $teacher_id = $request->teacher_id;
    
                foreach ($select_course_ids as  $select_course_id){
                    $Student_enrolled_courses = Teacher_Course_Enrollment::where('user_id' , $teacher_id)
                                                                          ->where('course_id' , $select_course_id)
                                                                          ->get();
                    if($Student_enrolled_courses->count() == 0){
                        //Teacher Course Enrollment table update
                        $Teacher_Course_Enrollment = new Teacher_Course_Enrollment;
                        $Teacher_Course_Enrollment->course_id = $select_course_id;
                        $Teacher_Course_Enrollment->user_id = $teacher_id;
                        $Teacher_Course_Enrollment->save();
                    }                                                      
                    
                }
                    echo  $this->SetMessage('Coures Updated Successfull' , 'success');
                    return response()->json([ 'success' => 'course Updated']);
              
            }else{
                $data['teacher_enrolled_courses'] = Teacher_Course_Enrollment::get();
                return view('Backend.Admin.Teacher_Course_Enrollment.index' , $data);
            }    
        }else{
            return response()->json([ 'error' => 'Select One Student']);
        }
    }

}
