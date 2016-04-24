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
 * Description of cls_publication
 *
 * @publication admin
 */
require_once dirname(__FILE__) . "/cls_dbcon.php";
class cls_publication extends cls_dbcon {
    /**
     *
     * @var string
     */
    public $current_publication;
    
    /**
     *
     * @var int
     */
    public $publicationid;
    
    /**
     * values are 
     * 1 : create publication
     * 2 : delete publication
     * 3 : add publication
     * 4 : check publication exists
     * @var int
     */
    public $last_action;
    
    public function __construct($publication,$publication_series = NULL) {
        $this->tableName = "db_publication_master";
        parent::__construct();
        $rval2 = $this->exists($publication);
        if ($this->assign_retval_error($rval2)){
            if (! $rval2["retval"]["status"]){

                $rval = $this->create_publication($publication,$publication_series);
                $this->assign_retval_error($rval);
            }
        } else {
            $GLOBALS["error"] = $this->error;
            $GLOBALS["error_description"] = $this->error_description;
        }
    }
    
    public function exists($publication){
        $query = "select publicationid from db_publication_master where publication = '$publication'";
        $retval["status"] = false;
        $rval = $this->query($query);
        if ($rval["status"]){
            $this->status = 4;   // assuming the publication is not created
            $retval["status"] = true;  // As the query has suceeded
            $rval2 = $this->fetch_row();
            if ($rval2["status"]){
                $this->publicationid = $rval2["retval"][0];
                $this->status = 1;
                $retval["retval"]["publicationid"] = $rval2["retval"][0];
                $retval["retval"]["status"] = TRUE;
            } else {
                $retval["retval"]["status"] = FALSE;
            } 
        } else {
            $retval = $rval;
        }
        $this->last_action = 4;
        return $retval;
        
    }
    
    public function create_publication($publication,$publication_series = ""){
        $this->last_action = 1;
        $names[] = "publication";
        $values[] = "'$publication'";
        if ($publication_series) {
            $names[] = "publication_series";
            $values[] = "'$publication_series'";
        }
        $query = "insert into  db_publication_master (". 
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
                $this->publicationid = $rval2["rval"];
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
