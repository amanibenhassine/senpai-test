<?php
/**
 * The admin-specific functionality of the theme.
 *
 * Defines the theme name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Senpai_Wp_Test
 * @subpackage Senpai_Wp_Test/admin
 * @author     Amine Safsafi <amine.safsafi@senpai.codes>
 */
class Senpai_Wp_Test_Admin {

	/**
	 * The ID of this theme.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $senpai_wp_test    The ID of this theme.
	 */
	private $senpai_wp_test;

	/**
	 * The version of this theme.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this theme.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $senpai_wp_test       The name of this theme.
	 * @param      string    $version    The version of this theme.
	 */
	public function __construct( $senpai_wp_test, $version ) {

		$this->senpai_wp_test = $senpai_wp_test;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'senpai_wp_test_admin_loader_css', THEME_URI . '/admin/dist/main/senpai-wp-test-loader.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'senpai_wp_test_admin_loader_js', THEME_URI . '/admin/dist/main/senpai-wp-test-loader.js', array('wp-i18n','jquery'), $this->version, false );
		wp_enqueue_script( 'senpai_wp_test_admin_setting_js', THEME_URI . '/admin/dist/main/senpai-wp-test-setting.js', array('senpai_wp_test_admin_loader_js'), $this->version, false );
	
		wp_enqueue_script( 'senpai_notice_ajax', THEME_URI . '/admin/dist/main/senpai-wp-test-notice.js', array('senpai_wp_test_admin_loader_js') , $this->version, false );
		wp_localize_script( 'senpai_notice_ajax', 'senpai_notice_ajax_params', array(
			'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
			'nonce' => wp_create_nonce('senpai-ajax-notice-nonce')
		) );
	

		wp_enqueue_script('senpai_test_ajax', THEME_URI . '/admin/dist/main/senpai-wp-test-test.js', array('senpai_wp_test_admin_loader_js'), $this->version, false );
		wp_localize_script('senpai_test_ajax','senpai_test_ajax_params', array(
			'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
			'nonce' => wp_create_nonce('senpai-ajax-test-nonce')
		) );
		

	}
	function process_form_data() {
		global $wpdb;
	
		if (isset($_POST['form_data'])) {
			
			$data = $_POST['form_data'];
			parse_str($data, $form_data);
	
			$name = sanitize_text_field($form_data['name']);
			$email = sanitize_email($form_data['email']);
			$phone = sanitize_text_field($form_data['phone']);
		    $message = sanitize_text_field($form_data['message']);
	
			
			$table_name = $wpdb->prefix . 'senpai_' . 'form_table';
			$wpdb->insert(
				$table_name,
				array(
					'name' => $name,
					'email' => $email,
					'phone' => $phone,
					'message' => $message
				)
			);
	
			echo 'Data inserted successfully'; 
		} else {
			echo 'Bad request';
		}
	
		wp_die(); 
	}

	public function senpai_admin_pages_handler()  {
		add_menu_page(
			'Contact',  
			'contact',  
			'manage_options',  
			'contact_page' ,
			array($this,'render_page'),
			'dashicons-media-code',
			'senpai_admin_page_callback',

			
			
		);
	}
	public function render_page(){
		$dir = THEME_DIR .'/admin/partials/';
		include $dir . 'index.php';

	}
	function senpai_admin_page_callback() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'senpai_' . 'form_table';
	
		$entries = $wpdb->get_results("SELECT * FROM $table_name");
	
		echo '<div class="wrap">';
		echo '<h2>Custom Entries</h2>';
		echo '<table class="wp-list-table widefat fixed">';
		echo '<thead><tr><th>ID</th><th>Name</th><th>Email</th></tr></thead>';
		echo '<tbody>';
	
		foreach ($entries as $entry) {
			echo '<tr>';
			echo '<td>' . esc_html($entry->id) . '</td>';
			echo '<td>' . esc_html($entry->name) . '</td>';
			echo '<td>' . esc_html($entry->email) . '</td>';
			echo '<td>' . esc_html($entry->phone) . '</td>';
			echo '<td>' . esc_html($entry->message) . '</td>';
			echo '</tr>';
		}
	
		echo '</tbody></table>';
		echo '</div>';
	}
	
	
	/*public function senpai_test_admin_ajax(){

		senpai_log($_POST);
		$nonce =(string)$_POST[nonce];

		if (!wp_verify_nonce($nonce, 'senpai-ajax-test-nonce')) {
			$response = array (
				'success' => 0,
				'data' => array(),
				'error' => 'Invalid nonce'
			);
			wp_send_json($response);
		}

		$name = sanitize_text_field($_POST['name']);
		$email = sanitize_email($_POST['email']);
		$phone = sanitize_text_field($_POST['phone']);
		$message = sanitize_text_field($_POST['message']);
	
		global $wpdb;
		$table_name = $wpdb->prefix . 'senpai_' . 'form_table';
	
		$data = array(
			'name' => $name,
			'email' => $email,
			'phone' => $phone,
			'message' => $message
		);
	
		$wpdb->insert($table_name, $data);
	
		$response = array(
			'success' => 1,
			'data' => 'Success',
			'error' => ''
		);
		wp_send_json($response);

}
*/
}