<?php

namespace xcesaralejandro\lti1p3\Models;

use App\Models\LtiContext;
use App\Models\LtiPlatform;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use xcesaralejandro\lti1p3\Traits\CastModelOnSave;

class LtiDeployment extends Model
{
    use  SoftDeletes,CastModelOnSave;

    protected $table = 'lti1p3_deployments';
    protected $fillable = ['lti1p3_platform_id', 'lti_id', 'creation_method'];


    protected $casts = [
        'creation_method' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function platform() : BelongsTo {
        return $this->belongsTo(LtiPlatform::class, 'lti1p3_platform_id');
    }

    public function contexts() : HasMany {
        return $this->hasMany(LtiContext::class, 'id');
    }
}
