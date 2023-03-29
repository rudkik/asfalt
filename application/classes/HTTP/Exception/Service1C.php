<?php defined('SYSPATH') or die('No direct script access.');

class HTTP_Exception_Service1C extends HTTP_Exception {

    private $_data = [];
    protected $_code = 200;

    public function __construct(array $data, $code = 200)
    {
        $this->_data = $data;
        $this->_code = $code;
        parent::__construct(NULL, NULL, NULL);
    }

	/**
	 * Generate a Response for the 500 Exception.
	 *
	 * The user should be shown a nice 500 page.
	 *
	 * @return Response
	 */
	public function get_response()
	{
		$response = Response::factory()
		->status($this->_code)
		->body(Json::json_encode($this->_data));

		return $response;
	}
}