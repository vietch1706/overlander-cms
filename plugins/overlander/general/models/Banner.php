<?php

namespace Overlander\General\Models;

use Model;

/**
 * Model
 */
class Banner extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var bool timestamps are disabled.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_general_banner';

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'name' => 'required',
        'image' => 'required',
        'published_at' => 'required|before:expired_at',
        'expired_at' => 'required|after:tomorrow',
    ];
    public $customMessages = [
        'published_at.before' => 'The publish date must before the expired date.',
        'expired_at.before' => 'The expired date must be one day later',
    ];

    public function scopeGetById($query, $id)
    {
        return $query->where('id', $id);
    }
}
