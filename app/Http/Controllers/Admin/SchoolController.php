<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class SchoolController extends Controller
{
    public function index(): View
    {
        return view('admin.schools.index', [
            'schools' => School::withCount('users')->orderBy('name')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.schools.create', ['school' => new School()]);
    }

    public function store(Request $request): RedirectResponse
    {
        School::create($this->validatedData($request));
        return redirect()->route('admin.schools.index')->with('success', 'Sekolah berhasil ditambahkan.');
    }

    public function edit(School $school): View
    {
        return view('admin.schools.edit', compact('school'));
    }

    public function update(Request $request, School $school): RedirectResponse
    {
        $school->update($this->validatedData($request, $school));
        return redirect()->route('admin.schools.index')->with('success', 'Data sekolah berhasil diperbarui.');
    }

    public function destroy(School $school): RedirectResponse
    {
        if ($school->users()->exists()) {
            return back()->withErrors(['school' => 'Sekolah tidak dapat dihapus karena masih memiliki pengguna. Nonaktifkan sekolah jika tidak digunakan.']);
        }

        $school->delete();
        return redirect()->route('admin.schools.index')->with('success', 'Sekolah berhasil dihapus.');
    }

    private function validatedData(Request $request, ?School $school = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'npsn' => ['nullable', 'string', 'max:20', Rule::unique('schools', 'npsn')->ignore($school?->id)],
            'address' => ['nullable', 'string', 'max:2000'],
            'city' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);
    }
}
