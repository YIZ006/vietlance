<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItJob extends Model
{
    use HasFactory;

    protected $table = 'it_jobs';
    protected $primaryKey = 'job_id';

    protected $fillable = [
        'job_title',
        'category_id',
        'short_description',
    ];

    /**
     * Get the category that owns the job.
     */
    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'category_id', 'category_id');
    }
}

