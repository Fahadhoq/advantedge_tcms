<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\RoleHasPermission;
use DB;

class RoleController extends Controller
{
    public function index(){

        $data['Roles'] = Role::select('id' ,'name')->get();
        
        return view('Backend.Role.index' , $data );
    }

    public function create(){

        $data['Permissions'] = Permission::select('name' , 'id')->get();
        
        return view('Backend.Role.create' ,$data);
    }

    
    public function store(Request $request){
         
        
        $auth_id = auth()->user()->id;
        
        $validator = Validator::make($request->all(), [
            'RoleName' => [
                'required',
                'regex:/^[A-Za-z0-9 ]+$/',
                'unique:roles,name',
            ],
        ]);

        if($validator->fails()){
            return redirect()->back()->WithErrors($validator)->WithInput();
        }

        try{

            $role = Role::create([
                       'name' => $request->RoleName
                        ]);
       
            if(isset($request->permission)){
               
                foreach ($request->permission as  $val) {
                   
                    $role->givePermissionTo($val);  
                    }
            }

            $this->SetMessage('Role Update Successfull' , 'success');
           

            $data['Roles'] = Role::select('id','name')->get();
            
            return redirect('/role')->with($data);
            

        } catch (Exception $e){

            $this->SetMessage($e->getMessage() , 'danger');

            return redirect()->back();
         }
        
    }

    // public function show(Request $request){
  
    //     $id = $request->id;
    //     $Role = Role::where('id', $id)->first();

    //     $hasPermissions = RoleHasPermission::select( 'permission_id')
    //                                                ->where('role_id' , $id)
    //                                                ->get();
       
    //     $PerName =[];
    //     foreach($hasPermissions as $hasPermission){
    //         $Permissions =  Permission::select('name')->where('id' , $hasPermission->permission_id)->get(); 
    //         array_push($PerName, $Permissions);                                         
    //     }

    //     return view('Backend.Role.view', compact('Role', 'PerName'));
    // }

   // jquery view
    public function show(Request $request){
  
        $id = $request->id;
         {  
              $output = '';    
              $Role = Role::where('id', $id)->first();

              $hasPermissions = RoleHasPermission::select( 'permission_id')
                                                           ->where('role_id' , $id)
                                                           ->get();
              $PerName =[];

              foreach($hasPermissions as $hasPermission){
                    $Permissions =  Permission::select('name')->where('id' , $hasPermission->permission_id)->get(); 
                    array_push($PerName, $Permissions);                                         
               }                     
                                      
              $output .= '  
              <div class="table-responsive">  
                   <table class="table table-bordered">';  
                   $output .= '  
                        <tr>  
                             <td width="30%"><label>id</label></td>  
                             <td width="70%">'.$Role->id.'</td>  
                        </tr>  
                        <tr>  
                             <td width="30%"><label>name</label></td>  
                             <td width="70%">'.$Role->name.'</td>  
                        </tr>
                        <tr>  
                             <td width="30%"><label>permission name</label></td>  
                             <td width="70%">
                                      ';
                                       $i = 1;
                                       foreach ($PerName as $key => $Permission) {
                                             foreach ($Permission as $PermissionName) {
                                          $output .= $i++ . '. ' . $PermissionName->name .'<br>';
                                          
                                           }
                                        }
                             
              $output .= " </td>  
                        </tr>
                        </table></div>";
              

              echo $output;  
//              return response()->json([ 'output' => $output]);
         }
    }

    public function edit(Request $request){

        $id = $request->id;
        $data['Role'] = Role::select('id', 'name')
                              ->where('id', $id)
                              ->first();

        $data['Permissions'] = Permission::select('id' , 'name')->get();

        $data['hasPermissions'] = RoleHasPermission::select( 'permission_id')
                                                   ->where('role_id' , $id)
                                                   ->get();
                                                   
                                                   
        return view('Backend.Role.edit' , $data);
    }

    public function update(Request $request){
      
        $validator = Validator::make($request->all(), [
            'RoleName' => [
                'required',
                'regex:/^[A-Za-z0-9 ]+$/',
                 'unique:roles,name,'.$request->id,
            ],
        ]);

        if($validator->fails()){
            return redirect()->back()->WithErrors($validator)->WithInput();
        }

        try{

            $id = $request->id;

            $role = Role::find($id);
            $role->name = $request->RoleName;
            $role->save();

            DB::table('role_has_permissions')->where('role_id', $id)->delete();
                                                      
            if(isset($request->permission)){
                foreach ($request->permission as  $val) {
                
                    $role->givePermissionTo($val); 
                    
                  }

            }
            
          
            $this->SetMessage('Role Update Successfull' , 'success');

            $data['Roles'] = Role::select('id','name')->get();
            
            return redirect('/role')->with($data);
            
        
        } catch (Exception $e){
            
            $this->SetMessage($e->getMessage() , 'danger');

            return redirect()->back();
         }
        
    }

    public function delete(Request $request, $id){

                            
        $role = Role::find($id);

        $role->delete();

       // $this->SetMessage('Role Delete Successfull' , 'success');

        $data['Roles'] = Role::select('id','name')->get();

        return response()->json([ 'success' => 'Role Delete Successfull']);
        //return redirect('/role')->with($data);

     }


}
