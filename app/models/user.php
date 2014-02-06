<?php
class User extends AppModel
{
	public $validation = array(
		'username' => array(
			'length' => array(
				'validate_between', 6, 10,
			),
		),
		'password' => array(
			'length' => array(
				'validate_between', 6, 15,
			),
		),
	);
}