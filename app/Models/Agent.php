<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Agent extends Model
{
    use HasFactory;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false; // Nonaktifkan auto-increment

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string'; // Gunakan string sebagai tipe kunci

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) hexdec(uniqid());  // Set UUID saat membuat model baru
            }
        });
    }


    /**
     * Set the primary key type to UUID.
     */
    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    protected $casts = [
        "social_media_links" => "json",
        'joined_date' => 'date',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
