<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;

    protected $table = 'job_categories';
    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_name',
    ];

    /**
     * Get the jobs for the category.
     */
    public function jobs()
    {
        return $this->hasMany(ItJob::class, 'category_id', 'category_id');
    }
}

