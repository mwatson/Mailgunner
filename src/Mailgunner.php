<?php

namespace Mailgunner;

// Dead simple Mailgun sender. Requires CURL.

class Mailgunner {

    protected $config;

    private $emailData = [
        'to'         => "",
        'from'       => "",
        'subject'    => "",
        'text'       => "",
        'html'       => "",
        'attachment' => "",
    ];

    public function __construct($config = []) {
        if (count($config)) {
            $this->config = $config;
        }
    }

    public static function create($config = []) {
        return new Static($config);
    }

    public function getConfig($name) {
        if (isset($this->config[$name])) {
            return $this->config[$name];
        }
        return false;
    }

    public function __set($name, $value) {
        if (isset($this->emailData[$name])) {
            if (is_array($this->emailData[$name])) {
                $this->emailData[$name][] = $value;
            } else {
                $this->emailData[$name] = $value;
            }
        }
    }

    public function __call($method, $args) {
        if (sizeof($args) == 1) {
            $this->$method = $args[0];
        }
        return $this;
    }

    public function send() {
        return $this->hitApi('messages', $this->emailData);
    }

    private function getCurlOpts($endpoint, $data) {
        $url = [
            $this->getConfig('url'),
        ];
        $method = "GET";
        switch ($endpoint) {
            case 'messages':
                $url[] = $this->getConfig('domain');
                $url[] = $endpoint;
                $method = "POST";
                break;
        }
        $curlOpts = [
            CURLOPT_URL => implode('/', $url),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD => 'api:' . $this->getConfig('key'),
            CURLOPT_FOLLOWLOCATION => true,
        ];
        if ($method == "POST") {
            $curlOpts[CURLOPT_POST] = true;
            if ($data['attachment']) {
                $data['attachment'] = new \CURLFile($data['attachment']);
            }
            $curlOpts[CURLOPT_POSTFIELDS] = $data;
        }
        return $curlOpts;
    }

    protected function hitApi($endpoint, $data = []) {
        $ch = curl_init();
        $opts = $this->getCurlOpts($endpoint, $data);
        curl_setopt_array($ch, $opts);
        $response = curl_exec($ch);
        $result = [];
        if ($response === false) {
            $result = [
                'success' => false,
                'message' => "CURL Error: " . curl_error($ch),
            ];
        } else {
            $response = @json_decode($response, true);
            if (isset($response['message'])) {
                $result = [
                    'success' => true,
                    'message' => "Mailgun Response: {$result['message']}",
                    'response' => $response,
                ];
            } else {
                $result = [
                    'success' => false,
                    'response' => $response,
                ];
            }
        }
        curl_close($ch);

        return $result;
    }
}
