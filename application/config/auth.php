<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(
	'driver'       => 'MySQL',
	'hash_method'  => 'sha256',
	'hash_key'     => '12324667',
	'lifetime'     => 63072000,
	'session_type' => Session::$default,
	'session_type' => 'native',
	'session_key'  => 'auth_user',

	// Username/password combinations for the Auth File driver
	'users' => array(
		// 'admin' => 'b3154acf3a344170077d11bdb5fff31532f679a1919e716a02',
	),

);
