<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Talent;
use App\Models\Profile;
use Illuminate\Http\Request;

class TalentController extends Controller
{
    /**
     * Display a listing of talents.
     */
    public function index(Request $request)
    {
        $query = Talent::query();

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status == 'active' ? 1 : 0);
        }

        $talents = $query->with('profile')->orderBy('id', 'desc')->paginate(10)->withQueryString();

        // If AJAX request, return JSON
        if ($request->ajax() || $request->wantsJson() || $request->has('ajax')) {
            $html = view('admin.talents.index', compact('talents'))->render();
            return response()->json([
                'html' => $html,
                'title' => 'Quản lý Talent',
                'route' => 'talents'
            ]);
        }

        return view('admin.talents.index', compact('talents'));
    }

    /**
     * Show the form for creating a new talent.
     */
    public function create()
    {
        return view('admin.talents.create');
    }

    /**
     * Store a newly created talent.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:talent,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'hourly_rate' => ['nullable', 'numeric', 'min:0'],
            'experience_years' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Talent::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'hourly_rate' => $request->hourly_rate,
            'experience_years' => $request->experience_years,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.talents.index')
            ->with('success', 'Tạo talent thành công!');
    }

    /**
     * Show the form for editing the specified talent.
     */
    public function edit($id)
    {
        $talent = Talent::findOrFail($id);
        return view('admin.talents.edit', compact('talent'));
    }

    /**
     * Update the specified talent.
     */
    public function update(Request $request, $id)
    {
        $talent = Talent::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:talent,email,' . $id],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'hourly_rate' => ['nullable', 'numeric', 'min:0'],
            'experience_years' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'hourly_rate' => $request->hourly_rate,
            'experience_years' => $request->experience_years,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $talent->update($data);

        return redirect()->route('admin.talents.index')
            ->with('success', 'Cập nhật talent thành công!');
    }

    /**
     * Remove the specified talent.
     */
    public function destroy($id)
    {
        $talent = Talent::findOrFail($id);
        $talent->delete();

        return redirect()->route('admin.talents.index')
            ->with('success', 'Xóa talent thành công!');
    }

    /**
     * Remove multiple talents.
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
            'ids.*' => ['required', 'integer', 'exists:talent,id'],
        ]);

        $count = Talent::whereIn('id', $ids)->delete();

        return redirect()->route('admin.talents.index')
            ->with('success', "Đã xóa thành công {$count} talent!");
    }

    /**
     * Get profile data for a talent.
     */
    public function getProfile($id)
    {
        $talent = Talent::with('profile')->findOrFail($id);
        
        return response()->json([
            'talent' => $talent,
            'profile' => $talent->profile,
        ]);
    }
}




