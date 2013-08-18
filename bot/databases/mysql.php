<?php
/*
+---------------------------------------------------------------------------
|   PHP-IRC v2.2.0
|   ========================================================
|   by Manick
|   (c) 2001-2005 by http://phpbots.sf.net/
|   Contact: manick@manekian.com
|   irc: #manekian@irc.rizon.net
|   ========================================
+---------------------------------------------------------------------------
|   > database module
|   > Module written by Manick
|   > Module Version Number: 2.2.0 alpha1
+---------------------------------------------------------------------------
|   > This program is free software; you can redistribute it and/or
|   > modify it under the terms of the GNU General Public License
|   > as published by the Free Software Foundation; either version 2
|   > of the License, or (at your option) any later version.
|   >
|   > This program is distributed in the hope that it will be useful,
|   > but WITHOUT ANY WARRANTY; without even the implied warranty of
|   > MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
|   > GNU General Public License for more details.
|   >
|   > You should have received a copy of the GNU General Public License
|   > along with this program; if not, write to the Free Software
|   > Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
+---------------------------------------------------------------------------
|   Changes
|   =======-------
|   > If you wish to suggest or submit an update/change to the source
|   > code, email me at manick@manekian.com with the change, and I
|   > will look to adding it in as soon as I can.
+---------------------------------------------------------------------------
*/

class mysql {

	private $dbIndex;
	private $prefix;
	private $queries = 0;
	private $isConnected = false;
	
	public $user;
	public $pass;
	public $database;
	public $host;
	public $port;

	public function __construct($host, $database, $user, $pass, $prefix, $port = 3306)
	{
		$this->user = $user;
		$this->pass = $pass;
		$this->host = $host;
		$this->database = $database;
		$this->port = $port;
		$this->prefix = $prefix;

		$this->reconnect();
	}

	public function reconnect()
	{
		$db = mysql_connect($this->host . ":" . $this->port, $this->user, $this->pass, true);

		if ($db === false)
		{
			return;
		}

		$dBase = mysql_select_db($this->database, $db);

		if ($dBase === false)
		{
			return;
		}

		$this->dbIndex = $db;
		$this->isConnected = true;
	}

	public function getError()
	{
		return (@mysql_error($this->dbIndex));
	}

	public function isConnected()
	{
		return $this->isConnected;
	}

	private function fixVar($id, $values)
	{
		return mysql_real_escape_string($values[intval($id)-1], $this->dbIndex);
	}

	public function query($query, $values = array())
	{
		if (!is_resource($this->dbIndex))
		{
			echo "DB not index, trying to reconnect...\n";
			$this->reconnect();
		}

		if (!is_array($values))
			$values = array($values);
		
		$query = preg_replace('/\[([0-9]+)]/e', "\$this->fixVar(\\1, &\$values)", $query);

		$data = false;
		$i = 1;

		while ($data === false)
		{
			$data = mysql_query($query, $this->dbIndex);

			if ($data === false)
			{
				echo $this->getError();
				echo "Trying to reconnect... is connection dead?\n";
				$this->reconnect();
			}
			else
			{
				break;
			}
			$i++;

			if ($i == 4)
			{
				echo "Could not connected after 3 attempts.. giving up.\n";
				break;
			}
		}

		$this->queries++;

		return $data;
	}


	public function queryFetch($query, $values = array())
	{

		if (!is_array($values))
			$values = array($values);

		$query = preg_replace('/\[([0-9]+)]/e', "\$this->fixVar(\\1, &\$values)", $query);
	
		$this->queries++;
		
		$data= mysql_query($query, $this->dbIndex);

		if (!$data)
		{
			return false;
		}

    	return mysql_fetch_array($data);
	}


	public function fetchArray($toFetch)
	{
  		return mysql_fetch_array($toFetch);
	}
 
	public function fetchObject($toFetch)
	{
  		return mysql_fetch_object($toFetch);
	}

	public function fetchRow($toFetch)
	{
		return mysql_fetch_row($toFetch);
	}

	public function close()
	{
		@mysql_close($this->dbIndex);
	}

	public function lastID()
	{
		return mysql_insert_id();
	}

	public function numRows($toFetch)
	{
		return mysql_num_rows($toFetch);
	}

	public function numQueries()
	{
		return $this->queries;
	}

}

?>
