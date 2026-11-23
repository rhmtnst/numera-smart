<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\SchoolRegistrationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class SchoolCodeController extends Controller
{
 public function index(){ $codes=SchoolRegistrationCode::with('school')->latest()->paginate(20); $schools=School::where('status','active')->orderBy('name')->get(); return view('admin.codes.index',compact('codes','schools')); }
 public function store(Request $r){ $d=$r->validate(['school_id'=>'required|exists:schools,id','max_uses'=>'nullable|integer|min:1','expires_at'=>'nullable|date|after:now']); SchoolRegistrationCode::create($d+['code'=>Str::upper(Str::random(4)).'-'.Str::upper(Str::random(4)),'created_by'=>$r->user()->id,'is_active'=>true]); return back()->with('success','Kode pendaftaran dibuat.'); }
 public function toggle(SchoolRegistrationCode $code){ $code->update(['is_active'=>!$code->is_active]); return back()->with('success','Status kode diperbarui.'); }
 public function destroy(SchoolRegistrationCode $code){ $code->delete(); return back()->with('success','Kode dihapus.'); }
}
