<?php 

defined('ABSPATH') || exit; 
class NovosTextFilesAPI
{
    public function __construct($base_url = ''){
        $this->base_url = $base_url;
    }

    public function getToken()
    {
        $token = get_transient('novos_token');
        if ($token) return $token;

        try {
            $response = $this->ntfMakeRequest('/login', 'POST', ['email' => 'admin@novoslabs.com', 'password' => '12345678'],false);
        } catch (\Throwable $th) {
            return $this->novosFormatError('authentication-failed', 'Could not authenticate the user. Error: ' . $th->getMessage());
        }
        $token = $this->formatResponse($response)['token'];
        set_transient('novos_token', $token, 3600);
        return $token;
    }

    public function ntfMakeRequest($url = '', $method = 'GET', $body = [], $authenticatedRequest = false)
    {
        $args = [
            'method' => $method,
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'sslverify' => false,
        ];

        if ($method === 'POST' || $method === 'PUT') {
            $args['body'] = $this->formatRequestBody($body);
        }

        if ($authenticatedRequest) {
            $token = $this->getToken();
            if (!$token) {
                return $this->novosFormatError('token-invalid', __('Invalid Token, Please Refresh Page and try again.'));
            }

            $args['headers']['Authorization'] = 'Bearer ' . $this->getToken();
        }

        error_log('Request Headers: ' . print_r($args['headers'], true));

        $response = wp_remote_request($this->base_url . $url, $args);
        if (is_wp_error($response)) {
            error_log($response->get_error_message());
            return $this->novosFormatError('request-failed', 'Request to the server failed. Error: ' . $response->get_error_message());
        }
        $body = wp_remote_retrieve_body($response);

        error_log('Response Body: ' . $body);

        return $body;
    }

    public function getFiles()
    {
        try {
            $response = $this->ntfMakeRequest('/files', 'GET', [], true);
        } catch (\Throwable $th) {
            return $this->novosFormatError('failed-fetching-files', 'Could not fetch the files. Error: ' . $th->getMessage());
        }
        $files = $this->formatResponse($response);
        return $files;
    }

    public function getAllContent()
    {
        try {
            $response = $this->ntfMakeRequest('/get_contents', 'GET', [], true);
        } catch (\Throwable $th) {
            return $this->novosFormatError('failed-fetching-content', 'Could not fetch the content. Error: ' . $th->getMessage());
        }
        // not using formatResponse for this, because its just text.
        return $response;
    }

    public function viewFile($fileRefName)
    {
        try {
            $response = $this->ntfMakeRequest('/files/' . $fileRefName, 'GET', [], true);
        } catch (\Throwable $th) {
            return $this->novosFormatError('failed-fetching-files', 'Could not fetch the files. Error: ' . $th->getMessage());
        }
        $file = $this->formatResponse($response);
        return $file;
    }

    public function createFile($fileName,$fileContent)
    {
        try {
            $response = $this->ntfMakeRequest('/files', 'POST', ['fileName' => $fileName, 'content' => $fileContent], true);
            return $response;
        } catch (\Throwable $th) {
            return $this->novosFormatError('failed-creating-file', 'Could not create the files. Error: ' . $th->getMessage());
        }
        $create = $this->formatResponse($response);
        return $create;
    }

    public function deleteFile($fileRefName)
    {
        try {
            $response = $this->ntfMakeRequest('/files/' . $fileRefName, 'DELETE', [], true);
        } catch (\Throwable $th) {
            return $this->novosFormatError('failed-deleting-file', 'Could not delete the files. Error: ' . $th->getMessage());
        }
        $deleted = $this->formatResponse($response);
        return $deleted;
    }

    public function formatResponse($response)
    {
        return json_decode($response,true)['data'];
    }

    public function formatRequestBody($body)
    {
        return wp_json_encode($body);
    }

    public function novosFormatError($error_key, $error_message)
    {
        return new WP_Error($error_key,$error_message);
    }


}
