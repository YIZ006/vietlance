<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'talent_id',
        'profile_overview',
        'experience_level',
        'hours_per_week',
        'open_to_contract_to_hire',
        'visibility',
        'project_preference',
        'earnings_privacy',
        'video_introduction_url',
        'languages',
        'id_verified',
        'military_veteran',
        'work_history',
        'skills',
        'primary_category',
        'sub_categories',
        'specialized_profiles',
        'published_profiles_count',
        'github_username',
        'stackoverflow_username',
        'linkedin_url',
        'portfolio_url',
        'certifications',
        'employment_history',
        'other_experiences',
        'education',
        'licenses',
        'project_catalog',
        'testimonials',
        'ai_data_training_opt_in',
    ];

    protected $casts = [
        'languages' => 'array',
        'work_history' => 'array',
        'skills' => 'array',
        'sub_categories' => 'array',
        'specialized_profiles' => 'array',
        'certifications' => 'array',
        'employment_history' => 'array',
        'other_experiences' => 'array',
        'education' => 'array',
        'licenses' => 'array',
        'project_catalog' => 'array',
        'testimonials' => 'array',
        'open_to_contract_to_hire' => 'boolean',
        'earnings_privacy' => 'boolean',
        'id_verified' => 'boolean',
        'military_veteran' => 'boolean',
        'ai_data_training_opt_in' => 'boolean',
    ];

    /**
     * Get the talent that owns the profile.
     */
    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }
}

