<?php
	date_default_timezone_set('America/Los_Angeles');

	function fechaPeru(){
		$meses = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		return date('d')." de ". $meses[date('n')] . " de " . date('Y');
	}
?>
