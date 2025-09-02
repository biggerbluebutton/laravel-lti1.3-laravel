<?php

namespace xcesaralejandro\lti1p3\Models;

use App\Models\LtiContext;
use App\Models\LtiUser;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use xcesaralejandro\lti1p3\Traits\CastModelOnSave;

class LtiUserRole extends Model
{
    use SoftDeletes,CastModelOnSave;

    protected $table = 'lti1p3_user_roles';

    protected $fillable = ['lti1p3_context_id', 'lti1p3_user_id','name'];
    protected $casts = [
        'name' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function context() : BelongsTo {
        return $this->belongsTo(LtiContext::class, 'lti1p3_context_id');
    }

    public function user () : BelongsTo {
        return $this->belongsTo(LtiUser::class, 'lti1p3_user_id');
    }
}
