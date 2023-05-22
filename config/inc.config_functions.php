<?php // Config functions

//Encrypt/Decrypt ###########################
function Encrypt_String($string) {
	return openssl_encrypt($string, "AES-128-ECB", "REGmon");
}
function Decrypt_String($encrypted_string) {
	return openssl_decrypt($encrypted_string, "AES-128-ECB", "REGmon");
}

function Generate_Secret_Key($length = 64, $special_chars = true, $extra_special_chars = false) {
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	if ($special_chars) {
		$chars .= '!@#$%^&*()';
	}
	if ($extra_special_chars) {
		$chars .= '-_ []{}<>~`+=,.;:/?|';
	}
	
	$max = strlen($chars) - 1;
	$key = '';
	for ($j = 0; $j < $length; $j++) {
		$key .= substr($chars, random_int(0, $max), 1);
	}

	return $key;
}

function reload_Config_Page($page) {
	header('Location: ' . $page); //reload page
}
