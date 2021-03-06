<?php

/*
 * Copyright (C) 2016 admin
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Description of cls_dbcon
 *
 * @author admin
 */

class cls_dbcon extends cls_funcs {
    //put your code here
    
    /**
     *
     * @var /mysqli
     */
    public $mysqli;
    
    /**
     *
     * @var mysqli_result
     */
    public $resultset;
    
    
    function __construct() {
        parent::__construct();
        
        $this->mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_database);
        if ($this->mysqli->connect_errno){
            trigger_error($this->mysqli->connect_errno, E_USER_ERROR);
        }
    }
    
    /**
     * 
     * @param string $query
     * @return resultset or false on error
     */
    function query($query){
        $retval = array();
        $this->resultset = $this->mysqli->query($query);
        if (!$this->resultset){
            $retval["status"] = false;
            $retval["error"] = $this->mysqli->errno;
            $retval["error_description"] = $this->mysqli->error;
        } else {
            $retval["status"] = true;
        }
        return $retval;
    }
    
    
    function fetch_row(){
        $retval = array();
        $row = $this->resultset->fetch_row();
        if (!$row){
            $retval["status"] = false;
        } else {
            $retval["status"] = true;
            $retval["retval"] = $row;
        }
        return $retval;
    }
    
    function last_insert_id(){
        $rval["status"] = false;
        $stat = $this->mysqli->insert_id;
        if ($stat){
            $rval["status"] = true;
            $rval["rval"] = $stat;
        }
        return $rval;
    }
    
    
}
