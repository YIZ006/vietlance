<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminAccountController extends Controller
{
    /**
     * Display a listing of admin accounts.
     */
    public function index(Request $request)
    {
        $currentAdmin = Auth::guard('admin')->user();
        $isSuperAdmin = $currentAdmin->isSuperAdmin();

        // Tách query theo role
        $superadminsQuery = Admin::where('role', 'superadmin');
        $adminsQuery = Admin::where('role', 'admin');
        $viewersQuery = Admin::where('role', 'viewer');

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $searchCallback = function($q) use ($search) {
                $q->where(function($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%")
                          ->orWhere('admin_login', 'like', "%{$search}%")
                          ->orWhere('phone', 'like', "%{$search}%");
                });
            };
            
            $superadminsQuery->where($searchCallback);
            $adminsQuery->where($searchCallback);
            $viewersQuery->where($searchCallback);
        }

        // Get all without pagination (vì đã tách theo role)
        $superadmins = $superadminsQuery->orderBy('id', 'desc')->get();
        $admins = $adminsQuery->orderBy('id', 'desc')->get();
        $viewers = $viewersQuery->orderBy('id', 'desc')->get();

        // If AJAX request, return JSON
        if ($request->ajax() || $request->wantsJson() || $request->has('ajax')) {
            $html = view('admin.accounts.index', compact('superadmins', 'admins', 'viewers', 'isSuperAdmin', 'currentAdmin'))->render();
            return response()->json([
                'html' => $html,
                'title' => 'Quản lý tài khoản quản trị',
                'route' => 'admins'
            ]);
        }

        return view('admin.accounts.index', compact('superadmins', 'admins', 'viewers', 'isSuperAdmin', 'currentAdmin'));
    }

    /**
     * Show the form for creating a new admin account.
     */
    public function create()
    {
        $currentAdmin = Auth::guard('admin')->user();
        
        // Superadmin có thể tạo tất cả, Admin chỉ có thể tạo viewer
        if (!$currentAdmin->isSuperAdmin() && !$currentAdmin->isAdmin()) {
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Bạn không có quyền tạo tài khoản.');
        }

        $isSuperAdmin = $currentAdmin->isSuperAdmin();
        return view('admin.accounts.create', compact('currentAdmin', 'isSuperAdmin'));
    }

    /**
     * Store a newly created admin account.
     */
    public function store(Request $request)
    {
        $currentAdmin = Auth::guard('admin')->user();
        
        // Superadmin có thể tạo tất cả, Admin chỉ có thể tạo viewer
        if (!$currentAdmin->isSuperAdmin() && !$currentAdmin->isAdmin()) {
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Bạn không có quyền tạo tài khoản.');
        }

        $validRoles = ['viewer']; // Admin chỉ có thể tạo viewer
        if ($currentAdmin->isSuperAdmin()) {
            $validRoles = ['admin', 'viewer', 'superadmin']; // Superadmin có thể tạo tất cả
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'admin_login' => ['required', 'string', 'max:255', 'unique:admin,admin_login'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admin,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'role' => ['required', 'in:' . implode(',', $validRoles)],
        ]);

        Admin::create([
            'name' => $request->name,
            'admin_login' => $request->admin_login,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
            'status' => 'active',
        ]);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Tạo tài khoản admin thành công!');
    }

    /**
     * Show the form for editing the specified admin account.
     */
    public function edit($id)
    {
        $currentAdmin = Auth::guard('admin')->user();
        $admin = Admin::findOrFail($id);

        // Superadmin can edit anyone, admin can only edit themselves
        if (!$currentAdmin->isSuperAdmin() && $currentAdmin->id != $admin->id) {
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Bạn không có quyền sửa tài khoản này.');
        }

        return view('admin.accounts.edit', compact('admin', 'currentAdmin'));
    }

    /**
     * Update the specified admin account.
     */
    public function update(Request $request, $id)
    {
        $currentAdmin = Auth::guard('admin')->user();
        $admin = Admin::findOrFail($id);

        // Superadmin can edit anyone, admin can only edit themselves
        if (!$currentAdmin->isSuperAdmin() && $currentAdmin->id != $admin->id) {
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Bạn không có quyền sửa tài khoản này.');
        }

        $validRoles = ['admin', 'viewer'];
        if ($currentAdmin->isSuperAdmin()) {
            $validRoles[] = 'superadmin';
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'admin_login' => ['required', 'string', 'max:255', 'unique:admin,admin_login,' . $id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admin,email,' . $id],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'role' => ['required', 'in:' . implode(',', $validRoles)],
        ]);

        $data = [
            'name' => $request->name,
            'admin_login' => $request->admin_login,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Cập nhật tài khoản admin thành công!');
    }

    /**
     * Remove the specified admin account.
     */
    public function destroy($id)
    {
        $currentAdmin = Auth::guard('admin')->user();
        $admin = Admin::findOrFail($id);

        // Only superadmin can delete
        if (!$currentAdmin->isSuperAdmin()) {
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Chỉ Superadmin mới có quyền xóa tài khoản admin.');
        }

        // Cannot delete yourself
        if ($currentAdmin->id == $admin->id) {
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Không thể xóa tài khoản của chính bạn.');
        }

        // Cannot delete superadmin
        if ($admin->role === 'superadmin') {
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Không thể xóa tài khoản Superadmin.');
        }

        $admin->delete();

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Xóa tài khoản admin thành công!');
    }

    /**
     * Toggle lock status of admin account.
     */
    public function toggleLock(Request $request, $id)
    {
        $currentAdmin = Auth::guard('admin')->user();
        $admin = Admin::findOrFail($id);

        // Superadmin và Admin có thể khóa/mở khóa
        if (!$currentAdmin->isSuperAdmin() && !$currentAdmin->isAdmin()) {
            if ($request->ajax() || $request->wantsJson() || $request->has('ajax')) {
                return response()->json(['error' => 'Bạn không có quyền khóa/mở khóa tài khoản.'], 403);
            }
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Bạn không có quyền khóa/mở khóa tài khoản.');
        }

        // Cannot lock yourself
        if ($currentAdmin->id == $admin->id) {
            if ($request->ajax() || $request->wantsJson() || $request->has('ajax')) {
                return response()->json(['error' => 'Không thể khóa tài khoản của chính bạn.'], 403);
            }
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Không thể khóa tài khoản của chính bạn.');
        }

        // Admin chỉ có thể khóa viewer, không thể khóa admin hoặc superadmin
        if ($currentAdmin->isAdmin() && $admin->role !== 'viewer') {
            if ($request->ajax() || $request->wantsJson() || $request->has('ajax')) {
                return response()->json(['error' => 'Bạn chỉ có thể khóa tài khoản Viewer.'], 403);
            }
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Bạn chỉ có thể khóa tài khoản Viewer.');
        }

        // Cannot lock superadmin (chỉ superadmin mới có thể khóa superadmin, nhưng không nên)
        if ($admin->role === 'superadmin' && !$currentAdmin->isSuperAdmin()) {
            if ($request->ajax() || $request->wantsJson() || $request->has('ajax')) {
                return response()->json(['error' => 'Không thể khóa tài khoản Superadmin.'], 403);
            }
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Không thể khóa tài khoản Superadmin.');
        }

        // Toggle status: active <-> locked
        // Nếu đang locked thì mở khóa (active), còn lại thì khóa (locked)
        if ($admin->status === 'locked') {
            $newStatus = 'active';
            $statusText = 'mở khóa';
        } else {
            $newStatus = 'locked';
            $statusText = 'khóa';
        }
        
        $admin->update([
            'status' => $newStatus
        ]);
        
        if ($request->ajax() || $request->wantsJson() || $request->has('ajax')) {
            return response()->json([
                'success' => true,
                'message' => "Đã {$statusText} tài khoản admin thành công!",
                'status' => $admin->status
            ]);
        }
        
        return redirect()->route('admin.accounts.index')
            ->with('success', "Đã {$statusText} tài khoản admin thành công!");
    }
}

