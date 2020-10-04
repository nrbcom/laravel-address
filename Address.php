<?php

namespace NRB\Address;

use League\ISO3166\ISO3166;

class Address extends \Illuminate\Database\Eloquent\Model
{
    /** @var array */
    protected $fillable = [
        'line1',
        'line2',
        'building_number',
        'door_number',
        'street',
        'state',
        'province',
        'region',
        'county',
        'city',
        'zip',
        'country',
        'primary',
        'invoice',
        'cord_x',
        'cord_y',
    ];
    
    /** @var array */
    protected $casts = [
        'data' => 'array',
    ];
    
    /**
     * @param $attributes
     *
     * @return bool
     */
    public static function isFilled($attributes)
    {
        $fillable = (new Address())->getFillable();
        $fillable = array_filter($fillable, function ($key) {
            return !in_array($key, ['data', 'primary']);
        });
        
        foreach ($fillable as $attr) {
            if (isset($attributes[$attr]) && !empty($attributes[$attr])) {
                return TRUE;
            }
        }
        
        return FALSE;
    }
    
    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function (Address $address) {
            
            if (empty($address->country) && config('addresses.default_country')) {
                $address->country = config('addresses.default_country');
            }
            
        });
    }
    
    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return "$this->line1 $this->line2, $this->city $this->zip, $this->countryName";
    }
    
    /**
     * @return string
     */
    public function getLineAndDoorAttribute()
    {
        return "$this->line1 $this->door_number";
    }
    
    /**
     * @return string
     */
    public function getBuildingAndDoorAttribute()
    {
        return "$this->building_number $this->door_number";
    }
    
    /**
     * @return string
     */
    public function getCityAndZipAttribute()
    {
        return "$this->city $this->zip";
    }
    
    public function getRoadAndSprcAttribute()
    {
        return "$this->line1, $this->sprc";
    }
    
    /**
     * @return string
     */
    public function getLineCityCountryAttribute()
    {
        return "$this->line1, $this->city,  $this->country";
    }
    
    /**
     * @return string
     */
    public function getBuildingAddressAttribute()
    {
        return "$this->building_number $this->line1, $this->city $this->zip, $this->countryName";
    }
    
    /**
     * @return string
     */
    public function getDoorAddressAttribute()
    {
        return "$this->door_number $this->line1, $this->city $this->zip, $this->countryName";
    }
    
    /**
     * @return mixed
     */
    public function getCountryNameAttribute()
    {
        try {
            $country = (new ISO3166())->alpha3($this->country);
            return $country['name'] ?? $this->country;
        } catch (\Exception $e) {
        }
        
        return $this->country;
    }
}
