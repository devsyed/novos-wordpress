<?php

defined('ABSPATH') || exit; 

class NovosAjax
{
    public static $ajax_actions = [
        'ntfDeleteFile',
        'ntCreateFile'
    ];




    public static function ntfLoadAjaxScripts()
    {
        foreach (self::$ajax_actions as $ajax_action) {
            add_action('wp_ajax_' . $ajax_action, [__CLASS__, $ajax_action]);
        }
    }


    public static function ntfDeleteFile()
    {
        try{
            $fileRef = sanitize_text_field($_GET['file_ref']);
            $api = new NovosTextFilesAPI(NOVOS_BASE_URL);
            $delete = $api->deleteFile($fileRef);
            wp_send_json_success($delete);
        }catch(Throwable $th){
            wp_send_json_error($th->getMessage());
        }
    }
    
    public static function ntCreateFile()
    {
        try{
            parse_str($_POST['formData'],$data);
            $nonce = $data['ntCreateFileNonce'];
            $verify_nonce = wp_verify_nonce($nonce,'ntCreateFile');
            if(!$verify_nonce){
                wp_send_json_error('Something Fishy!');
            }
            $api = new NovosTextFilesAPI(NOVOS_BASE_URL);
            $create_file = $api->createFile(sanitize_text_field($data['fileName']), sanitize_text_field($data['content']));

            if(is_wp_error($create_file)){
                wp_send_json_error($create_file->get_error_message());
            }


        }catch(Throwable $th){
            wp_send_json_error($th->getMessage());
        }
    }

    

    
}

NovosAjax::ntfLoadAjaxScripts();