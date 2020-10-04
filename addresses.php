<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Address model
    |--------------------------------------------------------------------------
    |
    | You can extend this \NRB\Address\Address and add here .
    |
    */
    'model' => \NRB\Address\Address::class,

    /*
    |--------------------------------------------------------------------------
    | Country
    |--------------------------------------------------------------------------
    |
    | Sometimes we need to create something to specific countries
    | If this is set, will be auto attached on create.
    | see: https://github.com/thephpleague/iso3166
    |
    */
    'default_country' => 'AL',
    
    /*
    |--------------------------------------------------------------------------
    | Format
    |--------------------------------------------------------------------------
    |
    | By default this package has implemented name attribute as mutator
    | You can modify by extending the base class and the method or
    | setup here the format you want to be returned
    |
    | See Address model for fillable attributes
    |
    */
    'name_format' => 'line1  line2, city zip, country_name country_code'

];