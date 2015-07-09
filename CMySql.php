<?php

class CMySql
{	
	private $connect = "";
	private $con = false;
	private $result = array();
	private $numResults = 0;
	
	public function CMySql($hostname, $username, $password)
	{
		$this->connect = @new mysqli($hostname, $username, $password);
		if( $this->connect->connect_error ) {
			die('Connect Error (' . $this->connect->connect_errno  . ') ' . $this->connect->connect_error );
		}
		$this->con = true;
	}
	
	public function disconnect()
	{
		if($this->con)
    	{
			$this->connect->close();
			$this->con = false;
			return true;
		}else
			return false;	
	}
	
	public function escape_string($str)
	{
		if($this->con)
    	{
			return $this->connect->real_escape_string($str);
		}else
			return false;	
	}
	
	private function tableExists($db, $table)
    {
        $tablesInDb = @$this->connect->query('SHOW TABLES FROM `'.$db.'` LIKE "'.$table.'"');
		
        if($tablesInDb)
        {
            if($tablesInDb->num_rows == 1)
                return true; 
			else{
				echo "Can't find table '".$table."' in ".$db;
                return false; 
				}
        }
    }
	
	public function selectRow($db, $table, $rows = '*', $where = null, $order = null)
	{
        if( $this->tableExists($db, $table) )
		{
			$q = 'SELECT '.$rows.' FROM `'.$db.'`.`'.$table.'`';
			if($where != null) $q .= ' WHERE '.$where;
			if($order != null) $q .= ' ORDER BY '.$order;

        	$query = $this->connect->query($q);
			
			$this->numResults = $query->num_rows;
        	if($this->numResults > 0)
        	{
                $r =  $query->fetch_array(MYSQLI_ASSOC);        
            	return $r; 
        	}
        }
      		return false; 
	}
	
	public function select($db, $table, $rows = '*', $where = null, $order = null, $limit = null)
	{
		if( $this->tableExists($db, $table) )
		{
			$q = 'SELECT '.$rows.' FROM `'.$db.'`.`'.$table.'`';
			if($where != null) $q .= ' WHERE '.$where;
			if($order != null) $q .= ' ORDER BY '.$order;
			if($limit != null) $q .= ' LIMIT '.$limit;
			
			$query = $this->connect->query($q);
			
			$this->numResults = $query->num_rows;
			if( $this->numResults >0 )
			{
				$this->result = null;
            	for($i = 0; $i < $this->numResults; $i++)
            	{
					$r =  $query->fetch_array();
					$key = array_keys($r); 
					for($x = 0; $x < count($key); $x++)
					{
						// Sanitizes keys so only alphavalues are allowed
						if(!is_int($key[$x]))
						{
							if( $query->num_rows > 1)
								$this->result[$i][$key[$x]] = $r[$key[$x]];
							else if($query->num_rows < 1)
								$this->result = null; 
							else
								$this->result[$key[$x]] = $r[$key[$x]]; 
						}
                	}
            	}         
				$query->free();   
            	return  $this->result; 
        	}
        }
		else
      		return false; 
	}
	
	public function num_rows()
	{
		return $this->numResults;
	}
	
	public function insert($db, $table,$values,$rows = null)
    {
        if( $this->tableExists($db, $table) )
        {
            $insert = 'INSERT INTO `'.$db.'`.`'.$table.'`';
            if($rows != null) $insert .= ' ('.$rows.')'; 
 
            for($i = 0; $i < count($values); $i++)
            {
                if(is_string($values[$i]))
                    $values[$i] = '"'.$values[$i].'"';
            }
            $values = implode(',',$values);
            $insert .= ' VALUES ('.$values.')';
            $ins = @$this->connect->query($insert);            
            if($ins) return true; 
        }
		return false; 
    }
	
	public function delete($db, $table,$where = null)
    {
        if( $this->tableExists($db, $table) )
        {
            if($where == null)
                $delete = 'DELETE `'.$db.'`.`'.$table.'`';
            else
                $delete = 'DELETE FROM `'.$db.'`.`'.$table.'` WHERE '.$where; 

            $del = $this->connect->query($delete);
            if($del) return true; 
        }
        else
            return false; 
    }
	
	public function update($db, $table, $rows, $where)
    {
        if( $this->tableExists($db, $table) )
        {
            // Parse the where values
            // even values (including 0) contain the where rows
            // odd values contain the clauses for the row
            for($i = 0; $i < count($where); $i++)
            {
                if($i%2 != 0)
                {
                    if(is_string($where[$i]))
                    {
                        if(($i+1) != null)
                            $where[$i] = '"'.$where[$i].'" AND ';
                        else
                            $where[$i] = '"'.$where[$i].'"';
                    }
                }
            }
            $where = implode('=',$where);
             
            $update = 'UPDATE `'.$db.'`.`'.$table.'` SET ';
            $keys = array_keys($rows); 
			
            for($i = 0; $i < count($rows); $i++)
           	{
                if(is_string($rows[$keys[$i]]))
                {
                    $update .= $keys[$i].'="'.$rows[$keys[$i]].'"';
                }
                else
                {
                    $update .= $keys[$i].'='.$rows[$keys[$i]];
                }
                 
                // Parse to add commas
                if($i != count($rows)-1)
                {
                    $update .= ','; 
                }
            }
            $update .= ' WHERE '.$where;
            $query = @$this->connect->query($update);
            if($query)  return true; 
        }
        else
            return false; 
    }
	
}

/*
$aa = new CMySql('localhost', 'root', '123456');
$row = $aa->select("ragnarok","login",'*');
print_r($row);
$aa->disconnect();
*/
?>

