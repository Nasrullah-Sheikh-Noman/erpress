<?php

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

abstract class WPF2MenuHandler {

	private $plugin;

	public function WPF2MenuHandler($plugin) {
		$this->plugin = $plugin;
	}

	function wrap($renderPage) {
?>
<div class="wrap">
<?php
		call_user_func($renderPage, $this);
?>

<br class="clear">
</div>
<?php
	}

	protected function renderTitle($title, $icon, $actions) {
		if ($icon != null) {
			?><div id="icon-<?php echo $icon; ?>" class="icon32"><br></div><?php 
		}
		echo sprintf('<h2>%s', $title);
		foreach ($actions as $label => $action) { 
			if (is_string($action)) { 
				$action = array('link' => $action); 
			}
			echo sprintf('<a href="%s"', $action['link']);
			if (isset($action['class'])) {
				echo sprintf(' class="%s"', $action['class']);
			}
			echo sprintf('>%s</a>', $label);
		}
		echo '</h2>';
	}

	abstract public function renderPage();
}

?>
