<?php

abstract class WPF2Component {

	public function pageLink($args = null) {
		$ret = '?';

		if (isset($_REQUEST['page'])) {
			$ret .= 'page=' . $_REQUEST['page'];
		}

		if ($args != null) {
			foreach ($args as $key => $value) {
				if (strlen($ret) > 1) {
					$ret .= '&';
				}
				$ret .= urlencode($key) . '=' . urlencode($value);
			}
		}

		return $ret;
	}

}

abstract class WPF2Plugin {

	private $pluginId;

	public function WPF2Plugin($pluginId) {
		$this->pluginId = $pluginId;
		add_action('admin_menu', array($this, 'adminMenu'));
	}

	/* Abstract methods */

	abstract public function getAdminMenu();

	/* Private methods */

	private final function slug($shortSlug) {
		return $this->pluginId . '-' . $shortSlug;
	}

	/* Callbacks */

	final function adminMenu() {
		$items = $this->getAdminMenu();
		foreach ($items as $title => $item) {
			$capability = $item->capability;
			if (!isset($capability)) $capability = 'read';
			if (count($item['items']) > 0) {
				$addMenuPage = true;
				foreach ($item['items'] as $label => $submenu) {
					if (is_string($submenu)) {
						$submenu = array('slug' => $submenu, 'capability' => $capability);
					}
					if ($addMenuPage) {
						$menuSlug = $this->slug($submenu['slug']);
						add_menu_page($title, $title, $capability, $menuSlug, array($this, 'handleMenu'));
						$addMenuPage = false;
					}
					add_submenu_page($menuSlug, $label, $label, $submenu['capability'], $this->slug($submenu['slug']), array($this, 'handleMenu'));
				}
			}
			else {
				throw new Exception("Error Processing Request", 1);
			}
		}
	}

	final function handleMenu() {
		$page = $_REQUEST['page'];
		$slug = str_replace($this->pluginId . '-', '', $page);
		$camelSlug = strtoupper(substr($slug, 0, 1)) . substr($slug, 1);
		$file = WP_PLUGIN_DIR . '/' . $this->pluginId . '/menu' . $camelSlug . '.php';
		$method = 'handleMenu' . $camelSlug;
		if (file_exists($file)) {
			require($file);
			$className = 'Menu' . $camelSlug;
			if (class_exists($className)) {
				$menu = new $className($this);
				if (is_callable(array($menu, 'wrap'))) {
					$menu->wrap(function($menu) {
						$menu->renderPage();
					});
				}
			}
		}
		else if (is_callable(array($this, $method))) {
			call_user_method($method, $this);
		}
	}
}

function println() {
	$args = func_get_args();
	if (count($args) == 0) {
		print("\n");
	}
	else {
		print(call_user_func_array('sprintf', $args) . "\n");	
	}
	
}

abstract class WPF2MenuHandler extends WPF2Component {

	private $plugin;

	public function WPF2MenuHandler($plugin) {
		$this->plugin = $plugin;
	}

	function wrap($renderPage) {
		println('<div class="wrap">');
		$icon = $this->getIcon();
		if ($icon != null) {
			println('<div id="icon-%s" class="icon32"><br></div>', $icon);
		}
		println('<h2>');
		printf('%s', $this->getTitle());
		$actions = $this->getActions();
		if ($actions != null) {
			foreach ($actions as $label => $action) {
				printf(' <a href="%s" class="%s">%s</a>', $action['href'], $action['class'], $label);
			}
		}
		println('</h2>');

		$sublinks = $this->getSubLinks();
		if ($sublinks != null) {
			println('<ul class="subsubsub">');
			$i = 0;
			foreach ($sublinks as $label => $sublink) {
				printf('<li class="%s"><a href="%s"', $sublink['class'], $sublink['href']);
				if (isset($sublink['current']) && ($sublink['current'] == true)) {
					printf(' class="current"');
				}
				printf('>%s', $label);
				if (isset($sublink['count'])) {
					printf('<span class="count">(%d)</span>', $sublink['count']);
				}
				printf('</a>');
				if ($i < (count($sublinks) - 1)) {
					printf(' |');
				}
				println('</li>');
				$i++;
			}
			println('</ul>');
		}

		call_user_func($renderPage, $this);

		println('<br class="clear">');
		println('</div>');
	}

	public function getIcon() { return null; }

	public abstract function getTitle();

	public function getActions() { return null; }

	public function getSubLinks() { return null; }

	public abstract function renderPage();
}

?>
