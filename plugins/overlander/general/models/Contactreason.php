<?php namespace Overlander\General\Models;

use Model;
use HasMany;
/**
 * Model
 */
class Contactreason extends Model
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
    public $table = 'overlander_general_contactreason';

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'reason' => 'required',
    ];

    public function Contact(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
