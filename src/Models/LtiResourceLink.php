<?php

namespace xcesaralejandro\lti1p3\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;
use App\Models\LtiContext;
use Illuminate\Database\Eloquent\SoftDeletes;
use xcesaralejandro\lti1p3\Traits\CastModelOnSave;

class LtiResourceLink extends Model
{
    use  SoftDeletes,CastModelOnSave;

    protected $table = 'lti1p3_resource_links';

    protected $casts = [
        'description' => 'string',
        'title' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    protected $fillable = ['lti1p3_context_id', 'lti_id', 'description', 'title'];

    public function context() : BelongsTo {
        return $this->belongsTo(LtiContext::class, 'lti1p3_context_id');
    }

}
