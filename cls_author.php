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
 * Description of cls_author
 *
 * @author admin
 */
require_once dirname(__FILE__) . "/cls_dbcon.php";
class cls_author extends cls_dbcon {
    /**
     *
     * @var string
     */
    public $current_author;
    
    /**
     *
     * @var int
     */
    public $authorid;
    
    /**
     * values are 
     * 1 : create author
     * 2 : delete author
     * 3 : add author
     * 4 : check author exists
     * @var int
     */
    public $last_action;
    
    public function __construct($author) {
        $this->tableName = "db_author_master";
        parent::__construct();
        $rval2 = $this->exists($author);
        if ($this->assign_retval_error($rval2)){
            if (! $rval2["retval"]["authorid"]){
                $rval = $this->create_author($author);
                $this->assign_retval_error($rval);
            }
        } else {
            $GLOBALS["error"] = $this->error;
            $GLOBALS["error_description"] = $this->error_description;
            trigger_error("Unable to query author table", E_USER_ERROR);
        }
    }
    
    public function exists($author){
        $query = "select authorid from db_author_master where author = '$author'";
        $retval["status"] = false;
        $rval = $this->query($query);
        if ($rval["status"]){
            $this->status = 4;   // assuming the author is not created
            $retval["status"] = true;  // As the query has suceeded
            $rval2 = $this->fetch_row();
            if ($rval2["status"]){
                $this->authorid = $rval2["retval"][0];
                $this->status = 1;
                $retval["retval"]["authorid"] = $rval2["retval"][0];
                $retval["retval"]["status"] = true;
            } else {
                $retval["retval"]["status"] = false;
            }
        } else {
            $retval = $rval;
        }
        $this->current_author = $author;
        $this->last_action = 4;
        return $retval;
        
    }
    
    public function create_author($author,$author_application = ""){
        $this->last_action = 1;
        $names[] = "author";
        $values[] = "'$author'";
        if ($author_application) {
            $names[] = "author_application";
            $values[] = "'$author_application'";
        }
        $query = "insert into  db_author_master (". 
                implode(",", $names).
                ") values(".
                implode(",",$values) .
                ")";
        $retval["status"] = false;
        $rval = $this->query($query);
        if ($rval["status"]){
            $rval2 = $this->last_insert_id();
            if ($rval2["status"]){
                $this->status = 2;
                $retval["status"] = true;
                $retval["rval"] = $rval2["rval"];
                $this->authorid = $rval2["rval"];
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
