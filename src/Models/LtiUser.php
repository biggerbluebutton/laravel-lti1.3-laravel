<?php

namespace xcesaralejandro\lti1p3\Models;

use App\Models\LtiPlatform;
use App\Models\LtiUserRole;
use MongoDB\Laravel\Auth\User as Authenticatable;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use xcesaralejandro\lti1p3\Traits\CastModelOnSave;
use xcesaralejandro\lti1p3\Traits\LtiRolesManager;

class LtiUser extends Authenticatable
{
    use LtiRolesManager, SoftDeletes,CastModelOnSave;

    protected $table = 'lti1p3_users';
    protected $fillable = ['lti1p3_platform_id','lti_id', 'name', 'given_name', 'family_name',
    'email', 'picture', 'person_sourceid', 'creation_method'];
    protected $hidden = ['remember_token'];

    protected $casts = [
        'lti_id' => 'string',
        'name' => 'string',
        'given_name' => 'string',
        'family_name' => 'string',
        'email' => 'string',
        'picture' => 'string',
        'person_sourceid' => 'string',
        'remember_token' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function platform() : BelongsTo {
        return $this->belongsTo(LtiPlatform::class, 'lti1p3_platform_id');
    }

    public function roles() : HasMany {
        return $this->hasMany(LtiUserRole::class, 'lti1p3_user_id', 'id');
    }

}
