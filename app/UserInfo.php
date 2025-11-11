<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'mobile_no',
        'birthdate',
        'country_id',
        'country_name',
        'province_id',
        'province_name',
        'city_id',
        'city_name',
        'address',
        'bank_name',
        'bank_account_number',
        'team_name',
        'tin',
        'gender',
        'occupation_id',
        'beneficiary_name',
        'beneficiary_contact_number',
        'beneficiary_relationship'
    ];

    public function country() {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function province() {
        return $this->belongsTo(Province::class, 'province_id','provCode');
    }

    public function city() {
        return $this->belongsTo(City::class, 'city_id','citymunCode');
    }

    
}
