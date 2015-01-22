<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
            'client_id'     => 'client_id',
            'client_secret' => 'client_secret',
            'scope'         => array('email'),
        ),
        'Twitter' => array(
            'client_id'     => 'client_id',
            'client_secret' => 'client_secret',
            // No scope - oauth1 doesn't need scope
        ),
        'Google' => array(
            'client_id'     => 'client_id',
            'client_secret' => 'client_secret',
            'scope'         => array('userinfo_email', 'userinfo_profile'),
        ),

    )

);