<?php 

class NovosMenu
{
    public static function init()
    {
        add_action('admin_menu', array(__CLASS__, 'create_menu'));
    }

    public static function create_menu()
    {
        add_menu_page(
            'Novos Text Files',
            'Novos Text Files',
            'manage_options',
            'novos_text_files',
            array(__CLASS__, 'render_main_view'),
            'dashicons-media-text',
            20
        );

        add_submenu_page(
            'novos_text_files', 
            'Add Text File', 
            'Add Text File', 
            'manage_options',
            'novos_add_text_file',
            array(__CLASS__, 'render_add_text_files_view')
        );
    }

    public static function render_main_view()
    {
        include_once  NOVOS_ADMIN_PATH . '/views/main.php';
    }

    public static function render_add_text_files_view(){
        include_once  NOVOS_ADMIN_PATH . '/views/add_text_file.php';
    }
}

NovosMenu::init();