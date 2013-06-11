<?php

class WPF2Table extends WPF2Component {

	public function WPF2Table() {
	}

	public function getSearchBoxTitle() { return null; }

	public function getBulkActions() { return null; }

	public function getPaginator() {
		/*
		return array(
			'pages' => 5,
			'items' => 47
		);
		*/
		return null;
	}

	public function getTitle() { return null; }

	private final function renderNavLinks($location) {
		$bulkActions = $this->getBulkActions();
		$paginator = $this->getPaginator();

		if (($bulkActions != null) || ($paginator != null)) {
			println('<div class="tablenav %s">', $location);

			/* TODO : check this !!!! */
			if ($bulkActions != null) {
				foreach ($bulkActions as $bulkAction) {
					println('<div class="alignleft actions">');
					if (isset($bulkAction['label'])) {
						println('<label class="screen-reader-text" for="%s">%s</label>', $bulkAction['name'], $bulkAction['label']);
					}
					println('<select name="%s">', $bulkAction['name']);
					foreach ($bulkAction['options'] as $key => $value) {
						println('<option value="%s">%s</option>', $value, $key);
					}
					println('</select>');
					println('<input type="submit" name="" id="" class="button" value="%s">', $bulkAction['value']);
					println('</div>');
				}
			}

			if ($paginator != null) {
				println('<div class="tablenav-pages">');
				if (isset($paginator['items'])) {
					println('<span class="displaying-num">%d item%s</span>', $paginator['items'], ($paginator['items'] > 1) ? 's' : '');
				}
				if (isset($paginator['pages'])) {
					$paged = $_REQUEST['paged'];
					if (!isset($paged)) $paged = 1;
					$previousPage = $paged - 1;
					if ($previousPage < 1) $previousPage = 1;
					$nextPage = $paged + 1;
					if ($nextPage > $paginator['pages']) $nextPage = $paginator['pages'];
					println('<span class="pagination-links">');
					println('<a class="first-page%s" title="Go to the first page" href="%s">«</a>', '', $this->pageLink());
					println('<a class="prev-page" title="Go to the previous page" href="%s">‹</a>', $this->pageLink(array('paged' => $previousPage)));
					println('<span class="paging-input"><input class="current-page" title="Current page" type="text" name="paged" value="%d" size="1"> of <span class="total-pages">%d</span></span>', $paged, $paginator['pages']);
					println('<a class="next-page" title="Go to the next page" href="%s">›</a>', $this->pageLink(array('paged' => $nextPage)));
					println('<a class="last-page" title="Go to the last page" href="%s">»</a>', $this->pageLink(array('paged' => $paginator['pages'])));
					println('</span>');
				}
				println('</div>');
			}

			println('<br class="clear">');
			println('</div>');
		}
		else {
			println('<br class="clear">');
		}
	}

	private final function renderTableMeta($location, $model) {
		println('<%s>', $location);
		println('<tr>');
		foreach ($model['columns'] as $id => $column) {
			if (!isset($column['sortable'])) {
				$column['sortable'] = false;
			}
			printf('<th scope="col"');
			if ($location == 'thead') {
				printf(' id="%s"', $id);
			}
			printf(' class="manage-column column-%s', $id);
			if ($column['sortable'] == true) {
				$sortable = 'sortable';
				$sortorder = '';
				if ($_REQUEST['orderby'] == $id) {
					$sortable = 'sorted';
					$sortorder = $_REQUEST['order'];
				}
				printf(' %s %s', $sortable, $sortorder);
			}
			printf('" style="">');
			if ($column['sortable'] == true) {
				$order = 'asc';
				if ($_REQUEST['orderby'] == $id) {
					if ($_REQUEST['order'] == 'asc') {
						$order = 'desc';
					}
				}
				printf('<a href="%s">', $this->pageLink(array('orderby' => $id, 'order' => $order)));
			}
			printf('<span>%s</span>', $column['label']);
			if ($column['sortable'] == true) {
				printf('<span class="sorting-indicator"></span></a>');
			}
			println('</th>');
		}
		println('</tr>');
		println('</%s>', $location);
	}

