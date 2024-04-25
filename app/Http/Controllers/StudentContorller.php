<?php

namespace App\Http\Controllers;
use App\Models\StuClass;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentContorller extends Controller
{
    public function GetStudent(Request $request){
        
        $search = $request->search;

        $students = Student::when($search,function($query) use($search)
        {
            $query->where('name','like',"%$search%");
        })->paginate(5);
        
       
        return view('admin.student.get_student',compact('students','search'));
        
    }

    public function AddStudent(){

            $class = StuClass::latest()->get();
            
            return view('admin.student.add_student',compact('class'));
            
    }

    public function StoreStudent(Request $request){


            $request->validate(

                [
                'name' => 'required',
                'gender' => 'required',
                'class' => 'required',
                ]

            );

            $student = new Student();
            $student->name = $request->name;
            $student->gender = $request->gender;
            $student->class_id = $request->class;
            $student->save();

            $notification = array(
                'message' => 'Student Added Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('get.student')->with($notification);
            
    }

    public function EditStudent($id){
            $class = StuClass::latest()->get();
            $student = Student::find($id);

          
            return view('admin.student.edit_student',compact('student','class'));
            
    }

    public function UpdateStudent(Request $request, $id){

        $student = Student::find($id);
        
        $student->name = $request->name;
        $student->gender = $request->gender;
        $student->class_id = $request->class;

        $student->save();

        $notification = array(
            'message' => 'Student Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('get.student')->with($notification);
    }

    public function DeleteStudent($id){
            $student = Student::find($id);
            $student->delete();
            $student->attendance()->delete();

            $notification = array(
                'message' => 'Student Deleted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('get.student')->with($notification);
            
    }
}

