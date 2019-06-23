<?php

class Pirate {
    private $_user;
    private $_password;
    private $_host;
    private $_port;

    private $_id;

    public function __construct($host, $port, $user, $password, $id = 0) {
        $this->_user = $user;
        $this->_password = $password;
        $this->_host = $host;
        $this->_port = $port;

        $this->_id   = $id;
    }

    public function __call($method, array $params = array()) {

        $request = json_encode(array(
            'method' => $method
        ));

        $curl    = curl_init($this->_user . ':' . $this->_password . '@' . $this->_host . ':' . $this->_port);
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => str_replace(array('[{', '}]'), array('{', '}'), $request)
        );

        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);
        $response = json_decode($response, true);
        $address  = ($response['result'].PHP_EOL);

        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {
            return $error;
        } else {
            return $response;
        }
    }
}
