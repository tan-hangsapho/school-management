<?php

namespace App\Http\Controllers;
use App\Models\StuClass;

use Illuminate\Http\Request;

class ClassController extends Controller
{


    public function GetClass(Request $request){
       
        $search = $request->search;

        $class = StuClass::when($search, function($query) use ($search)
        {
            $query->where('class_name','like',"%$search%");

        })->paginate(5);

        
        return view('admin.class.get_class',compact('search','class'));
    }
    public function AddClasses(){

    

        return view('admin.class.add_class');
    }

    public function StoreClasses(Request $request){


        $request->validate([

            'class' => 'required',
            'status' => 'required',
        ]
        );


        $class = new StuClass();
        $class->class_name = $request->class;
        $class->status = $request->status;
        $class->created_at = now();
        $class->save();

        $notification = array(
            'message' => 'Class Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('get.class')->with($notification);

    }


    public function EditClasses($id){

        $class = StuClass::find($id);

        return view('admin.class.edit_class',compact('class'));

    }
    
    public function UpdateClasses(Request $request,$id){

        $class = StuClass::find($id);
        $class->class_name = $request->class;
        $class->status = $request->status;
        $class->updated_at = now();
        $class->save();

        $notification = array(
            'message' => 'Class Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('get.class')->with($notification);

    }

    public function DeleteClasses($id){

        $class = StuClass::find($id);
        $class->delete();
        // $class->save();

        $notification = array(
            'message' => 'Class Deleted Successfully',
            'alert-type' => 'success'
        );
        
        return redirect()->route('get.class')->with($notification);


    }
}
