<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use Validator;

class ClassController extends Controller
{
    public function index(){
       
        $data['Classes'] = Classes::select('id' ,'name')->get();
       
        return view('Backend.Class.index' , $data );
    }

    public function create(){
        return view('Backend.Class.create');
    }

    public function store(Request $request){
        
        $validator = Validator::make($request->all(), [
            'ClassName' => [
                'required',
                'regex:/^[A-Za-z0-9 ]+$/',
                'unique:classes,name',
            ] 
        ]);

        if($validator->fails()){
            return redirect()->back()->WithErrors($validator)->WithInput();
        }

        try{

            $user_types = Classes::create([
                       'name' => $request->ClassName,
                    ]);

            $this->SetMessage('Class Create Successfull' , 'success');
                
            return redirect('/class');
            

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
               $class = Classes::where('id', $id)->first();
                            
               $output .= '  
                   <div class="table-responsive">  
                       <table class="table table-bordered">';  
                           $output .= '  
                               <tr>  
                                    <td width="30%"><label>id</label></td>  
                                    <td width="70%">'.$class->id.'</td>  
                               </tr>  
                               <tr>  
                                    <td width="30%"><label>name</label></td>  
                                    <td width="70%">'.$class->name.'</td>  
                               </tr>
                       
                               ';   
               $output .= "</table></div>";      
       
               echo $output;  
       //      return response()->json([ 'output' => $output]);
           }
       }

// jquery edit
     public function edit(Request $request){

        $id = $request->id;
  
       if(isset($id))  
       {  
          $Classes = Classes::select('id', 'name')
                                ->where('id', $id)
                                ->first();
    
          echo json_encode($Classes);  
       }
  
      }
  
      public function update(Request $request){
        
        $id = $request->id;
        
        $validator = Validator::make($request->all(), [
              'name' => [
                  'required',
                  'regex:/^[A-Za-z0-9 ]+$/',
                  'unique:classes,name,'.$id,
              ],
          ]);
  
          if($validator->fails()){
                return response()->json([ 'error' => 'Class name has already taken']);
          }
  
        if($id != null)  
        {  
              $Classes = Classes::select('id', 'name')
                                ->where('id', $id)
                                ->first();
  
              $Classes->name = $request->name;
              $Classes->save();
             // return response()->json([ 'success' => 'Permission Update Successfull']);
             
        }
  
        $Classes = Classes::select('id' ,'name')->get(); 
        
        $output = '';
  
        
              $output = '    
                  <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
  
                          <thead class="thead-default">
                                <tr>
                                    <th style=text-align:center>SL</th>
                                    <th style=text-align:center>Class Name</th>
                                    <th style=text-align:center>Action</th>
                                                     
                                </tr>
                          </thead>     
                    ';
                    
              
              $output .= '
                   <tbody>
                          <tr>';
  
            $i=1;
            foreach($Classes as $Class){            
                                                      
              $output .=  '<th style=text-align:center scope="row">' .$i++. '</th>
                                                          
                              <td style=text-align:center>' .$Class->name. '</td>
                                        
                    ';
              $output .= '
                         <td style=text-align:center>
                                                          
                              <!-- jquery view -->
                                  <a name="view" value="view" id="'. $Class->id. '" class="btn btn-info btn-sm view_Class" title="View Class"><i class="fa fa-eye"></i></a>
                              <!-- jquery view end-->
                                                          
                              <!-- jquery edit -->  
                                  <a  name="edit" value="Edit" id="'. $Class->id. '" class="btn btn-warning btn-sm edit_data" title="Edit Class"><i class="fa fa-edit"></i></a>
                              <!-- jquery edit end -->
                                                          
                              <!-- jquery delete -->
                                  <button class="btn btn-danger btn-sm delete" data-id="' .$Class->id. '" value="{{$Class->id}}"><i class="fa fa-trash"></i></button>
                              <!-- jquery delete end -->
                                   
                          </td>
                      
                                                      
                </tr>';
                                   
                                   
            }
  
            $output .=   '    </tbody>
                                             
                                      </table>';
  
      echo $output;
  
      }    
  // jquery edit end 

       public function delete(Request $request, $id){

        $Class = Classes::find($id);

        $Class->delete();

        return response()->json([ 'success' => 'Class Delete Successfull']);

     }
}
