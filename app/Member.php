<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    protected $guarded = [];

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     *
     * @return mixed
     */
    public static function new(string $firstName, string $lastName, string $email)
    {
        return static::create([
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'email'      => $email,
        ]);
    }

    /**
     * @return BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * @return string|null
     */
    public function getFullNameAttribute(): ?string
    {
        if ($this->first_name || $this->last_name) {
            return trim(implode(' ', [$this->first_name, $this->last_name]));
        }
        return null;
    }
}
