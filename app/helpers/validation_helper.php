<?php
function validate_between($check, $min, $max)
{
    $n = mb_strlen($check);
    return $min <= $n && $n <= $max;
}
function match_password($pass1, $pass2)
{
	return $pass1 === $pass2;
}
function match_username($user1, $user2)
{
	return $user1 !== $user2;
}