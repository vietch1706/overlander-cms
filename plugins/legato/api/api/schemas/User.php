<?php namespace Legato\Api\Api\Schemas;

use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 * @Schema();
 */
class User
{
    /**
     * @Property(ref="#/components/schemas/IntegerField"),
     */
    public $id;

    /**
     * @Property(type="string", example="Jackie")
     */
    public $first_name;

    /**
     * @Property(type="string", example="Chan")
     */
    public $last_name;
}
