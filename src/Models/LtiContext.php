<?php

namespace xcesaralejandro\lti1p3\Models;

use App\Models\LtiDeployment;
use App\Models\LtiResourceLink;
use App\Models\LtiUserRole;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\HasMany;
use MongoDB\Laravel\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use xcesaralejandro\lti1p3\Traits\CastModelOnSave;

class LtiContext extends Model
{
    use  SoftDeletes,CastModelOnSave;

    protected $table = 'lti1p3_contexts';
    protected $casts = [
        'label' => 'string',
        'title' => 'string',
        'type' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    protected $fillable = ['lti1p3_deployment_id','lti_id', 'label', 'title', 'type'];

    public function resourceLinks() : HasMany {
        return $this->hasMany(LtiResourceLink::class, 'lti1p3_context_id', 'id');
    }

    public function deployment() : BelongsTo {
        return $this->belongsTo(LtiDeployment::class, 'lti1p3_deployment_id', 'id');
    }

    public function roles() : HasMany {
        return $this->hasMany(LtiUserRole::class, 'lti1p3_context_id', 'id');
    }
}
