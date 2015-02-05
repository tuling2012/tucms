<?php
class Think {


	static public function appException($e) {
		$error = array();
		$error['message'] = $e->getMessage();
	}
}



?>