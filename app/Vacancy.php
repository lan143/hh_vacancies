<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Vacancy
 * @package App
 *
 * @property integer $id
 * @property integer $external_id
 * @property string $title
 * @property string $description
 * @property integer $city_id
 */
class Vacancy extends Model
{
    protected $table = 'vacancies';
}
