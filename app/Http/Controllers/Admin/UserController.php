<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\User;
use App\Models\ModelHasRole;
use DB;
use App\Models\User_Info;
use App\Models\User_Type;
use App\Models\Classes;
use App\Models\User_Academic_Info;

use Illuminate\Support\Str;
use Storage;

class UserController extends Controller
{
    public function index()
    {
        $data['users'] = User::get();
             
        $data['User_Infos'] = User_Info::select('user_id' , 'verified_by')->get();

        $data['de_users'] = User::onlyTrashed()->get();
        //dd(storage_path());

        return view('Backend.User.index' , $data);
    }

    public function create(Type $var = null)
    {
        $data['user_types'] = User_Type::select('id' , 'name')->get();
                             
        return view('Backend.User.Create' , $data);
    }

    public function store(Request $request )
    {  
        
        //for backendend validation
          $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255' , 'unique:users,email'],
            'password' => 'required|confirmed|min:8',
            'phone' => 'required|regex:/(01)[0-9]{9}/|min:11|max:11|unique:users,phone',
            'UserType' => 'required',
      ]);

    if($validator->fails()){
        return redirect()->back()->WithErrors($validator)->WithInput();
     }

        
    try{
        
        //user table insert
        $user = new User;
        $user->name = $request->name;
        $user->email = strtolower($request->email);
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->is_verified = 0;
        $user->save();

        //user info table insert
        $user_info = new User_Info;
        $user_info->user_id = $user->id;
        $user_info->user_type_id = $request->UserType;
        $user_info->save();

        
        //user role
        $user_role = User_Type::select('assing_role_id')->where('id', $request->UserType)->first();
        //user model_has_roles table insert
        $user->assignRole($user_role->assing_role_id);
        


        $this->SetMessage('User Create Successfull' , 'success');
        

        return  redirect('/user');

       } catch (Exception $e){

          $this->SetMessage($e->getMessage() , 'danger');

           return redirect()->back();
       }
        
    }

    public function show(Request $request){
     
        $id = $request->id;
        
        $data['user'] = User::where('id', $id)->first();
       
        //delete user info
        if($data['user'] == null){
            $data['user_is_deleted'] = User::where('id', $id)->onlyTrashed()->first();
            $data['is_deleted'] = 1;
            
        }
        
        $data['role'] = ModelHasRole::select('role_id')->where('model_id' , $id)->first();
        $data['role'] = Role::select('name')->where('id' , $data['role']->role_id)->first();

        $data['User_Info'] = User_Info::where('user_id' , $data['user']->id )->first();

        $data['user_type'] = User_Type::where('id' , $data['User_Info']->user_type_id )->first();

        if($data['User_Info'] != null){
            $data['verified_by'] = User::select('name')->where('id' , $data['User_Info']->verified_by)->first(); 
        }                                                             
    
        return view('Backend.User.profile' , $data );
    }

    public function view(Request $request){
     
        $id = $request->id;
        $output = '';
        
        if(isset($id))
        {
            $user = User::where('id', $id)->first();
                $output .= '
                     <p>
                        <img src="storage/'.$user->profile_photo_path.'" class="img-responsive img-thumbnail" />
                     </p>
                     <p><label>Name : </label> '.$user->name.'</p>
                     <p><label>Phone : </label> '.$user->phone.'</p>
                     <p><label>Email : </label> '.$user->email.'</p>
                  ';

           echo $output;      
        }

         //dd($output);
    
    }

    public function edit(Request $request){

        $id = $request->id;
        $data['user'] = User::where('id', $id)->first();

        $data['user_types'] = User_Type::select('id' , 'name')->get();

        $data['roles'] = Role::select('id' , 'name')->get();                          

        $data['hasRole'] = ModelHasRole::select('role_id')->where('model_id' , $id)->first();

        $data['User_Info'] = User_Info::where('user_id' , $id)->first(); 

        $data['UserTypes'] =  User_Type::select('name')->where('id' , $data['User_Info']->user_type_id )->get();


        $data['Classes'] = Classes::get(); 

        $data['User_Academic_Info'] = User_Academic_Info::where('user_id' , $id)->first();
                                     
        return view('Backend.User.edit' , $data);
    }

    public function update(Request $request){
    
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255' , 'unique:users,email,'.$request->id],
            'phone' => 'required|regex:/(01)[0-9]{9}/|min:11|max:11|unique:users,phone,'.$request->id,
            'UserRole' => 'required',
            'UserType' => 'required',
      ]);

      //image validation and storage 
      if(($request->file('image') != null) || ($request->old_pic != null) ){

        if( $request->file('image') ) {
            $validator_img = Validator::make($request->all(), [
                'image' => 'required|image|max:10240',
            ]);
            
        }elseif($request->old_pic){
            $validator_img = Validator::make($request->all(), [
                'old_pic' => 'required|unique:users,profile_photo_path,'.$request->id,
            ]);
        }

        if($validator->fails() || $validator_img->fails()){
            return redirect()->back()->WithErrors($validator)->WithInput();
        }

        if($request->file('image')){

            $imageFile = $request->file('image');

            $file_name = uniqid('profile-photos/' , true ).Str::random(10).'.'.$imageFile->getClientOriginalExtension();

            if($imageFile->isvalid()){
                $imageFile->move(public_path('storage\profile-photos'), $file_name);       
            }
        }

      }
      //image validation and storage end
     

        try{
            $SetMessage = 0 ;

            $id = $request->id;
            
            //update user table
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;

            if($request->file('image')){
                $user->profile_photo_path = $file_name;
            }

            $user->save();

            
            //update user_info table
            $user_info = User_Info::where('user_id' , $id)->first();
            $user_info->user_type_id = $request->UserType;
           
            if(isset($request->FatherName)){
                $validator = Validator::make($request->all(), [
                    'FatherName' => ['required', 'string', 'max:255']
                ]);
                if($validator->fails()){
                    return redirect()->back()->WithErrors($validator)->WithInput();
                }
                $user_info->father_name = $request->FatherName;
            }else{
                $user_info->father_name = null;
            }

            if(isset($request->MotherName)){
                $validator = Validator::make($request->all(), [
                    'MotherName' => ['required', 'string', 'max:255']
                ]);
                if($validator->fails()){
                    return redirect()->back()->WithErrors($validator)->WithInput();
                 }
                $user_info->mother_name = $request->MotherName;
            }else{
                $user_info->mother_name = null;
            }

            if(isset($request->Parentphone)){
                $validator = Validator::make($request->all(), [
                    'Parentphone' => 'required|regex:/(01)[0-9]{9}/|min:11|max:11',   
              ]);
              if($validator->fails()){
                return redirect()->back()->WithErrors($validator)->WithInput();
             }
        
                $user_info->parent_phone_number = $request->Parentphone;
            }else{
                $user_info->parent_phone_number = null;
            }

            if(isset($request->Address)){
                $validator = Validator::make($request->all(), [
                    'Address' => ['required', 'string', 'max:255']
                ]);
                if($validator->fails()){
                    return redirect()->back()->WithErrors($validator)->WithInput();
                 }
                $user_info->address = $request->Address;
            }else{
                $user_info->address = null;
            }

            if(isset($request->DateOfBirth)){
                $validator = Validator::make($request->all(), [
                    'DateOfBirth' => 'required',
              ]);
              if($validator->fails()){
                return redirect()->back()->WithErrors($validator)->WithInput();
             }
                $user_info->date_of_birth = $request->DateOfBirth;
            }else{
                $user_info->date_of_birth = null;
            }

            if(isset($request->UserGender)){
                $validator = Validator::make($request->all(), [
                    'UserGender' => 'required',
                 ]);
                 if($validator->fails()){
                    return redirect()->back()->WithErrors($validator)->WithInput();
                 }
                $user_info->gender = $request->UserGender;
            }else{
                $user_info->gender = null;
            }

            if(isset($request->NidNumber)){
                $validator = Validator::make($request->all(), [
                    'NidNumber' => 'required|regex:/[0-9]/|min:10|max:10',
              ]);
              if($validator->fails()){
                return redirect()->back()->WithErrors($validator)->WithInput();
             }
                $user_info->nid_number = $request->NidNumber;
            }else{
                $user_info->nid_number = null;
            }

            if(isset($request->Religion)){
                $validator = Validator::make($request->all(), [
                    'Religion' => 'required',
              ]);
              if($validator->fails()){
                return redirect()->back()->WithErrors($validator)->WithInput();
             }
                $user_info->religion = $request->Religion;
            }else{
                $user_info->religion = null;
            }

            $user_info->save();
            
            //update User_Academic_Info table
            $user_academic_info = User_Academic_Info::where('user_id' , $id)->first();
            
            if($user_academic_info == null){ 
                // create User_Academic_Info
                if( ($request->UserAcademicType != 0) || ($request->UserClass != 0) || isset($request->UserInstituteName)){
                    $New_User_Academic_Info = new User_Academic_Info;

                    $New_User_Academic_Info->user_id      = $user_info->user_id;
                    $New_User_Academic_Info->user_info_id = $user_info->id;
                }
                
               
                if(isset($request->UserInstituteName)){
                    $validator = Validator::make($request->all(), [
                        'UserInstituteName' => ['required', 'string', 'max:255']
                    ]);
                    if($validator->fails()){
                        return redirect()->back()->WithErrors($validator)->WithInput();
                     }
                    $New_User_Academic_Info->user_institute_name = $request->UserInstituteName;
                }
               

                if( $request->UserAcademicType != 0 ){
                    $validator = Validator::make($request->all(), [
                        'UserAcademicType' => 'required|numeric|gt:0',
                        'UserClass' => 'required|numeric|gt:0'
                    ]);
                    if($validator->fails()){
                        $SetMessage = 1 ;
                        $this->SetMessage('Class Is Required  When Add Academic Type' , 'danger');
                        return redirect()->back();
                     }
                    $New_User_Academic_Info->user_academic_type  = $request->UserAcademicType;
                }

                if($request->UserClass != 0){
                    $validator = Validator::make($request->all(), [
                        'UserClass' => 'required|numeric|gt:0'
                    ]);
                    if($validator->fails()){
                        $SetMessage = 1 ;
                        $this->SetMessage('Class Is Required' , 'danger');
                        return redirect()->back();
                     }
                    $New_User_Academic_Info->user_class  = $request->UserClass;
                }
                
                if( ($request->UserAcademicType != 0) || ($request->UserClass != 0) || isset($request->UserInstituteName)){
                    $New_User_Academic_Info->save();
                }
                // create User_Academic_Info end

            }else{
                // update User_Academic_Info
                if(isset($request->UserInstituteName)){
                    $validator = Validator::make($request->all(), [
                        'UserInstituteName' => ['required', 'string', 'max:255']
                    ]);
                    if($validator->fails()){
                        return redirect()->back()->WithErrors($validator)->WithInput();
                     }
                    $user_academic_info->user_institute_name = $request->UserInstituteName;
                }else{
                    $user_academic_info->user_institute_name = null;
                }

                if( $request->UserAcademicType != 0 ){
                    $validator = Validator::make($request->all(), [
                        'UserAcademicType' => 'required|numeric|gt:0',
                        'UserClass' => 'required|numeric|gt:0'
                    ]);
                    if($validator->fails()){
                        $SetMessage = 1 ;
                        $this->SetMessage('Class Is Required  When Add Academic Type' , 'danger');
                        return redirect()->back();
                     }
                    $user_academic_info->user_academic_type = $request->UserAcademicType;
                }else{
                    $user_academic_info->user_academic_type = null;
                }

                if($request->UserClass != 0){
                    $validator = Validator::make($request->all(), [
                        'UserClass' => 'required|numeric|gt:0'
                    ]);
                    if($validator->fails()){
                        $SetMessage = 1 ;
                        $this->SetMessage('Class Is Required' , 'danger');
                        return redirect()->back();
                     }
                    $user_academic_info->user_class = $request->UserClass;
                }else{
                    $user_academic_info->user_class = null;
                }

                $user_academic_info->save();

            // update User_Academic_Info end

            }

            //update User_Academic_Info table end
            



            DB::table('model_has_roles')->where('model_id', $id)->delete();

            //user model_has_roles table update
            $user->assignRole($request->UserRole);
            
            if($SetMessage != 1){
                $this->SetMessage('User Update Successfull' , 'success');
            }

            $data['users'] = User::select('id', 'name', 'email', 'phone' , 'profile_photo_path')->get();
            
            return redirect('/user')->with($data);
            
        
        }catch (Exception $e){
            
            $this->SetMessage($e->getMessage() , 'danger');

            return redirect()->back();
         }
        
    }


    public function image_delete(Request $request ,$id){
      
        $user = User::find($request->id);

        unlink(public_path('/storage/'.$user->profile_photo_path));

        $user->profile_photo_path = null;
        $user->save();
         
        $id = $request->id;

        return response()->json([ 'success' => 'image Delete Successfull',
                                  'u_id' => $id,
                                ]);

     }

    public function delete(Request $request, $id){
                  
        $user = User::find($id);

        $user->delete();

        // $this->SetMessage('Role Delete Successfull' , 'success');

        // $data['users'] = User::select('id','name')->get();
            
        // return redirect('/user')->with($data);

        return response()->json([ 'success' => 'Permission Delete Successfull']);

     }

     public function User_Verify(Request $request, $id){
        try{

            $id = $request->id;
            $verified_by = Auth::id();
            
            //update user table
            $user = User::find($id);
            $user->is_verified = 1;
            $user->save();
            
            //update user_info table
            $User_Info = User_Info::where('user_id' , $id)->first();
            $User_Info->verified_by = $verified_by;
            $User_Info->save();

            return response()->json([ 'success' => 'User Verifyed Successfull']);
            
        
        } catch (Exception $e){
            return response()->json([ 'error' => 'something wrong.... user not verifyed']);
         }

     }

    public function phone_number_availability(Request $request , $number){
        
        //for frontend phone number validation
        $user_has_phone_number = User::select('phone')->where('phone' , $number)->first();

        if($user_has_phone_number != null){
        return response()->json([ '<span class="text-danger">Phone Number is already taken</span>']);
        }       
        //for frontend validation phone number end
    }

    public function email_availability(Request $request , $email){
        
        //for frontend phone number validation
        $user_has_email = User::select('email')->where('email' , $email)->first();

        if($user_has_email != null){
        return response()->json([ '<span class="text-danger">Email is already taken</span>']);
        }       
        //for frontend validation phone number end
    }

