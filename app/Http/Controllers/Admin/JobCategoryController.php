<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use Illuminate\Http\Request;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of job categories.
     */
    public function index(Request $request)
    {
        $query = JobCategory::withCount('jobs');

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('category_name', 'like', "%{$search}%");
        }

        $categories = $query->orderBy('category_id', 'asc')->get();

        // If AJAX request, return JSON
        if ($request->ajax() || $request->wantsJson() || $request->has('ajax')) {
            $html = view('admin.job-categories.index', compact('categories'))->render();
            return response()->json([
                'html' => $html,
                'title' => 'Quản lý Danh mục Công việc',
                'route' => 'job-categories'
            ]);
        }

        return view('admin.job-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new job category.
     */
    public function create()
    {
        return view('admin.job-categories.create');
    }

    /**
     * Store a newly created job category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => ['required', 'string', 'max:200', 'unique:job_categories,category_name'],
        ]);

        JobCategory::create([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('admin.job-categories.index')
            ->with('success', 'Tạo danh mục công việc thành công!');
    }

    /**
     * Show the form for editing the specified job category.
     */
    public function edit($id)
    {
        $category = JobCategory::findOrFail($id);
        return view('admin.job-categories.edit', compact('category'));
    }

    /**
     * Update the specified job category.
     */
    public function update(Request $request, $id)
    {
        $category = JobCategory::findOrFail($id);

        $request->validate([
            'category_name' => ['required', 'string', 'max:200', 'unique:job_categories,category_name,' . $id . ',category_id'],
        ]);

        $category->update([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('admin.job-categories.index')
            ->with('success', 'Cập nhật danh mục công việc thành công!');
    }

    /**
     * Remove the specified job category.
     */
    public function destroy($id)
    {
        $category = JobCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.job-categories.index')
            ->with('success', 'Xóa danh mục công việc thành công!');
    }

    /**
     * Remove multiple job categories.
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
            'ids.*' => ['required', 'integer', 'exists:job_categories,category_id'],
        ]);

        $count = JobCategory::whereIn('category_id', $ids)->delete();

        return redirect()->route('admin.job-categories.index')
            ->with('success', "Đã xóa thành công {$count} danh mục công việc!");
    }
}

