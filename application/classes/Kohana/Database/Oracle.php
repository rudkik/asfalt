<?php defined('SYSPATH') OR die('No direct script access.');

/**
 * Oracle database connection.
 *
 * @package     Oracle
 * @author      Sergey Naymushin
 * @license     http://www.opensource.org/licenses/isc-license.txt
 */
class Kohana_Database_Oracle extends Database
{

	public function __construct($name, $config)
	{
		parent::__construct($name, $config);

		if (empty($this->_config['connection']['info']))
		{
			// Build connection string
			$this->_config['connection']['info'] = '';

			extract($this->_config['connection']);

			$info = '';
			if ( ! empty($hostname))
			{
				$info .= "host='$hostname'";
			}

			if ( ! empty($port))
			{
				$info .= " port='$port'";
			}

			if ( ! empty($username))
			{
				$info .= " user='$username'";
			}

			if ( ! empty($password))
			{
				$info .= " password='$password'";
			}

			if ( ! empty($database))
			{
				$info .= " dbname='$database'";
			}

			if (isset($ssl))
			{
				if ($ssl === TRUE)
				{
					$info .= " sslmode='require'";
				}
				elseif ($ssl === FALSE)
				{
					$info .= " sslmode='disable'";
				}
				else
				{
					$info .= " sslmode='$ssl'";
				}
			}

			$this->_config['connection']['info'] = $info;
		}
	}

	public function connect()
	{
		if ($this->_connection)
			return;

		try
		{
            $this->_connection = oci_connect($this->_config['connection']['username'], $this->_config['connection']['password'], $this->_config['connection']['connection_string'], $this->_config['charset']);

            if (!$this->_connection) {
                $e = oci_error();
                throw new Database_Exception(':error', array(':error' => $e['message']));
            }
		}
		catch (ErrorException $e)
		{
			throw new Database_Exception(':error', array(':error' => $e->getMessage()));
		}

		if ( ! is_resource($this->_connection))
			throw new Database_Exception('Unable to connect to Oracle ":name"', array(':name' => $this->_instance));
	}

	public function disconnect()
	{
		if ( ! $status = ! is_resource($this->_connection))
		{
			if ($status = oci_close($this->_connection))
			{
				$this->_connection = NULL;
			}
		}

		return $status;
	}

	public function set_charset($charset)
	{
		$this->_connection OR $this->connect();
	}

	/**
	 * Execute a Oracle command
	 *
	 * @param   string  $sql    SQL command
	 * @return  boolean
	 */
	protected function _command($sql)
	{
		$this->_connection OR $this->connect();

        $query = oci_parse($this->_connection, $sql);
		if ( ! oci_execute($query)) {
            $e = oci_error();
            throw new Database_Exception($e['message']);
        }

        /*if (oci_fetch($query)) {
            echo oci_result($stid, 'LOCATION_ID') . " is ";
            echo oci_result($stid, 'CITY') . "<br>\n";
        }

		if ( ! $result = pg_get_result($this->_connection))
			throw new Database_Exception(pg_last_error($this->_connection));

		return (pg_result_status($result) === PGSQL_COMMAND_OK);*/
        return TRUE;
	}

	public function query($type, $sql, $as_object = FALSE, array $params = NULL)
	{
		$this->_connection OR $this->connect();

		if (Kohana::$profiling)
		{
			// Benchmark this query for the current instance
			$benchmark = Profiler::start("Database ({$this->_instance})", $sql);
		}

		try
		{
			if ($type === Database::INSERT AND $this->_config['primary_key'])
			{
                $s = $this->quote_identifier($this->_config['primary_key']);
				$sql .= ' RETURNING '.$s. ' INTRO :'.$s;
			}

			try
			{
                $result = oci_parse($this->_connection, $sql);

                if ($type === Database::INSERT) {
                    if ($this->_config['primary_key']) {
                        $insert_id = $this->_config['primary_key'];
                    } else {
                        $insert_id = 'id_new';
                    }
                    oci_bind_by_name($result, ':'. $insert_id, $id, -1, OCI_B_INT);
                }

                if ( ! oci_execute($result)) {
                    $e = oci_error();
                    throw new Database_Exception($e['message']);
                }
			}
			catch (Exception $e)
			{
				throw new Database_Exception(':error [ :query ]',
					array(':error' => $e->getMessage(), ':query' => $sql));
			}

			if (isset($benchmark))
			{
				Profiler::stop($benchmark);
			}

			$this->last_query = $sql;

			if ($type === Database::SELECT)
				return new Database_Oracle_Result($result, $sql, $as_object, $params, -1);

			if ($type === Database::INSERT)
			{
				return $id;
			}

			return -1;
		}
		catch (Exception $e)
		{
			if (isset($benchmark))
			{
				Profiler::delete($benchmark);
			}

			throw $e;
		}
	}

