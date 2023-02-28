<?php
/**
 * hash_Password
 * This function takes two strings as parameters, a password and a pepper. 
 * It then creates a hashed version of the password using 
 * the SHA-256 algorithm and the pepper as a key. 
 * Finally, it hashes the result using the BCRYPT algorithm and returns it.
 * @param string $password
 * @param string $pepper
 * @return string
 */
function hash_Password(string $password, string $pepper) {
	$password_peppered = hash_hmac("sha256", $password, $pepper);
	$password_hashed = password_hash($password_peppered, PASSWORD_BCRYPT);
	return $password_hashed;
}

/**
 * verify_Password
 * This function verifies a password by hashing it with a pepper 
 * and comparing the result to a hashed version of the password.
 * @param string $password_hashed
 * @param string $password
 * @param string $pepper
 * @return bool
 */
function verify_Password(string $password_hashed, string $password, string $pepper) {
	$password_peppered = hash_hmac("sha256", $password, $pepper);
	if (password_verify($password_peppered, $password_hashed)) {
		return true;
	}
	return false;
}
?>
