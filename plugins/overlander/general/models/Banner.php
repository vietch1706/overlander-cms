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
        'link' => 'required',
        'published_at' => 'required',
        'expired_at' => 'required',
    ];
}
