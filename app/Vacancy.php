<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Vacancy
 * @package App
 *
 * @property integer $id
 * @property integer $external_id
 * @property string $title
 * @property string $description
 * @property integer $city_id
 *
 * @property-read City $city
 */
class Vacancy extends Model
{
    protected $table = 'vacancies';

    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
