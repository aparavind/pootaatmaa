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
 * Description of cls_language
 *
 * @author admin
 */
require_once dirname(__FILE__) . "/cls_dbcon.php";
class cls_language extends cls_dbcon {
    /**
     *
     * @var string
     */
    public $current_language;
    
    /**
     *
     * @var int
     */
    public $languageid;
    
    /**
     * values are 
     * 1 : create language
     * 2 : delete language
     * 3 : add language
     * 4 : check language exists
     * @var int
     */
    public $last_action;
    
    public function __construct($language) {
        $this->tableName = "db_language_master";
        parent::__construct();
        $rval2 = $this->exists($language);
        if ($this->assign_retval_error($rval2)){
            if (! $rval2["retval"]["languageid"]){
                $rval = $this->create_language($language);
                $this->assign_retval_error($rval);
            }
        } else {
            $GLOBALS["error"] = $this->error;
            $GLOBALS["error_description"] = $this->error_description;
            trigger_error("Unable to query language table", E_USER_ERROR);
        }
    }
    
    public function exists($language){
        $query = "select languageid from db_language_master where language = '$language'";
        $retval["status"] = false;
        $rval = $this->query($query);
        if ($rval["status"]){
            $this->status = 4;   // assuming the language is not created
            $retval["status"] = true;  // As the query has suceeded
            $rval2 = $this->fetch_row();
            if ($rval2["status"]){
                $this->languageid = $rval2["retval"][0];
                $this->status = 1;
                $retval["retval"]["languageid"] = $rval2["retval"][0];
            } 
        } else {
            $retval = $rval;
        }
        $this->current_language = $language;
        $this->last_action = 4;
        return $retval;
        
    }
    
    public function create_language($language){
        $this->last_action = 1;
        $query = "insert into  db_language_master (language) values('$language')";
        $retval["status"] = false;
        $rval = $this->query($query);
        if ($rval["status"]){
            $rval2 = $this->last_insert_id();
            if ($rval2["status"]){
                $this->status = 2;
                $retval["status"] = true;
                $retval["rval"] = $rval2["rval"];
                $this->languageid = $rval2["rval"];
            } else {
                $this->status = 0;
                $retval = $rval2;
            }
        } else {
            $this->status = 0;
            $retval = $rval;
        } 
        return $retval;        
    }
}
