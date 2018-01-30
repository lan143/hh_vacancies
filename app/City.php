<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class City
 * @package App
 *
 * @property integer $id
 * @property string $name
 */
class City extends Model
{
    protected $table = 'cities';
}
