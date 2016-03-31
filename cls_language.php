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
class cls_language extends cls_dbcon {
    //put your code here
    public $tableName;
    
    public $current_language;
    
    public $languageid;
    
    public function __construct($language) {
        $this->tableName = "db_language_master";
        parent::__construct();
        if (! $this->exists($language)["status"]){
            $this->create_language($language);
        }
        
    }
    
    public function exists($language){
        $query = "select languageid from db_language_master where language = $language";
        $retval["status"] = false;
        $rval = $this->query($query);
        if ($rval["status"]){
            $rval2 = $this->fetch_row();
            if ($rval2["status"]){
                $retval["status"] = true;
                $this->languageid = $rval2["retval"][0];
                $this->current_language = $language;
            } 
        }
        return $retval;
    }
    
    public function create_language($language){
        $query = "insert into  db_language_master (language) values('$language')";
        $retval["status"] = false;
        $rval = $this->query($query);
        if ($rval["status"]){
            $rval3 = $this->last_insert_id();
            if ($rval2["status"]){
                $retval["status"] = true;
                $retval["rval"] = $rval3["rval"];
            }
        } else {
            print "the return val is {$rval["error_string"]}";
        }
        return $retval;        
    }
}