// create_at_date_filter
    public function create_at_date_filter(Request $request){
     
     $from_date = $request->from_date;
     $to_date = $request->to_date;
     //dd($to_date);

     if(isset($from_date, $to_date)){

      $output = '';  
      $Users = User::where('created_at' , '>=' , $from_date." 00:00:00")->where('created_at' , '<=' ,  $to_date." 23:59:59")->get();    
        //dd(count($Users));
      $output .= '<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

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
                 <tbody>
                        <tr>';

      if(count($Users) > 0 )  
      {  
           $i=1;
          foreach($Users as $users){            
                                                    
            $output .=  '<th style=text-align:center scope="row">' .$i++. '</th>
                         <td style=text-align:center scope="row">
                         <img class="rounded-circle z-depth-2" width="60px" height="60px" src="storage/'.$users->profile_photo_path.'"data-holder-rendered="true">
                         </td>
                        <td style=text-align:center >' .$users->id. '</td>
                        <td style=text-align:center>
                          <label><a href=/user-show-'.$users->id. ' class="hover" id='.$users->id.'>'.$users->name.'</a></label>    
                        </td>                                
                        
                        <td style=text-align:center >' .$users->created_at->format("m/d/Y"). '</td>
                        <td style=text-align:center >' .$users->id . '</td>
                                      
                  ';
            $output .= '
                       <td style=text-align:center>
                        
                               <a href=/user-show-'.$users->id. ' '. 'class="btn btn-info btn-sm" title="View User"><i class="fa fa-eye"></i></a>

                               <a href=/user-edit-'.$users->id. ' '. 'class="btn btn-warning btn-sm" title="Edit User"><i class="fa fa-edit"></i></a>
                                                        
                            <!-- jquery delete -->
                                <button class="btn btn-danger btn-sm delete" data-id="' .$users->id. '" value='.$users->id.'><i
                                                        class="fa fa-trash"></i></button>
                            <!-- jquery delete end -->

                                                        
                        </td>
                    
                                                    
              </tr>';
                                 
                                 
          }  
      }  
      else  
      {  
           $output .= '  
                 
                     <td style=text-align:center colspan="12"> User Data  Not Found</td>  
                </tr>  
           ';  
      }

      $output .= '</tbody>
                    </table>';  
      
      echo $output;  
      
      }

    }
// create_at_date_filter end 

public function dynamicly_user_class_select(Request $request){

    $user_academic_type_id = $request->user_academic_type_id;

    $query_class = Classes::select('id','name')->where('academic_type' , $user_academic_type_id)->get();
   
    $output = '';
    $output .= '<option value="0">Choose any one</option>';
    
    if($request->action == "All_Class_Show"){
        foreach($query_class as $query_class){
            $output .= '<option value="'.$query_class->id.'">'.$query_class->name.'</option>';
        }
    }elseif ($request->action == "Selected_Class_Show") {
        $user_id = $request->user_id;
        $data['User_Academic_Info'] = User_Academic_Info::select('user_class')->where('user_id' , $user_id)->first();

        foreach($query_class as $query_class){ 
            if($data['User_Academic_Info']->user_class == $query_class->id){
                $output .= '<option value="'.$query_class->id.'" selected>'.$query_class->name.'</option>';
            }else{
                $output .= '<option value="'.$query_class->id.'">'.$query_class->name.'</option>';
            }
        }
    }

 
    echo $output;

  }

}
