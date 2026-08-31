<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Models\ShippedOnOrder;
use App\Models\Document;
use App\Models\Batch;
use App\Models\User;
use App\Models\Deployment;
use App\Models\Complaint;
use App\Models\CadetBSRequirement;
use App\Models\CadetOnboardRequirement;

class Cadet extends Model
{
    // =========================================================
    // MASS ASSIGNMENT
    // =========================================================

    protected $fillable = [

        'user_id',

        'trb_control_number',

        'full_name',

        'course',

        'batch_id',

        'date_of_birth',

        'place_of_birth',

        'rank',

        'address',

        'contact_number',

        'email',

        'photo',

        'verification_status',

        'bs_status',

        'remarks',

        'is_off_semester',

        // Guardian information
        'parent_guardian_name',
        'relationship',
        'parent_guardian_contact',
        'parent_guardian_email',
        'parent_guardian_address',

        'remarks_month',

        'remarks_year',

        'remarks_updated_by',

        /*
        |--------------------------------------------------------------------------
        | LIVE LOCATION
        |--------------------------------------------------------------------------
        */

        'latitude',

        'longitude',

        'last_seen',

    ];


    // =========================================================
    // APPENDED ATTRIBUTES
    // =========================================================

    protected $appends = [

        'online_status',

    ];


    // =========================================================
    // CASTS
    // =========================================================

    protected $casts = [

        /*
        |--------------------------------------------------------------------------
        | LOCATION
        |--------------------------------------------------------------------------
        */

        'latitude' => 'float',

        'longitude' => 'float',

        /*
        |--------------------------------------------------------------------------
        | LAST SEEN
        |--------------------------------------------------------------------------
        */

        'last_seen' => 'datetime',

    ];


    // =========================================================
    // USER
    // =========================================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }


    // =========================================================
    // BATCH
    // =========================================================

    public function batch(): BelongsTo
    {
        return $this->belongsTo(
            Batch::class,
            'batch_id'
        );
    }


    // =========================================================
    // DEPLOYMENT
    // =========================================================
    //
    // Your current system uses ONE deployment relationship.
    //
    // IMPORTANT:
    // Use ->deployment, NOT ->deployments()
    //

    public function deployment(): HasOne
    {
        return $this->hasOne(
            Deployment::class,
            'cadet_id'
        );
    }


    // =========================================================
    // COMPLAINTS
    // =========================================================

    public function complaints(): HasMany
    {
        return $this->hasMany(
            Complaint::class
        );
    }


    // =========================================================
    // DOCUMENTS
    // =========================================================

    public function documents()
    {
        return $this->belongsToMany(
            Document::class,
            'cadet_documents'
        )
        ->withPivot([
            'status',
            'file_path',
            'remarks',
            'submitted_at',
        ])
        ->withTimestamps();
    }


    // =========================================================
    // ONBOARD REQUIREMENTS
    // =========================================================

    public function onboardRequirements()
    {
        return $this->hasMany(
            CadetOnboardRequirement::class
        );
    }


    public function onboardRequirementSubmissions()
    {
        return $this->hasMany(
            CadetOnboardRequirement::class
        );
    }


    // =========================================================
    // BS REQUIREMENTS
    // =========================================================

    public function bsRequirements()
    {
        return $this->hasMany(
            CadetBSRequirement::class
        );
    }


    // =========================================================
    // SHIPPED ON ORDER
    // =========================================================

    public function shippedOnOrder()
    {
        return $this->hasOne(
            ShippedOnOrder::class,
            'cadet_id'
        );
    }


    // =========================================================
    // ONLINE STATUS
    // =========================================================
    //
    // This is COMPUTED from last_seen.
    //
    // DO NOT save:
    //
    // $cadet->online_status = 'active';
    //
    // Instead update last_seen.
    //

    public function getOnlineStatusAttribute(): string
    {
        if (!$this->last_seen) {

            return 'Offline';

        }


        $diff =
            $this->last_seen->diffInMinutes(
                now()
            );


        if ($diff <= 2) {

            return 'Active';

        }


        if ($diff <= 5) {

            return 'Inactive';

        }


        if ($diff <= 30) {

            return 'Away';

        }


        return 'Offline';
    }


    // =========================================================
    // DEPLOYMENT PERCENTAGE
    // =========================================================

    public function getDeploymentPercentageAttribute()
    {
        if (!$this->deployment) {

            return 0;

        }


        return $this->deployment->percentage ?? 0;
    }


    // =========================================================
    // BS STATUS
    // =========================================================

    public function getBsStatusAttribute()
    {
        $totalBS =
            $this->bsRequirements()->count();


        $completedBS =
            $this->bsRequirements()
                ->whereIn(
                    'status',
                    [
                        'Approved',
                        'Completed',
                    ]
                )
                ->count();


        if ($totalBS === 0) {

            return 'Not Qualified';

        }


        if ($completedBS === $totalBS) {

            return 'Qualified';

        }


        return 'Not Qualified';
    }


    // =========================================================
    // COMPUTED VERIFICATION STATUS
    // =========================================================

    public function getComputedVerificationStatusAttribute()
    {
        $total =
            $this->documents()->count();


        $approved =
            $this->documents()
                ->wherePivot(
                    'status',
                    'Approved'
                )
                ->count();


        if ($total === 0) {

            return 'Pending';

        }


        if ($approved === $total) {

            return 'Complete';

        }


        if ($approved > 0) {

            return 'Incomplete';

        }


        return 'Pending';
    }


    // =========================================================
    // VERIFICATION STATUS LABEL
    // =========================================================

    public function getVerificationStatusLabelAttribute()
    {
        return ucfirst(
            $this->computed_verification_status
        );
    }
}