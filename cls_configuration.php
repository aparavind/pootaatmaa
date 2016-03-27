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
 * This stores the global variables. 
 * At presnet it just stores the variables as it is
 *
 * @author admin
 */
require_once dirname(__FILE__) . "/config.php";
class configuration {
    //put your code here
    
    /**
     * this is the mysql host. 
     * we can consider different hosts for different set ups
     * @var string
     */
    public $db_host;
    /**
     *
     * @var string
     */
    public $db_user;
    /**
     *
     * @var string
     */
    public $db_pass;
    
    /**
     *
     * @var string
     */
    public $db_database;
    
    
    public function __construct() {
        $this->db_database = $this->get_var("DBNAME");
        $this->db_host = $this->get_var("DBHOST");
        $this->db_pass = $this->get_var("DBPASS");
        $this->db_user = $this->get_var("DBUSER");
    }
    
    public static function get_var($varname){
        if ($GLOBALS[$varname]){
            return $GLOBALS[$varname];
        } else {
            return null;
        }
    }
}
