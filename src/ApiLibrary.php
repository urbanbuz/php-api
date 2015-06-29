<?php

namespace UrbanBuz\API;

class ApiLibrary
{

    const DEFAULT_USESSL = true;
    const DEFAULT_HEADERS = array(
        'Content-Type: application/json',
        'Accept: application/json'
    );
    const VERSION = '3.0';
    const PREFIX = 'oauth_';

    private $host;
	private $apiKey;
	private $apiSecret;
    private $useSsl;
    private $headers;

	public function __construct(
	    $host,
	    $apiKey,
	    $apiSecret,
	    $useSsl = self::DEFAULT_USESSL,
	    $headers = self::DEFAULT_HEADERS)
	{
		$this->host = $host;
		$this->apiKey = $apiKey;
		$this->apiSecret = $apiSecret;
		$this->useSsl = $useSsl;
		$this->headers = $headers;
	}

	private function _urlencode($input)
	{
		if (is_array($input))
			return array_map(array('_urlencode'), $input);
		elseif (is_scalar($input))
			return str_replace('+', ' ', str_replace('%7E', '~', rawurlencode($input)));
		else
			return '';
	}

	private function _sign($args)
	{
		ksort($args);
		$sbs = http_build_query($args, "", "&");
		$method = 'sha1';
		$signature = hash_hmac($method, $sbs, $this->apiSecret);

		return $signature;
	}

	private function _args($args=array())
	{
		$args[self::PREFIX.'nonce'] = str_pad(mt_rand(0, 99999999), 8, STR_PAD_LEFT);
		$args[self::PREFIX.'timestamp'] = "".time();
		$args[self::PREFIX.'key'] = $this->apiKey;

		if (!array_key_exists(self::PREFIX.'format', $args))
			$args[self::PREFIX.'format'] = 'php';

		$args[self::PREFIX.'kit'] = 'php-' . self::VERSION;
		$args[self::PREFIX.'signature'] = $this->_sign($args);

		return $args;
	}

    private function buildUrl($call)
    {
        return sprintf('http%s://%s/%s', $this->useSsl ? 's' : '', $this->host, $call);
    }

	public function call($call, $args=array())
	{
		$url = $this->buildUrl($call);

		$response = null;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_POST, count($args));
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($this->_args($args)));
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);

		$response = curl_exec($curl);
		$unserialized_response = @unserialize($response);
		return $unserialized_response ? $unserialized_response : $response;
	}
}
