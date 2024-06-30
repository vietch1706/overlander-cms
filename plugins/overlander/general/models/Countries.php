<?php namespace Overlander\General\Models;

use Model;
use October\Rain\Database\Traits\Validation;

/**
 * Model
 */
class Countries extends Model
{
    use Validation;

    /**
     * @var bool timestamps are disabled.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_general_countries';

    /**
     * @var array rules for validation.
     */
    public $rules = [
    ];
    
    public function scopeGetById($query, $id)
    {
        return $query->where('id', $id);
    }
}
