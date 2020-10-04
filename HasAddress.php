<?php


namespace NRB\Address;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasAddress
{
    
    /**
     *
     */
    public static function bootHasAddress()
    {
        static::deleting(function (Model $model) {
            
            if (in_array(SoftDeletes::class, class_uses_recursive($model))) {
                if (!$model->forceDeleting) {
                    return;
                }
            }
            
            $model->address()->cursor()->each(fn(Address $media) => $media->delete());
        });
    }
    
    /**
     * @return bool
     */
    public function hasAddress(): bool
    {
        return $this->address->count() ? TRUE : FALSE;
    }
    
    /**
     * @param array $attributes
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function addAddress(array $attributes)
    {
        $this->validateAddressAttributes($attributes);
        return $this->address()->create($attributes);
    }
    
    /**
     * @param array $attributes
     *
     * @return bool
     */
    protected function validateAddressAttributes(array $attributes)
    {
        $required = $this->requiredAddressAttributes();
        $diff = array_diff($required, array_keys($attributes));
        
        if (!$diff) {
            return TRUE;
        }
        
        return array_fill_keys($diff, 'This attribute is required');
    }
    
    /**
     * @return string[]
     */
    protected function requiredAddressAttributes()
    {
        return [
            'line1',
        ];
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function address(): MorphMany
    {
        return $this->morphMany(config('addresses.model'), 'model');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAddresses(): Collection
    {
        return $this->address;
    }
    
    /**
     * @return mixed
     */
    public function getPrimaryAddressAttribute(): Address
    {
        if (!$this->address->count()) {
            return new Address();
        }
        
        if ($primary = $this->address->where('primary', TRUE)->first()) {
            return $primary;
        }
        
        return $this->address->first();
    }
    
    /**
     * @param $attributes
     *
     * @return mixed
     */
    public function updatePrimaryAddress($attributes)
    {
        return $this->primaryAddress->update($attributes);
    }
    
    /**
     * @return bool
     */
    public function clearAddress()
    {
        return $this->address->each(function ($model) {
            return $model->delete();
        });
    }
    
    /**
     * @param $key
     *
     * @return bool
     */
    public function isAddressFilled($key)
    {
        return Address::isFilled(request()->input($key));
    }
}
