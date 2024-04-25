<?php

namespace App\Http\Controllers;

use App\Models\attendance;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public  function Getattendance(Request $request){

        $search = $request->search;

        $attendance = attendance::when($search, function($query) use ($search){
            
            $query->where('date', 'like', "%$search%");

        })->paginate(5);

    
        return view('admin.attendance.all_attendance',compact('attendance','search'));
    }

    public function AddAttendance(){
        $student = Student::latest()->get();
        
       
        return view('admin.attendance.add_attendance',compact('student'));
    }

    public function StoreAttendance(Request $request){

        $request->validate([
           
            'attendance' => 'required',
        ]
        );

        $attendance = new attendance();
        
        $attendance->date = $request->date;
        $attendance->stu_id = $request->attendance;
        $attendance->save();

        $notification = array(
            'message' => 'Attendance Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('get.attendance')->with($notification);
    }

    public function EditAttendance($id){
        $student = Student::latest()->get();
        $attendance = attendance::find($id);

        return view('admin.attendance.edit_attendance',compact('attendance','student'));
    }

    public function UpdateAttendance(Request $request, $id){
        // $student_id = Student::latest()->get();
        $attendance = attendance::find($id);
        $attendance->stu_id = $request->student;
        $attendance->date = $request->date;
        $attendance->save();

        $notification = array(
            'message' => 'Attendance Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('get.attendance')->with($notification);

    }

    public function DeleteAttendance($id){
        
        $attendance = attendance::find($id);
        $attendance->delete();

        $notification = array(
            'message' => 'Attendance Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('get.attendance')->with($notification);
    }
}
