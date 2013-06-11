<?php

require_once('tableSummary.php');

class MenuSummary extends WPF2MenuHandler {

	public function getTitle() {
		return 'Summary';
	}

	public function getActions() {
		return array(
			'Add track' => array(
				'href' => 'user-new.php',
				'class' => 'add-new-h2',
			)
		);
	}

	public function getSubLinks() {
		return array(
			'Upcoming' => array(
				'class' => 'upcoming',
				'href' => $this->pageLink(),
				/*'count' => 2,*/
				'current' => !isset($_REQUEST['status'])
			),
			'Archived' => array(
				'class' => 'archived',
				'href' => $this->pageLink(array('status' => 'archived')),
				/*'count' => 1,*/
				'current' => (isset($_REQUEST['status']) && $_REQUEST['status'] == 'archived')
			),
			'All' => array(
				'class' => 'all',
				'href' => $this->pageLink(array('status' => 'all')),
				/*'count' => 1,*/
				'current' => (isset($_REQUEST['status']) && $_REQUEST['status'] == 'all')
			)
		);
	}

	public function renderPage() {

		global $wpdb;

		$where = ' where archive = 0';
		if (isset($_REQUEST['status'])) {
			if ($_REQUEST['status'] == 'archived') $where = ' where archive = 1';
			if ($_REQUEST['status'] == 'all') $where = '';
		}
		$query = 'select * from wp_erpress2_episodes' . $where . ' order by publication asc';
		$rows = $wpdb->get_results($query);
		foreach ($rows as $row) {
			$table = new TableSummary($row);
			$table->render();
		}
	}
}

?>
