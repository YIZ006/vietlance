<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\Talent;
use App\Models\Client;
use App\Models\JobCategory;
use App\Models\ItJob;
use App\Models\ProgrammingLanguage;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SeedDataController extends Controller
{
    /**
     * Show seed data page.
     */
    public function index()
    {
        // Chỉ superadmin mới được truy cập
        $admin = auth()->guard('admin')->user();
        if ($admin->role !== 'superadmin') {
            abort(403, 'Chỉ Superadmin mới có quyền truy cập');
        }

        return view('admin.seed-data.index');
    }

    /**
     * Seed all data.
     */
    public function seedAll(Request $request)
    {
        $admin = auth()->guard('admin')->user();
        if ($admin->role !== 'superadmin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            DB::beginTransaction();

            // Seed Admins
            $this->seedAdmins();
            
            // Seed Talents
            $this->seedTalents();
            
            // Seed Clients
            $this->seedClients();
            
            // Seed Job Categories
            $this->seedJobCategories();
            
            // Seed IT Jobs
            $this->seedItJobs();
            
            // Seed Programming Languages
            $this->seedProgrammingLanguages();
            
            // Seed Profiles for some talents
            $this->seedProfiles();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đã tạo dữ liệu mẫu thành công cho tất cả các bảng!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Seed specific data type.
     */
    public function seedSpecific(Request $request)
    {
        $admin = auth()->guard('admin')->user();
        if ($admin->role !== 'superadmin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $type = $request->input('type');
        
        try {
            DB::beginTransaction();

            switch ($type) {
                case 'admins':
                    $this->seedAdmins();
                    break;
                case 'talents':
                    $this->seedTalents();
                    break;
                case 'clients':
                    $this->seedClients();
                    break;
                case 'job_categories':
                    $this->seedJobCategories();
                    break;
                case 'it_jobs':
                    $this->seedItJobs();
                    break;
                case 'programming_languages':
                    $this->seedProgrammingLanguages();
                    break;
                case 'profiles':
                    $this->seedProfiles();
                    break;
                default:
                    throw new \Exception('Loại dữ liệu không hợp lệ');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Đã tạo dữ liệu mẫu cho {$type} thành công!"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Seed Admins.
     */
    private function seedAdmins()
    {
        Artisan::call('db:seed', ['--class' => 'AdminSeeder']);
    }

    /**
     * Seed Talents.
     */
    private function seedTalents()
    {
        Artisan::call('db:seed', ['--class' => 'TalentSeeder']);
    }

    /**
     * Seed Clients.
     */
    private function seedClients()
    {
        Artisan::call('db:seed', ['--class' => 'ClientSeeder']);
    }

    /**
     * Seed Job Categories.
     */
    private function seedJobCategories()
    {
        Artisan::call('db:seed', ['--class' => 'JobCategorySeeder']);
    }

    /**
     * Seed IT Jobs.
     */
    private function seedItJobs()
    {
        Artisan::call('db:seed', ['--class' => 'ItJobSeeder']);
    }

    /**
     * Seed Programming Languages.
     */
    private function seedProgrammingLanguages()
    {
        Artisan::call('db:seed', ['--class' => 'ProgrammingLanguageSeeder']);
    }

    /**
     * Seed Profiles.
     */
    private function seedProfiles()
    {
        $talents = Talent::limit(3)->get();
        
        foreach ($talents as $index => $talent) {
            Profile::firstOrCreate(
                ['talent_id' => $talent->id],
                [
                    'talent_id' => $talent->id,
                    'profile_overview' => "Tôi là một developer chuyên nghiệp với nhiều năm kinh nghiệm trong lĩnh vực công nghệ thông tin. Tôi đam mê lập trình và luôn cập nhật những công nghệ mới nhất.",
                    'experience_level' => ['intermediate', 'expert', 'intermediate'][$index] ?? 'intermediate',
                    'hours_per_week' => 'More than 30 hrs/week',
                    'open_to_contract_to_hire' => true,
                    'visibility' => 'public',
                    'languages' => [
                        ['language' => 'Vietnamese', 'level' => 'Native or Bilingual'],
                        ['language' => 'English', 'level' => 'Fluent'],
                    ],
                    'skills' => [
                        'PHP', 'Laravel', 'JavaScript', 'Vue.js', 'MySQL'
                    ],
                    'id_verified' => false,
                    'military_veteran' => false,
                    'github_username' => 'github' . ($index + 1),
                    'stackoverflow_username' => 'stackoverflow' . ($index + 1),
                ]
            );
        }
    }
}

