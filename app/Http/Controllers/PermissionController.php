<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class PermissionController extends Controller
{
    public function index(){
        
        $data['Permissions'] = Permission::select('id' ,'name')->get();
        
        return view('Backend.Permission.index' , $data );
    }

    public function create(){

        return view('Backend.Permission.create' );
    }

    
    public function store(Request $request){
 
        $validator = Validator::make($request->all(), [
            'PermissionName' => [
                'required',
                'regex:/^[A-Za-z0-9 ]+$/',
                'unique:permissions,name',
            ],
        ]);

        if($validator->fails()){
            return redirect()->back()->WithErrors($validator)->WithInput();
        }

        try{
            
            $permission = Permission::create([
                'name' => $request->PermissionName
                ]);

            $this->SetMessage('Permission Create Successfull' , 'success');

            $data['Permissions'] = Permission::select('id','name')->get();
            
            return redirect('/permission');
            

        } catch (Exception $e){

            $this->SetMessage($e->getMessage() , 'danger');

            return redirect()->back();
         }
        
    }

    // public function show(Request $request){

    //     $id = $request->id;
    //     $data['permission'] = Permission::where('id', $id)->first();
    //     return view('Backend.permission.view' , $data );
    // }

    // jquery view
    public function show(Request $request){
  
        $id = $request->id;
        if(isset($id))
         {  
              $output = '';    
              $Permission = Permission::where('id', $id)->first();
                     
                                      
              $output .= '  
              <div class="table-responsive">  
                   <table class="table table-bordered">';  
                   $output .= '  
                        <tr>  
                             <td width="30%"><label>id</label></td>  
                             <td width="70%">'.$Permission->id.'</td>  
                        </tr>  
                        <tr>  
                             <td width="30%"><label>name</label></td>  
                             <td width="70%">'.$Permission->name.'</td>  
                        </tr>
                            
                        ';   
              $output .= "</table></div>";      

              echo $output;  
//              return response()->json([ 'output' => $output]);
         }
    }


    public function edit(Request $request){

        $id = $request->id;
        $data['permission'] = Permission::select('id', 'name')
                              ->where('id', $id)
                              ->first();

        return view('Backend.Permission.edit' , $data);

    }
      
// jquery edit
     public function jquery_edit(Request $request){

      $id = $request->id;

      if(isset($id))  
     {  
        $permission = Permission::select('id', 'name')
                              ->where('id', $id)
                              ->first();
  
      //$row = mysqli_fetch_array($result);  
      echo json_encode($permission);  
     }

    }

    public function jquery_update(Request $request){
      
      $id = $request->id;
      
      $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'regex:/^[A-Za-z0-9 ]+$/',
                'unique:permissions,name,'.$id,
            ],
        ]);

        if($validator->fails()){
              return response()->json([ 'error' => 'Permission name has already taken']);
        }

      if($id != null)  
      {  
            $Permission = Permission::select('id', 'name')
                              ->where('id', $id)
                              ->first();

            $Permission->name = $request->name;
            $Permission->save();
           // return response()->json([ 'success' => 'Permission Update Successfull']);
           
      }

      $Permissions = Permission::select('id' ,'name')->get(); 
      
      $output = '';

      
            $output = '    
                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                        <thead class="thead-default">
                              <tr>
                                  <th style=text-align:center>SL</th>
                                  <th style=text-align:center>Permission Name</th>
                                  <th style=text-align:center>Action</th>
                                                   
                              </tr>
                        </thead>     
                  ';
                  
            
            $output .= '
                 <tbody>
                        <tr>';

          $i=1;
          foreach($Permissions as $permission){            
                                                    
            $output .=  '<th style=text-align:center scope="row">' .$i++. '</th>
                                                        
                            <td style=text-align:center>' .$permission->name. '</td>
                                      
                  ';
            $output .= '
                       <td style=text-align:center>
                                                        
                            <!-- jquery view -->
                               <a name="view" value="view" id="'. $permission->id. '" class="btn btn-info btn-sm view_Permission" title="View Permission"><i class="fa fa-eye"></i></a>
                            <!-- jquery view end-->
                                                        
                            <!-- jquery edit -->  
                                <a  name="edit" value="Edit" id="'. $permission->id. '" class="btn btn-warning btn-sm edit_data" title="Edit Role"><i class="fa fa-edit"></i></a>
                            <!-- jquery edit end -->
                                                        
                            <!-- jquery delete -->
                                <button class="btn btn-danger btn-sm delete" data-id="' .$Permission->id. '" value="{{$Permission->id}}"><i
                                                        class="fa fa-trash"></i></button>
                            <!-- jquery delete end -->

                                                        
                        </td>
                    
                                                    
              </tr>';
                                 
                                 
          }

          $output .=   '    </tbody>
                                           
                                    </table>';

    echo $output;

    }    
// jquery edit end   

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'PermissionName' => [
                'required',
                'regex:/^[A-Za-z0-9 ]+$/',
                'unique:permissions,name,'.$request->id,
            ],
        ]);

        if($validator->fails()){
            return redirect()->back()->WithErrors($validator)->WithInput();
        }

        try{

            $id = $request->id;

            $data['Permissions'] = Permission::find($id);

            $data['Permissions']->update([
               'name' => $request->PermissionName,
         ]);

            $this->SetMessage('Permission Update Successfull' , 'success');

            $data['Permissions'] = Permission::select('id','name')->get();
            
            return redirect('/permission');
            

        } catch (Exception $e){

            $this->SetMessage($e->getMessage() , 'danger');

            return redirect()->back();
         }
        
    }

    public function delete(Request $request, $id){

        $permission = Permission::find($id);

        $permission->delete();

        // $this->SetMessage('Permission Delete Successfull' , 'success');

        // $data['Permissions'] = Permission::select('id','name')->get();
            
        // return redirect('/permission')->with($data);

        return response()->json([ 'success' => 'Permission Delete Successfull']);

     }
}
