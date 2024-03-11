<?php

namespace App\Http\Traits;

trait Encryptable
{
    public function initializeEncryptable()
    {
        $this->append('encr_id');
    }

    public function getEncrIdAttribute()
    {
        return encrypt($this->getKey());
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        // If $field is not null
        // means route model's param is binded by another column
        if (!is_null($field)) {
            return (!is_int($value) && strlen($value) > 150)
                ? $this->where($field, decrypt($value)->firstOrFail())
                : $this->where($field, $value)->firstOrFail();
        } else {
            // If $value is not an integer then it's encrypted
            // so we will decrypt it first and then find the model
            // by id column
            // If $value is an integer then it's not encrypted
            // so we will find the model by id column directly
            return (!is_int($value) && strlen($value) > 150)
                ? $this->findOrFail(decrypt($value))
                : $this->findOrFail($value);
        }
    }
}
