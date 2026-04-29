<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Applicant extends Model
{
    //

    protected $fillable = [
        'job_id',
        'user_id',
        'full_name',
        'contact_email',
        'contact_phone',
        'message',
        'location',
        'resume_path',
    ];

    /**
     * Get the job listing this application belongs to.
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * Get the user who submitted the application.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
