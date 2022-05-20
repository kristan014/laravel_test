<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Resources\CourseResource;
use App\Http\Requests\StoreCourseRequest;



use Illuminate\Http\Request;
use Validator;

class CourseController extends Controller
{
 
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'prevent-back-history']);
    // }

    public function index()
    {
        $this->middleware(['auth', 'prevent-back-history']);
        return view('course');
    }

    public function getall()
    {
        $course = Course::all();
        return CourseResource::collection($course);

    }


    public function datatable()
    {
        if (request()->ajax()) {
            return datatables()->of(Course::latest()->get())
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
        // $query = Course::where('id',$id)->first();
        // return response()->json($query);
        $course = Course::findOrFail($id);
        return new CourseResource($course);
    }



    public function store(Request $request)
    {
        // form ajax method
        $rules = array(
            'course_name'    =>  'required',
            'description'     =>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'course_name'        =>  $request->course_name,
            'description'         =>  $request->description,
            'status'         =>  'Active',
        );

        $course = Course::create($form_data);

        // return response()->json(['success' => 'Data Added successfully.']);

        // return ['success' => true, 'message' => 'Inserted Successfully'];
        return new CourseResource($course);
    }


    public function update(Request $request)
    {
        // do validation

        $rules = array(
            'course_name'    =>  'required',
            'description'     =>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'course_name'        =>  $request->course_name,
            'description'         =>  $request->description,
        );
    
        Course::whereId($request->hidden_id)->update($form_data);


        return response()->json(['success' => 'Data Updated successfully.']);
    }

    public function destroy($id)
    {
        $data = Course::findOrFail($id);
        $data->delete();
        return response()->json(['success' => 'Data Deleted successfully.']);

    }
}
