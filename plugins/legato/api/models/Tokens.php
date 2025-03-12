<?php namespace Legato\Api\Models;

use Illuminate\Support\Carbon;
use Backend\Models\User;
use October\Rain\Database\Model;
use October\Rain\Database\Traits\Validation;

/**
 * tokens Model
 */
class Tokens extends Model
{
    use Validation;

    public const ORDER_TYPE_LAST_ACTIVE = 'last_active';
    public const ORDER_TYPE_CREATED_AT = 'created_at';

    /**
     * @var string The database table used by the model.
     */
    public $table = 'legato_users_tokens';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'last_active',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = ['user' => User::class];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function beforeSave(): void
    {
        $this->last_active = Carbon::now();
    }

    /**
     * @param $query
     * @param int $userId
     * @return mixed
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * @param $query
     * @param string $token
     * @return mixed
     */
    public function scopeToken($query, string $token)
    {
        return $query->where('token', $token);
    }
}
