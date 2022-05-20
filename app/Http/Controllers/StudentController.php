<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Validator;


class StudentController extends Controller
{


    public function index()
    {
        $this->middleware(['auth', 'prevent-back-history']);
        return view('student');
    }

    public function datatable()
    {
        if (request()->ajax()) {
       
            return datatables()->of(Student::with('courses'))
                ->addColumn('action', function ($data) {
             

                    $button = '<button type="button" name="edit" onClick="return editData(\'' .$data->id. '\',0)" class="edit btn btn-secondary btn-sm d-flex">View</button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="edit" onClick="return editData(\'' .$data->id. '\',1)" class="edit btn btn-primary btn-sm d-flex">Edit</button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" onClick="return deleteData(\'' .$data->id. '\')" class="delete btn btn-danger btn-sm d-flex">Delete</button>';
                 
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    
    public function getone($id)
    {
        $query = Student::where('id',$id)->first();
        return response()->json($query);
    }



    public function store(Request $request)
    {
        // form ajax method
        $rules = array(
            'full_name'    =>  'required',
            'contact'     =>  'required',
            'region'     =>  'required',
            'course_id'     =>  'required',
            'section'     =>  'required',

        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'full_name'        =>  $request->full_name,
            'contact'         =>  $request->contact,
            'region'         =>  $request->region,
            'section'         =>  $request->section,
            'course_id'         =>  $request->course_id,
            'status'         =>  'Active',
        );

        Student::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);

        // return ['success' => true, 'message' => 'Inserted Successfully'];
    }


    public function update(Request $request)
    {
        // do validation

        $rules = array(
            'full_name'    =>  'required',
            'contact'     =>  'required',
            'region'     =>  'required',
            'course_id'     =>  'required',
            'section'     =>  'required',
                                        
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'full_name'        =>  $request->full_name,
            'contact'         =>  $request->contact,
            'region'         =>  $request->region,
            'section'         =>  $request->section,
            'course_id'         =>  $request->course_id,
        );
    
        Student::whereId($request->hidden_id)->update($form_data);

        return $form_data;

        // return response()->json(['success' => 'Data Updated successfully.']);
    }

    public function destroy($id)
    {
        $data = Student::find($id);
        $data->delete();
        return response()->json(['success' => 'Data Deleted successfully.']);

    }
}
