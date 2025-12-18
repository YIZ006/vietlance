<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Freelance;
use Illuminate\Http\Request;

class FreelanceController extends Controller
{
    /**
     * Display a listing of freelances.
     */
    public function index(Request $request)
    {
        $query = Freelance::query();

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('skills', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status == 'active' ? 1 : 0);
        }

        $freelances = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        // If AJAX request, return JSON
        if ($request->ajax() || $request->wantsJson()) {
            $html = view('admin.freelances.index', compact('freelances'))->render();
            return response()->json([
                'html' => $html,
                'title' => 'Quản lý Freelancer',
                'route' => 'freelances'
            ]);
        }

        return view('admin.freelances.index', compact('freelances'));
    }

    /**
     * Show the form for creating a new freelance.
     */
    public function create()
    {
        return view('admin.freelances.create');
    }

    /**
     * Store a newly created freelance.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:freelance,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'bio' => ['nullable', 'string'],
            'skills' => ['nullable', 'string', 'max:500'],
            'hourly_rate' => ['nullable', 'numeric', 'min:0'],
            'experience_years' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Freelance::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'bio' => $request->bio,
            'skills' => $request->skills,
            'hourly_rate' => $request->hourly_rate,
            'experience_years' => $request->experience_years,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.freelances.index')
            ->with('success', 'Tạo freelancer thành công!');
    }

    /**
     * Show the form for editing the specified freelance.
     */
    public function edit($id)
    {
        $freelance = Freelance::findOrFail($id);
        return view('admin.freelances.edit', compact('freelance'));
    }

    /**
     * Update the specified freelance.
     */
    public function update(Request $request, $id)
    {
        $freelance = Freelance::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:freelance,email,' . $id],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'bio' => ['nullable', 'string'],
            'skills' => ['nullable', 'string', 'max:500'],
            'hourly_rate' => ['nullable', 'numeric', 'min:0'],
            'experience_years' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'bio' => $request->bio,
            'skills' => $request->skills,
            'hourly_rate' => $request->hourly_rate,
            'experience_years' => $request->experience_years,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $freelance->update($data);

        return redirect()->route('admin.freelances.index')
            ->with('success', 'Cập nhật freelancer thành công!');
    }

    /**
     * Remove the specified freelance.
     */
    public function destroy($id)
    {
        $freelance = Freelance::findOrFail($id);
        $freelance->delete();

        return redirect()->route('admin.freelances.index')
            ->with('success', 'Xóa freelancer thành công!');
    }

    /**
     * Remove multiple freelances.
     */
    public function destroyMultiple(Request $request)
    {
        $ids = $request->ids;
        
        // If ids is a JSON string, decode it
        if (is_string($ids)) {
            $ids = json_decode($ids, true);
        }

        $request->merge(['ids' => $ids]);

        $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['required', 'integer', 'exists:freelance,id'],
        ]);

        $count = Freelance::whereIn('id', $ids)->delete();

        return redirect()->route('admin.freelances.index')
            ->with('success', "Đã xóa thành công {$count} freelancer!");
    }
}