	public function render() {
		println('<form action="" method="get">');

		$searchBoxTitle = $this->getSearchBoxTitle();

		if ($searchBoxTitle != null) {
			/* TODO : check this !!!! */
			println('<p class="search-box">');
			println('<label class="screen-reader-text" for="user-search-input">%s:</label>', $searchBoxTitle);
			println('<input type="search" id="search-input" name="s" value="">');
			println('<input type="submit" name="" id="search-submit" class="button" value="%s">', $searchBoxTitle);
			println('</p>');
		}

		/* <input type="hidden" id="_wpnonce" name="_wpnonce" value="4c31e2b95f"><input type="hidden" name="_wp_http_referer" value="/er/wp-admin/users.php"> */

		$this->renderNavLinks('top');
		$title = $this->getTitle();
		if ($title != null) {
			println('<h3>%s</h3>', $title);
		}

		$model = $this->getModel();
		println('<table class="wp-list-table widefat fixed" cellspacing="0">');
		$this->renderTableMeta('thead', $model);
		$this->renderTableMeta('tfoot', $model);
		println('<tbody>');
		foreach ($model['data'] as $row) {
			printf('<tr id="%s">', $row->$model['id']);
			foreach ($model['columns'] as $property => $column) {
				$value = isset($row->$property) ? $row->$property : null;
				if (isset($column['renderer'])) {
					$renderer = $column['renderer'];
					if (is_callable($renderer)) {
						$value = call_user_func($renderer, $value, $row);
					}
				}
				else {
					$value = $row->$property;
				}
				printf('<td>%s</td>', $value);
			}
			println('</tr>');
		}
		/*
			<tr id="user-2" class="alternate"><th scope="row" class="check-column"><label class="screen-reader-text" for="cb-select-2">Select sandrine</label><input type="checkbox" name="users[]" id="user_2" class="subscriber" value="2"></th><td class="username column-username"> <strong><a href="http://localhost/er/wp-admin/user-edit.php?user_id=2&amp;wp_http_referer=%2Fer%2Fwp-admin%2Fusers.php">sandrine</a></strong><br><div class="row-actions"><span class="edit"><a href="http://localhost/er/wp-admin/user-edit.php?user_id=2&amp;wp_http_referer=%2Fer%2Fwp-admin%2Fusers.php">Edit</a> | </span><span class="delete"><a class="submitdelete" href="users.php?action=delete&amp;user=2&amp;_wpnonce=4c31e2b95f">Delete</a></span></div></td><td class="name column-name">Sandrine Kohler</td><td class="email column-email"><a href="mailto:sandrine@skym.fr" title="E-mail: sandrine@skym.fr">sandrine@skym.fr</a></td><td class="role column-role">Subscriber</td><td class="posts column-posts num">0</td></tr>
			<tr id="user-1"><th scope="row" class="check-column"><label class="screen-reader-text" for="cb-select-1">Select yannick</label><input type="checkbox" name="users[]" id="user_1" class="administrator" value="1"></th><td class="username column-username"> <strong><a href="http://localhost/er/wp-admin/profile.php?wp_http_referer=%2Fer%2Fwp-admin%2Fusers.php">yannick</a></strong><br><div class="row-actions"><span class="edit"><a href="http://localhost/er/wp-admin/profile.php?wp_http_referer=%2Fer%2Fwp-admin%2Fusers.php">Edit</a></span></div></td><td class="name column-name">Yannick Mauray</td><td class="email column-email"><a href="mailto:yannick.mauray@euterpia-radio.fr" title="E-mail: yannick.mauray@euterpia-radio.fr">yannick.mauray@euterpia-radio.fr</a></td><td class="role column-role">Administrator</td><td class="posts column-posts num"><a href="edit.php?author=1" title="View posts by this author" class="edit">147</a></td></tr>
		*/
		println('</tbody>');
		println('</table>');
		$this->renderNavLinks('bottom');
		println('</form>');
	}
}

class TableSummary extends WPF2Table {

	private $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');

	public function TableSummary($summaryRow) {
		parent::WPF2Table();
		$this->episodeId = $summaryRow->id;
		$this->title = $summaryRow->name;
	}

	public function getTitle() {
		return $this->title;
	}

	public function getModel() {
		global $wpdb;

		$query = $wpdb->prepare('select t.id, t.position, a.id as artist_id, a.name as artist, t.title, b.title as album, b.month, b.year, s.name as source, "yyy" as previous from wp_erpress2_tracks t, wp_erpress2_artists a, wp_erpress2_albums b, wp_erpress2_sources s where t.episode_id = %d and a.id = t.artist_id and b.id = t.album_id and s.id = b.source_id', $this->episodeId);
		$data = $wpdb->get_results($query);

		return array(
			'columns' => array(
				'position' => array(
					'label' => 'Position',
					'renderer' => function($value) {
						if ($value == 11) {
							return 'Flashback';
						}
						else {
							return $value;
						}
					}
				),
				'artist' => array(
					'label' => 'Artist'
				),
				'title' => array(
					'label' => 'Title'
				),
				'album' => array(
					'label' => 'Album'
				),
				'publication' => array(
					'label' => 'Publication',
					'renderer' => function($value, $row) {
						$month = $row->month;
						$year = $row->year;
						if (($month == null) || ($month == 0)) {
							return $year;
						}
						else {
							return $this->months[$month] . ' ' . $year;
						}
					}
				),
				'source' => array(
					'label' => 'Source'
				),
				'previous' => array(
					'label' => 'Previous',
					'renderer' => function($value, $row) use ($wpdb) {
						$query = $wpdb->prepare('select e.*, e.publication > now() as futur from wp_erpress2_tracks t, wp_erpress2_episodes e where t.artist_id = %d and t.id != %d and e.id = t.episode_id order by e.publication asc', $row->artist_id, $row->id);
						$rows = $wpdb->get_results($query);
						$value = '';
						foreach ($rows as $row) {
							if ($row->futur == 1) {
								$value .= '<i>' .$row->name . '</i><br/>';
							}
							else {
								$value .= $row->name . '<br/>';
							}
						}

						return $value;
					}
				)
			),
			'id' => 'id',
			'data' => $data
		);
	}

}

?>
