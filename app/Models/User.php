<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'avatar'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the job listings created by the user.
     *
     * @return HasMany
     */
    public function jobListing(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Get the jobs bookmarked by the user.
     *
     * @return BelongsToMany
     */
    public function bookmarkedJobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'job_user_bookmarks')->withTimestamps();
    }

    /**
     * Get the applications submitted by the user.
     *
     * @return HasMany
     */
    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class, 'user_id');
    }
}
