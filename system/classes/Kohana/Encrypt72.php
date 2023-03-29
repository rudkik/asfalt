<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * The Encrypt library provides two-way encryption of text and binary strings
 *
 * @package    Kohana
 * @category   Security
 * @author     Kohana Team
 * @copyright  (c) 2007-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Kohana_Encrypt72 {

	/**
	 * @var  string  default instance name
	 */
	public static $default = 'default';

	/**
	 * @var  array  Encrypt class instances
	 */
	public static $instances = array();

	/**
	 * @var string Encryption key
	 */
	protected $_key;

	/**
	 * @var int the size of the Initialization Vector (IV) in bytes
	 */
	protected $_iv_size = 16;
	
	/**
	 * Returns a singleton instance of Encrypt. An encryption key must be
	 * provided in your "encrypt" configuration file.
	 *
	 *     $encrypt = Encrypt::instance();
	 *
	 * @param   string  $name   configuration group name
	 * @return  Encrypt
	 */
	public static function instance($name = NULL)
	{
		if ($name === NULL)
		{
			// Use the default instance name
			$name = Encrypt::$default;
		}

		if ( ! isset(Encrypt::$instances[$name]))
		{
			// Load the configuration data
			$config = Kohana::$config->load('encrypt')->$name;

			if ( ! isset($config['key']))
			{
				// No default encryption key is provided!
				throw new Kohana_Exception('No encryption key is defined in the encryption configuration group: :group',
					array(':group' => $name));
			}

			// Create a new instance
			Encrypt72::$instances[$name] = new Encrypt72($config['key']);
		}

		return Encrypt72::$instances[$name];
	}

	/**
	 * Creates a new wrapper.
	 *
	 * @param   string  $key    encryption key
	 * @param   string  $mode   mode
	 * @param   string  $cipher cipher
	 */
	public function __construct($key)
	{
		// Store the key, mode, and cipher
		$this->_key    = $key;
	}

	/**
	 * Encrypts a string and returns an encrypted string that can be decoded.
	 *
	 *     $data = $encrypt->encode($data);
	 *
	 * The encrypted binary data is encoded using [base64](http://php.net/base64_encode)
	 * to convert it to a string. This string can be stored in a database,
	 * displayed, and passed using most other means without corruption.
	 *
	 * @param   string  $data   data to be encrypted
	 * @return  string
	 */
	public function encode($data)
	{
		// Get an initialization vector
		$iv = $this->_create_iv();

        // Encrypt the data using the configured options and generated iv
        $data = openssl_encrypt($data, 'aes-256-cbc', $this->_key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);

		// Use base64 encoding to convert to a string
		return base64_encode($iv.$data);
	}

	/**
	 * Decrypts an encoded string back to its original value.
	 *
	 *     $data = $encrypt->decode($data);
	 *
	 * @param   string  $data   encoded string to be decrypted
	 * @return  FALSE   if decryption fails
	 * @return  string
	 */
	public function decode($data)
	{
		// Convert the data back to binary
		$data = base64_decode($data, TRUE);

		if ( ! $data)
		{
			// Invalid base64 data
			return FALSE;
		}

		// Extract the initialization vector from the data
		$iv = substr($data, 0, $this->_iv_size);

		if ($this->_iv_size !== strlen($iv))
		{
			// The iv is not the expected size
			return FALSE;
		}

		// Remove the iv from the data
		$data = substr($data, $this->_iv_size);

        try {
            // Return the decrypted data, trimming the \0 padding bytes from the end of the data
            return rtrim(openssl_decrypt($data, 'aes-256-cbc', $this->_key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv), "\0");
        }catch (Exception $e){
            return FALSE;
        }
	}

	/**
	 * Proxy for the function - to allow mocking and testing against KAT vectors
	 *
	 * @return string the initialization vector or FALSE on error
	 */
	protected function _create_iv()
	{
        return random_bytes($this->_iv_size);
	}
}
