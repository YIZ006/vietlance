<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgrammingLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            // 1. Ngôn ngữ lập trình chính
            ['name' => 'Python', 'category' => 'Ngôn ngữ lập trình chính', 'description' => null],
            ['name' => 'Java', 'category' => 'Ngôn ngữ lập trình chính', 'description' => null],
            ['name' => 'C#', 'category' => 'Ngôn ngữ lập trình chính', 'description' => null],
            ['name' => 'C++', 'category' => 'Ngôn ngữ lập trình chính', 'description' => null],
            ['name' => 'C', 'category' => 'Ngôn ngữ lập trình chính', 'description' => null],
            ['name' => 'PHP', 'category' => 'Ngôn ngữ lập trình chính', 'description' => null],
            ['name' => 'TypeScript', 'category' => 'Ngôn ngữ lập trình chính', 'description' => null],
            ['name' => 'Swift', 'category' => 'Ngôn ngữ lập trình chính', 'description' => null],
            ['name' => 'Kotlin', 'category' => 'Ngôn ngữ lập trình chính', 'description' => null],
            ['name' => 'Go (Golang)', 'category' => 'Ngôn ngữ lập trình chính', 'description' => null],
            ['name' => 'Ruby', 'category' => 'Ngôn ngữ lập trình chính', 'description' => null],
            ['name' => 'Dart (Flutter)', 'category' => 'Ngôn ngữ lập trình chính', 'description' => null],
            ['name' => 'SQL', 'category' => 'Ngôn ngữ lập trình chính', 'description' => null],
            ['name' => 'R', 'category' => 'Ngôn ngữ lập trình chính', 'description' => null],

            // 2. Web Development - Front-end
            ['name' => 'JavaScript', 'category' => 'Web Development - Front-end', 'description' => null],
            ['name' => 'HTML', 'category' => 'Web Development - Front-end', 'description' => null],
            ['name' => 'CSS', 'category' => 'Web Development - Front-end', 'description' => null],
            ['name' => 'SASS / SCSS', 'category' => 'Web Development - Front-end', 'description' => null],
            ['name' => 'React.js', 'category' => 'Web Development - Front-end', 'description' => null],
            ['name' => 'Angular', 'category' => 'Web Development - Front-end', 'description' => null],
            ['name' => 'Vue.js', 'category' => 'Web Development - Front-end', 'description' => null],
            ['name' => 'Svelte', 'category' => 'Web Development - Front-end', 'description' => null],
            ['name' => 'Next.js', 'category' => 'Web Development - Front-end', 'description' => null],
            ['name' => 'Nuxt.js', 'category' => 'Web Development - Front-end', 'description' => null],

            // 3. Web Development - Back-end
            ['name' => 'Node.js', 'category' => 'Web Development - Back-end', 'description' => null],
            ['name' => 'Perl', 'category' => 'Web Development - Back-end', 'description' => null],

            // 4. Mobile Development
            ['name' => 'Swift (iOS)', 'category' => 'Mobile Development', 'description' => null],
            ['name' => 'Kotlin (Android)', 'category' => 'Mobile Development', 'description' => null],
            ['name' => 'Java (Android)', 'category' => 'Mobile Development', 'description' => null],
            ['name' => 'React Native', 'category' => 'Mobile Development', 'description' => null],

            // 5. Game Development
            ['name' => 'C# (Unity)', 'category' => 'Game Development', 'description' => null],
            ['name' => 'C++ (Unreal Engine)', 'category' => 'Game Development', 'description' => null],
            ['name' => 'Lua', 'category' => 'Game Development', 'description' => null],
            ['name' => 'JavaScript (Web Game)', 'category' => 'Game Development', 'description' => null],
            ['name' => 'GDScript (Godot)', 'category' => 'Game Development', 'description' => null],

            // 6. AI / Machine Learning / Data
            ['name' => 'Julia', 'category' => 'AI / Machine Learning / Data', 'description' => null],
            ['name' => 'Scala', 'category' => 'AI / Machine Learning / Data', 'description' => null],
            ['name' => 'MATLAB', 'category' => 'AI / Machine Learning / Data', 'description' => null],
            ['name' => 'SAS', 'category' => 'AI / Machine Learning / Data', 'description' => null],

            // 7. Hệ thống – nhúng – hiệu năng cao
            ['name' => 'Rust', 'category' => 'Hệ thống – nhúng – hiệu năng cao', 'description' => null],
            ['name' => 'Assembly', 'category' => 'Hệ thống – nhúng – hiệu năng cao', 'description' => null],
            ['name' => 'Ada', 'category' => 'Hệ thống – nhúng – hiệu năng cao', 'description' => null],

            // 8. Cloud / DevOps
            ['name' => 'Bash', 'category' => 'Cloud / DevOps', 'description' => null],
            ['name' => 'PowerShell', 'category' => 'Cloud / DevOps', 'description' => null],

            // 9. Blockchain / Web3
            ['name' => 'Solidity', 'category' => 'Blockchain / Web3', 'description' => null],
            ['name' => 'Move (Aptos, Sui)', 'category' => 'Blockchain / Web3', 'description' => null],
            ['name' => 'Vyper', 'category' => 'Blockchain / Web3', 'description' => null],

            // 10. Ngôn ngữ lập trình cũ
            ['name' => 'COBOL', 'category' => 'Ngôn ngữ lập trình cũ', 'description' => null],
            ['name' => 'Fortran', 'category' => 'Ngôn ngữ lập trình cũ', 'description' => null],
            ['name' => 'Pascal', 'category' => 'Ngôn ngữ lập trình cũ', 'description' => null],
            ['name' => 'Delphi', 'category' => 'Ngôn ngữ lập trình cũ', 'description' => null],
            ['name' => 'Lisp', 'category' => 'Ngôn ngữ lập trình cũ', 'description' => null],
            ['name' => 'Prolog', 'category' => 'Ngôn ngữ lập trình cũ', 'description' => null],

            // 11. Ngôn ngữ mới nổi
            ['name' => 'Zig', 'category' => 'Ngôn ngữ mới nổi', 'description' => null],
            ['name' => 'Crystal', 'category' => 'Ngôn ngữ mới nổi', 'description' => null],
            ['name' => 'Elixir', 'category' => 'Ngôn ngữ mới nổi', 'description' => null],
            ['name' => 'Nim', 'category' => 'Ngôn ngữ mới nổi', 'description' => null],
        ];

        foreach ($languages as $language) {
            DB::table('programming_languages')->insertOrIgnore([
                'name' => $language['name'],
                'category' => $language['category'],
                'description' => $language['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

