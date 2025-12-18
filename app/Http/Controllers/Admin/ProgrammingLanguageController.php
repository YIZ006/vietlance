<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgrammingLanguage;
use Illuminate\Http\Request;

class ProgrammingLanguageController extends Controller
{
    /**
     * Display a listing of programming languages.
     */
    public function index(Request $request)
    {
        $query = ProgrammingLanguage::query();

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Group by category
        $languages = $query->orderBy('category', 'asc')
                          ->orderBy('name', 'asc')
                          ->get()
                          ->groupBy('category');

        // Get unique categories for filter
        $categories = ProgrammingLanguage::select('category')
                                       ->distinct()
                                       ->orderBy('category', 'asc')
                                       ->pluck('category');

        // If AJAX request, return JSON
        if ($request->ajax() || $request->wantsJson() || $request->has('ajax')) {
            $html = view('admin.programming-languages.index', compact('languages', 'categories'))->render();
            return response()->json([
                'html' => $html,
                'title' => 'Ngôn ngữ Lập trình',
                'route' => 'programming-languages'
            ]);
        }

        return view('admin.programming-languages.index', compact('languages', 'categories'));
    }
}

