<?php

/**
 * Class Timers
 *
 * Timer data model for recording individual timers for EVE online
 */
class Timers extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'timers';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	/**
	 * Hardcoded GroupID that relates to the EVE Static Data Dump
	 *
	 * @var int
	 */
	public static $POCOGroupID = 7;

	/**
	 * The attributes that can be edited in models.
	 *
	 * @var array
	 */
	protected $fillable = array(
		'itemID',
		'structureType',
		'structureStatus',
		'bashed',
		'outcome',
		'timerType',
		'timeExiting',
		'user_id'
	);

	/**
	 * Hardcoded Structure IDs that map IDs to names
	 *
	 * @var array
	 */
	public static $structureTypes = array(
		'1' => 'POS',
		'2' => 'POCO',
		'3' => 'Station',
		'4' => 'I-Hub',
		'5' => 'TCU'
	);

	/**
	 * Hardcoded Structure Statuses that map Statuses to names
	 *
	 * @var array
	 */
	public static $structureStatus = array(
		'0' => '',
		'1' => 'Shield',
		'2' => 'Armor',
	);

	/**
	 * Hardcoded Timer Types that map Types to Names
	 *
	 * @var array
	 */
	public static $timerType = array(
		'0' => 'Offensive',
		'1' => 'Defensive'
	);
        
        public static $signUpRoles = array(
                '0' => 'FC',
                '1' => 'Titan'
        );
        
        /**
	 * Many-to-many relationship to ApiUser for signing up for timers.
	 */
        public function signUps()
        {
                return $this->belongsToMany('ApiUser', 'timer_sign_ups')->withPivot('role', 'confirmed');
        }
        
        /**
	 * One-to-many relationship to notes
	 */
        public function notes()
        {
                return $this->hasMany('Notes');
        }
        
        /**
	 * Convenience method for checking if a user has signed up for this timer instance.
         * 
         * @param int UserId ID of user to check
         * @param role ID of role from 
         * @return bool True if signed up, otherwise false
	 */
        public function isUserSignedUpAs($userId, $roleId)
        {
                return !$this->signUps()->wherePivot('api_user_id', $userId)
                        ->wherePivot('role', $roleId)->get()->isEmpty();
        }
        
        public function userCanSignUp($roleId)
        {       
                $role = Timers::$signUpRoles[$roleId];
                if($role == 'FC' and Auth::user()->isFC())
                {
                        return true;
                }
                if($role == 'Titan' and Auth::user()->isTitanPilot())
                {
                        return true;
                }
                return false;
        }
}