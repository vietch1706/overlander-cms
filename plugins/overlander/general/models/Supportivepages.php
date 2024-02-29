<?php

namespace Overlander\General\Models;

use Model;

/**
 * Model
 */
class Supportivepages extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string table in the database used by the model.
     */
    public $table = 'overlander_general_supportivepages';

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'title' => 'required',
        'contents' => 'required',

    ];
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;

    public function getStatusOptions()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }
    public function scopeGetBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
    public function scopeGetById($query, $id)
    {
        return $query->where('id', $id);
    }
}
