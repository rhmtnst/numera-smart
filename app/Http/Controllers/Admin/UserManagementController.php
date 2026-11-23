<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\School;
use App\Models\TeacherAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function teachers(){ $users=User::where('role','teacher')->with('school')->latest()->paginate(15); return view('admin.teachers.index',compact('users')); }
    public function createTeacher(){ $schools=School::where('status','active')->orderBy('name')->get(); return view('admin.teachers.form',compact('schools')); }
    public function storeTeacher(Request $r){ $d=$r->validate(['name'=>'required|string|max:255','email'=>'required|email|unique:users,email','password'=>'required|string|min:8|confirmed','school_id'=>'required|exists:schools,id']); User::create($d+['role'=>'teacher','is_active'=>true]); return redirect()->route('admin.teachers.index')->with('success','Akun guru berhasil dibuat.'); }
    public function editTeacher(User $user){ abort_unless($user->role==='teacher',404); $schools=School::where('status','active')->orderBy('name')->get(); return view('admin.teachers.form',compact('user','schools')); }
    public function updateTeacher(Request $r, User $user){ abort_unless($user->role==='teacher',404); $d=$r->validate(['name'=>'required|string|max:255','email'=>['required','email',Rule::unique('users')->ignore($user->id)],'school_id'=>'required|exists:schools,id','password'=>'nullable|string|min:8|confirmed','is_active'=>'required|boolean']); if(!empty($d['password'])) $user->password=$d['password']; unset($d['password']); $user->update($d); return back()->with('success','Data guru diperbarui.'); }
    public function students(){ $users=User::where('role','student')->with(['school','studentProfile'])->latest()->paginate(15); return view('admin.students.index',compact('users')); }
    public function updateStudent(Request $r, User $user){ abort_unless($user->role==='student',404); $d=$r->validate(['school_id'=>'nullable|exists:schools,id','is_active'=>'required|boolean']); $user->update($d); return back()->with('success','Data siswa diperbarui.'); }
    public function assignments(){ $assignments=TeacherAssignment::with(['teacher','school'])->latest()->paginate(20); $teachers=User::where('role','teacher')->where('is_active',true)->orderBy('name')->get(); $schools=School::where('status','active')->orderBy('name')->get(); return view('admin.assignments.index',compact('assignments','teachers','schools')); }
    public function storeAssignment(Request $r){ $d=$r->validate(['teacher_id'=>'required|exists:users,id','school_id'=>'required|exists:schools,id','grade_level'=>'required|integer|between:4,6']); abort_unless(User::whereKey($d['teacher_id'])->where('role','teacher')->exists(),422); $d['class_name']=null; TeacherAssignment::updateOrCreate(['teacher_id'=>$d['teacher_id'],'school_id'=>$d['school_id'],'grade_level'=>$d['grade_level']],$d); return back()->with('success','Penugasan guru disimpan.'); }
    public function destroyAssignment(TeacherAssignment $assignment){ $assignment->delete(); return back()->with('success','Penugasan dihapus.'); }
}
