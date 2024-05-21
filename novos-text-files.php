<?php
/*
Plugin Name: Novos Text Files
Description: Gives you ability to add, view, list and delete text files on novos backend.
Version: 1.0
Author: DevSyed
Author URL: https://devsyed.online
*/

defined( 'ABSPATH' ) || exit;

final class NovosTextFiles
{
    private static $instance;

    public static function get_instance() {
        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof NovosTextFiles ) ) {
            self::$instance = new NovosTextFiles;
        }
        return self::$instance;
    }

    public function __construct() {
        $this->setup_constants();
        $this->includes();
        $this->register_hooks();
    }

    private function setup_constants()
    {
        define('NOVOS_VER', '1.0');
        define('NOVOS', __FILE__);
        define('NOVOS_PLUGIN_PATH', plugin_dir_path(__FILE__));
        define('NOVOS_CORE', plugin_dir_url(__FILE__));
        define('NOVOS_ADMIN', plugin_dir_url(__FILE__) . 'admin');
        define('NOVOS_ADMIN_PATH', plugin_dir_path(__FILE__) . 'admin');
        define('NOVOS_ADMIN_ASSETS', plugin_dir_url(__FILE__) . 'admin/assets');

        define('NOVOS_TEXT_DOMAIN', 'NOVOS');

        define('NOVOS_BASE_URL', 'https://wb.test/api/novos/v1');
    }

    private function includes()
    {
        require_once NOVOS_PLUGIN_PATH . '/includes/class-novos-menu.php';
        require_once NOVOS_PLUGIN_PATH . '/includes/class-novos-ajax.php';
        require_once NOVOS_PLUGIN_PATH . '/includes/class-text-files-api.php';
    }

    private function register_hooks()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts_and_styles']);
    }


    public function enqueue_scripts_and_styles() 
    {
        wp_enqueue_script('datatables-js', '//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js', array(), '1.0', true);

        wp_enqueue_script('novos-js',NOVOS_ADMIN_ASSETS . '/novos.js', array('jquery'), '1.0', true );
        wp_localize_script('novos-js', 'ajax_handler', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'admin_url' => admin_url(),
        ));


        wp_enqueue_style('datatables-css','//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css', array(), '1.0', 'all' );
    }
}


NovosTextFiles::get_instance(); 