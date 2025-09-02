<?php

namespace xcesaralejandro\lti1p3\Models;

use App\Models\LtiPlatform;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;
use xcesaralejandro\lti1p3\Traits\CastModelOnSave;

class LtiNonce extends Model
{
    use CastModelOnSave;
    protected $table = 'lti1p3_nonces';
    protected $fillable = ['value', 'lti1p3_platform_id'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot(){
        parent::boot();
        static::creating(function($model) {
            do {
                $uuid = Uuid::uuid4()->toString();
            } while (self::where('id', $uuid)->exists());
            $model->id = $uuid;
        });
    }


    public function platform() : BelongsTo {
        return $this->belongsTo(LtiPlatform::class, 'lti1p3_platform_id');
    }

    public function assertMatchWith(string $nonce) : Void {
        if($nonce != $this->id){
            $message = "The nonce does not match the nonce of the lti content";
            throw new \Exception($message);
        }
    }
}
