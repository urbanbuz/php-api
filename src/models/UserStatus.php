<?php

namespace UrbanBuz\API\models;

class UserStatus extends Model
{

    public $phone;
    public $email;
    public $photo_url;
    public $current_credit;
    public $expires;
    public $rank;
    public $label;
    public $icon;
    public $joined;
    public $currency;
    public $first;
    public $last;
    public $birth_date;
    public $gender;
    public $country;
    public $to_next_level;

    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
