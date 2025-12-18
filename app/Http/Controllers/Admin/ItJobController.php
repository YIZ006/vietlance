<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItJob;
use App\Models\JobCategory;
use Illuminate\Http\Request;

class ItJobController extends Controller
{
    /**
     * Display a listing of IT jobs.
     */
    public function index(Request $request)
    {
        $query = ItJob::with('category');

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('job_title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('category_name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $jobs = $query->orderBy('job_id', 'desc')->paginate(10)->withQueryString();
        $categories = JobCategory::orderBy('category_name', 'asc')->get();

        // If AJAX request, return JSON
        if ($request->ajax() || $request->wantsJson() || $request->has('ajax')) {
            $html = view('admin.it-jobs.index', compact('jobs', 'categories'))->render();
            return response()->json([
                'html' => $html,
                'title' => 'Quản lý Công việc IT',
                'route' => 'it-jobs'
            ]);
        }

        return view('admin.it-jobs.index', compact('jobs', 'categories'));
    }

    /**
     * Show the form for creating a new IT job.
     */
    public function create()
    {
        $categories = JobCategory::orderBy('category_name', 'asc')->get();
        return view('admin.it-jobs.create', compact('categories'));
    }

    /**
     * Store a newly created IT job.
     */
    public function store(Request $request)
    {
        $request->validate([
            'job_title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:job_categories,category_id'],
            'short_description' => ['nullable', 'string'],
        ]);

        ItJob::create([
            'job_title' => $request->job_title,
            'category_id' => $request->category_id,
            'short_description' => $request->short_description,
        ]);

        return redirect()->route('admin.it-jobs.index')
            ->with('success', 'Tạo công việc IT thành công!');
    }

    /**
     * Show the form for editing the specified IT job.
     */
    public function edit($id)
    {
        $job = ItJob::findOrFail($id);
        $categories = JobCategory::orderBy('category_name', 'asc')->get();
        return view('admin.it-jobs.edit', compact('job', 'categories'));
    }

    /**
     * Update the specified IT job.
     */
    public function update(Request $request, $id)
    {
        $job = ItJob::findOrFail($id);

        $request->validate([
            'job_title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:job_categories,category_id'],
            'short_description' => ['nullable', 'string'],
        ]);

        $job->update([
            'job_title' => $request->job_title,
            'category_id' => $request->category_id,
            'short_description' => $request->short_description,
        ]);

        return redirect()->route('admin.it-jobs.index')
            ->with('success', 'Cập nhật công việc IT thành công!');
    }

    /**
     * Remove the specified IT job.
     */
    public function destroy($id)
    {
        $job = ItJob::findOrFail($id);
        $job->delete();

        return redirect()->route('admin.it-jobs.index')
            ->with('success', 'Xóa công việc IT thành công!');
    }

    /**
     * Remove multiple IT jobs.
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
            'ids.*' => ['required', 'integer', 'exists:it_jobs,job_id'],
        ]);

        $count = ItJob::whereIn('job_id', $ids)->delete();

        return redirect()->route('admin.it-jobs.index')
            ->with('success', "Đã xóa thành công {$count} công việc IT!");
    }
}