	/**
	 * Start a SQL transaction
	 *
	 * @param   string  $mode   Transaction mode
	 * @return  boolean
	 */
	public function begin($mode = NULL)
	{
		return $this->_command("BEGIN $mode");
	}

	public function commit()
	{
		return $this->_command('COMMIT');
	}

	/**
	 * Abort the current transaction or roll back to a savepoint
	 *
	 * @param   string  $savepoint  Savepoint name
	 * @return  boolean
	 */
	public function rollback($savepoint = NULL)
	{
		return $this->_command($savepoint ? "ROLLBACK TO $savepoint" : 'ROLLBACK');
	}

	/**
	 * Define a new savepoint in the current transaction
	 *
	 * @param   string  $name   Savepoint name
	 * @return  boolean
	 */
	public function savepoint($name)
	{
		return $this->_command("SAVEPOINT $name");
	}

    /**
     * @param string $type
     * @return array
     */
	public function datatype($type)
	{
		static $types = array
		(
			// Oracle >= 7.4
			'bfile'       => array('type' => 'string', 'binary' => TRUE),
            'raw'     => array('type' => 'string', 'binary' => TRUE),
			'rowid'      => array('type' => 'string'),
            'long'      => array('type' => 'string'),
            'number'     => array('type' => 'float'),
            'nvarchar2'      => array('type' => 'string'),
		);

		if (isset($types[$type]))
			return $types[$type];

		return parent::datatype($type);
	}

    /**
     * Запрос на список таблиц
     * @param null | string $like
     * @return mixed
     * @throws Database_Exception
     * @throws Exception
     */
	public function list_tables($like = NULL)
	{
		$this->_connection OR $this->connect();

		$sql = 'select table_name from ALL_TABLES WHERE 1=1';
        if(!empty($this->tablespace_name())) {
            $sql .= ' AND tablespace_name = ' . $this->quote($this->tablespace_name());
        }
		if(!empty($this->owner())) {
			$sql .= ' AND owner = ' . $this->quote($this->owner());
		}

		if (is_string($like))
		{
			$sql .= ' AND table_name LIKE '.$this->quote($like);
		}


		return $this->query(Database::SELECT, $sql, FALSE)->as_array(NULL, 'TABLE_NAME');
	}

	public function list_columns($table, $like = NULL, $add_prefix = TRUE)
	{
		$this->_connection OR $this->connect();

		$sql = 'select column_name FROM dba_tab_columns WHERE 1=1'
			.' AND table_name = '.$this->quote($add_prefix ? ($this->table_prefix().$table) : $table);
        if(!empty($this->tablespace_name())) {
            $sql .= ' AND tablespace_name = ' . $this->quote($this->tablespace_name());
        }
        if(!empty($this->owner())) {
            $sql .= ' AND owner = ' . $this->quote($this->owner());
        }

		if (is_string($like))
		{
			$sql .= ' AND column_name LIKE '.$this->quote($like);
		}

		$sql .= ' ORDER BY column_id';

		return $this->query(Database::SELECT, $sql, FALSE)->as_array(NULL, 'COLUMN_NAME');
	}

	public function schema()
	{
		return $this->_config['schema'];
	}

    public function owner()
    {
        return $this->_config['owner'];
    }

    public function tablespace_name()
    {
        return $this->_config['tablespace_name'];
    }

	public function escape($value)
	{
		$this->_connection OR $this->connect();

		$value = str_replace("'", "''", $value);

		return "'$value'";
	}
}
