<?php
class addShortcodesButton {
	var $pluginname = 'teamDutchShortcode';
	var $path = '';
	var $internalVersion = 100;
	
	function addShortcodesButton() {
		$this->path = get_template_directory_uri() . '/lib/shortcodes/';	
		
		/* Modify the version when tinyMCE plugins are changed */
		add_filter('tiny_mce_version', array(&$this, 'change_tinymce_version'));

		/* Init process for button control */
		add_action('init', array(&$this, 'addbuttons'));
	}
	
	function addbuttons() {
		/* Escape if the current user lacks permissions */
		if(!current_user_can('edit_posts') && !current_user_can('edit_pages')) { 
			return;
		}
		
		/* Only add in Rich Editor mode */
		if(get_user_option('rich_editing') == 'true') {
			$svr_uri = $_SERVER['REQUEST_URI'];
			if(strstr($svr_uri, 'post.php') || strstr($svr_uri, 'post-new.php') || strstr($svr_uri, 'page.php') || strstr($svr_uri, 'page-new.php') || strstr($svr_uri, 'theme_options.php')) {
				add_filter("mce_external_plugins", array(&$this, 'add_tinymce_plugin'), 5);
				add_filter('mce_buttons', array(&$this, 'register_button'), 5);
			}
		}
	}
	
	function register_button($buttons) {
		array_push($buttons, 'separator', $this->pluginname );
		return $buttons;
	}
	
	function add_tinymce_plugin($plugin_array) {
		global $page_handle;
		
		$plugin_array[$this->pluginname] =  $this->path . 'editor_plugin.js';
		return $plugin_array;
	}
	
	function change_tinymce_version($version) {
		$version = $version + $this->internalVersion;
		return $version;
	}
}
$tinymce_button = new addShortcodesButton();
?>