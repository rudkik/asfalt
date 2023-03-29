<?php defined('SYSPATH') OR die('No direct script access.');

/**
 * Oracle database result.
 *
 * @package     Oracle
 * @license     http://www.opensource.org/licenses/isc-license.txt
 */
class Kohana_Database_Oracle_Result extends Database_Result
{
	public function __construct($result, $sql, $as_object = FALSE, $params = NULL, $total_rows = NULL)
	{
		parent::__construct($result, $sql, $as_object, $params);

		if ($as_object === TRUE)
		{
			$this->_as_object = 'stdClass';
		}

		if ($total_rows !== NULL)
		{
			$this->_total_rows = $total_rows;
		}
		else
		{
			$this->_total_rows = 0;
		}
	}

	public function __destruct()
	{
		if (is_resource($this->_result))
		{
			oci_free_statement($this->_result);
		}
	}

	public function as_array($key = NULL, $value = NULL)
	{
		if ($this->_total_rows === 0)
			return array();

		if ( ! $this->_as_object AND $key === NULL)
		{
			// Rewind
			$this->_current_row = 0;

			if ($value === NULL)
			{
				// Indexed rows
                $this->_total_rows = oci_fetch_all($this->_result, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
				return $result;
			}

			// Indexed columns
            $this->_total_rows = oci_fetch_all($this->_result, $result);
			return $result[$value];
		}else{
            $this->_total_rows = oci_fetch_all($this->_result, $results, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);

            $result = array();
            foreach ($results as $row)
            {
                $result[$row[$key]] = $row[$value];
            }

            return $result;
        }
	}

	/**
	 * SeekableIterator: seek
	 */
	public function seek($offset)
	{
		if ( ! $this->offsetExists($offset))
			return FALSE;

		$this->_current_row = $offset;

		return TRUE;
	}

	/**
	 * Iterator: current
	 */
	public function current()
	{
		if ( ! $this->_as_object)
			return oci_fetch_assoc($this->_result);

		if ( ! $this->_object_params)
			return oci_fetch_object($this->_result);

		return oci_fetch_object($this->_result);
	}

}
