<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Talent;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        // Thống kê tổng quan
        $stats = [
            'total_talents' => Talent::count(),
            'total_clients' => Client::count(),
            'active_talents' => Talent::where('is_active', true)->count(),
            'active_clients' => Client::where('is_active', true)->count(),
        ];

        // Dữ liệu cho biểu đồ
        $chartData = [
            'talents' => $stats['total_talents'],
            'clients' => $stats['total_clients'],
            'active_talents' => $stats['active_talents'],
            'active_clients' => $stats['active_clients'],
        ];

        // Nếu là AJAX request, trả về JSON với HTML content
        if ($request->ajax() || $request->wantsJson() || $request->has('ajax')) {
            $html = view('admin.dashboard.index', compact('admin', 'stats', 'chartData'))->render();
            return response()->json([
                'html' => $html,
                'title' => 'Trang quản trị',
                'route' => 'dashboard'
            ]);
        }

        return view('admin.dashboard.index', compact('admin', 'stats', 'chartData'));
    }

    /**
     * Show policies page.
     */
    public function policies(Request $request)
    {
        // Nếu là AJAX request, trả về JSON với HTML content
        if ($request->ajax() || $request->wantsJson() || $request->has('ajax')) {
            $html = view('admin.policies.index')->render();
            return response()->json([
                'html' => $html,
                'title' => 'Chính sách',
                'route' => 'policies'
            ]);
        }

        return view('admin.policies.index');
    }

    /**
     * Show contact page.
     */
    public function contact(Request $request)
    {
        // Nếu là AJAX request, trả về JSON với HTML content
        if ($request->ajax() || $request->wantsJson() || $request->has('ajax')) {
            $html = view('admin.contact.index')->render();
            return response()->json([
                'html' => $html,
                'title' => 'Liên hệ',
                'route' => 'contact'
            ]);
        }

        return view('admin.contact.index');
    }
}

