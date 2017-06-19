<?php

class student {
	public $username = "";
	public $code = "";

	public function __construct($user) {
        	$this->username = $user;
    	}
	
	public function addClass($ccode){
		$this->code = $ccode;
	}
}
?>
