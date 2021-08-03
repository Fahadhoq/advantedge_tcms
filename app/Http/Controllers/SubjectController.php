<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use Validator;

class SubjectController extends Controller
{
    public function index(){
       
        $data['subjects'] = Subject::select('id' ,'name')->get();
       
        return view('Backend.Subject.index' , $data );
    }

    public function create(){
        return view('Backend.Subject.create');
    }

    public function store(Request $request){
        
        $validator = Validator::make($request->all(), [
            'SubjectName' => [
                'required',
                'regex:/^[A-Za-z0-9 ]+$/',
                'unique:subjects,name',
            ] 
        ]);

        if($validator->fails()){
            return redirect()->back()->WithErrors($validator)->WithInput();
        }

        try{

            $Subject = Subject::create([
                       'name' => $request->SubjectName,
                    ]);

            $this->SetMessage('Subject Create Successfull' , 'success');
                
            return redirect('/subject');
            

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
               $Subject = Subject::where('id', $id)->first();
                            
               $output .= '  
                   <div class="table-responsive">  
                       <table class="table table-bordered">';  
                           $output .= '  
                               <tr>  
                                    <td width="30%"><label>id</label></td>  
                                    <td width="70%">'.$Subject->id.'</td>  
                               </tr>  
                               <tr>  
                                    <td width="30%"><label>name</label></td>  
                                    <td width="70%">'.$Subject->name.'</td>  
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
  
        if(isset($id)){  
            $Classes = Subject::select('id', 'name')
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
                  'unique:subjects,name,'.$id,
              ],
          ]);
  
          if($validator->fails()){
                return response()->json([ 'error' => 'Class name has already taken']);
          }
  
        if($id != null)  
        {  
              $subject = Subject::select('id', 'name')
                                ->where('id', $id)
                                ->first();
  
              $subject->name = $request->name;
              $subject->save();
             // return response()->json([ 'success' => 'Subject Update Successfull']);
             
        }
  
        $Subjects = Subject::select('id' ,'name')->get(); 
        
        $output = '';
  
        
              $output = '    
                  <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
  
                          <thead class="thead-default">
                                <tr>
                                    <th style=text-align:center>SL</th>
                                    <th style=text-align:center>Subject Name</th>
                                    <th style=text-align:center>Action</th>
                                                     
                                </tr>
                          </thead>     
                    ';
                    
              
              $output .= '
                   <tbody>
                          <tr>';
  
            $i=1;
            foreach($Subjects as $subject){            
                                                      
              $output .=  '<th style=text-align:center scope="row">' .$i++. '</th>
                                                          
                              <td style=text-align:center>' .$subject->name. '</td>
                                        
                    ';
              $output .= '
                         <td style=text-align:center>
                                                          
                              <!-- jquery view -->
                                  <a name="view" value="view" id="'. $subject->id. '" class="btn btn-info btn-sm view_subject" title="View subject"><i class="fa fa-eye"></i></a>
                              <!-- jquery view end-->
                                                          
                              <!-- jquery edit -->  
                                  <a  name="edit" value="Edit" id="'. $subject->id. '" class="btn btn-warning btn-sm edit_data" title="Edit Class"><i class="fa fa-edit"></i></a>
                              <!-- jquery edit end -->
                                                          
                              <!-- jquery delete -->
                                  <button class="btn btn-danger btn-sm delete" data-id="' .$subject->id. '" value="{{$subject->id}}"><i class="fa fa-trash"></i></button>
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

        $subject = Subject::find($id);

        $subject->delete();

        return response()->json([ 'success' => 'Subject Delete Successfull']);

   }

}
