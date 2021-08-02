<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User_Type;
use Validator;
use DB;

class UserTypeController extends Controller
{
    public function index(){
       
        $data['User_Types'] = User_Type::select('id' ,'name', 'assing_role_id')->get();
        
        return view('Backend.UserType.index' , $data );
    }

    public function create(){

        $data['Roles'] = Role::select('id' ,'name')->get();
        
        return view('Backend.UserType.create' ,$data);
    }

    public function store(Request $request){
        
        $validator = Validator::make($request->all(), [
            'UserTypeName' => [
                'required',
                'regex:/^[A-Za-z0-9 ]+$/',
                'unique:user_types,name',
            ],
            'UserRole' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->WithErrors($validator)->WithInput();
        }

        try{

            $user_types = User_Type::create([
                       'name' => $request->UserTypeName,
                       'assing_role_id' => $request->UserRole,

                    ]);

            $this->SetMessage('User Type Create Successfull' , 'success');
           

            $data['Roles'] = Role::select('id','name')->get();
            
            return redirect('/UserType')->with($data);
            

        } catch (Exception $e){

            $this->SetMessage($e->getMessage() , 'danger');

            return redirect()->back();
         }
        
    }

    // jquery view
    public function show(Request $request){
  
     $id = $request->id;
           
      if(isset($id)){  
            $output = '';    
            $User_Type = User_Type::where('id', $id)->first();

            $user_assign_role_name =  Role::select('name')->where('id' , $User_Type->assing_role_id)->first(); 
                         
            $output .= '  
                <div class="table-responsive">  
                    <table class="table table-bordered">';  
                        $output .= '  
                            <tr>  
                                 <td width="30%"><label>id</label></td>  
                                 <td width="70%">'.$User_Type->id.'</td>  
                            </tr>  
                            <tr>  
                                 <td width="30%"><label>name</label></td>  
                                 <td width="70%">'.$User_Type->name.'</td>  
                            </tr>
                            <tr>  
                                 <td width="30%"><label>assing role</label></td>  
                                 <td width="70%">'.$user_assign_role_name->name.'</td>  
                            </tr>
                                
                            ';   
            $output .= "</table></div>";      
    
            echo $output;  
    //      return response()->json([ 'output' => $output]);
        }
    }

    public function delete(Request $request, $id){

        $User_Type = User_Type::find($id);

        $User_Type->delete();

        // $this->SetMessage('Permission Delete Successfull' , 'success');

        // $data['Permissions'] = Permission::select('id','name')->get();
            
        // return redirect('/permission')->with($data);

        return response()->json([ 'success' => 'User Type Delete Successfull']);

     }

     public function edit(Request $request){

        $id = $request->id;
        $data['User_Type'] = User_Type::select('id', 'name' , 'assing_role_id')
                              ->where('id', $id)
                              ->first();

        $data['Roles'] = Role::select('id' , 'name')->get();
                                               
        return view('Backend.UserType.edit' , $data);
    }

    public function update(Request $request){
      
        $validator = Validator::make($request->all(), [
            'UserTypeName' => [
                'required',
                'regex:/^[A-Za-z0-9 ]+$/',
                 'unique:user_types,name,'.$request->id,
            ],
            'UserRole' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->WithErrors($validator)->WithInput();
        }

        try{

            $id = $request->id;

            $user_types = User_Type::find($id);
            $user_types->name = $request->UserTypeName;
            $user_types->assing_role_id = $request->UserRole;
            $user_types->save();
            
          
            $this->SetMessage('User Type Update Successfull' , 'success');

            $data['User_Types'] = User_Type::select('id' ,'name', 'assing_role_id')->get();
            
            return redirect('/UserType')->with($data);
            
        
        } catch (Exception $e){
            
            $this->SetMessage($e->getMessage() , 'danger');

            return redirect()->back();
         }
        
    }

}
