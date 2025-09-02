<?php

namespace xcesaralejandro\lti1p3\Models;

use App\Models\LtiContext;
use App\Models\LtiDeployment;
use App\Models\LtiUser;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\HasMany;
use GuzzleHttp\Client;
use \Firebase\JWT\JWK;
use Illuminate\Database\Eloquent\SoftDeletes;
use xcesaralejandro\lti1p3\Traits\CastModelOnSave;

class LtiPlatform extends Model
{
    use  SoftDeletes,CastModelOnSave;

    protected $table = 'lti1p3_platforms';

    protected $fillable = ['issuer_id', 'client_id', 'authorization_url', 'authentication_url',
    'json_webkey_url','signature_method', 'deployment_id_autoregister', 'local_name', 'version',
    'product_family_code', 'guid', 'name', 'lti_advantage_token_url'];
    protected $casts = [
        'deployment_id_autoregister' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function users() : HasMany {
        return $this->hasMany(LtiUser::class, 'lti1p3_platform_id', 'id');
    }

    public function contexts() : HasMany {
        return $this->hasMany(LtiUserContext::class, 'lti1p3_platform_id', 'id');
    }

    public function nonces() : HasMany {
        return $this->hasMany(LtiNonce::class, 'lti1p3_platform_id', 'id');
    }

    public function deployments() : HasMany {
        return $this->hasMany(LtiDeployment::class, 'lti1p3_platform_id', 'id')->orderBy('id', 'desc');
    }

    public function getPublicJwk() : array {
        $client = new Client();
        $verify_https = config('lti1p3.VERIFY_HTTPS_CERTIFICATE');
        $response = $client->get($this->json_webkey_url, ['verify' => $verify_https]);
        $public_jwks = json_decode($response->getBody()->getContents(), true);
        $keys = JWK::parseKeySet($public_jwks);
        return $keys;
    }

    public function wasLaunched() : bool {
        return !empty($this->guid);
    }
}
