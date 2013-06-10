<?php
/*
Plugin Name: erpress3
Plugin URI: http://www.euterpia-radio.fr/plugins/erpress3/
Description: Plugin to manage show notes.
Version: 3.0.0 (Cheerfull Cougar)
Author: Yannick
Author URI: http://www.euterpia-radio.fr/
Contributors:
Yannick

Credits:

Copyright 2013 - Euterpia Radio

License: GPL (http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt)
*/

require('WPF2.php');

class ERPress3 extends WPF2Plugin {

	public function ERPress3() {
		parent::WPF2Plugin('erpress3');
	}

	public function getAdminMenu() {
		return array(
			'ERPress3' => array(
				'capability' => 'read',
				'items' => array(
					'Summary' => 'summary', 
					'Artists' => 'artists', 
					'Albums' => 'albums', 
					'Tracks' => 'tracks', 
					'Shows' => 'shows', 
					'Stats' => 'stats'
				)
			)
		);
	}

	function handleMenuSummary() {
		echo "hello menu Summary !";
	}
}

new ERPress3();

?>
