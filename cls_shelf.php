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
 * Description of cls_shelf
 *
 * @shelf admin
 */
require_once dirname(__FILE__) . "/cls_dbcon.php";
class cls_shelf extends cls_dbcon {
    /**
     *
     * @var string
     */
    public $current_shelf;
    
    /**
     *
     * @var int
     */
    public $shelfid;
    
    /**
     * values are 
     * 1 : create shelf
     * 2 : delete shelf
     * 3 : add shelf
     * 4 : check shelf exists
     * @var int
     */
    public $last_action;
    
    public function __construct($shelf,$shelf_location = NULL) {
        $this->tableName = "db_shelf_master";
        parent::__construct();
        $rval2 = $this->exists($shelf);
        if ($this->assign_retval_error($rval2)){
            if (! $rval2["retval"]["status"]){

                $rval = $this->create_shelf($shelf,$shelf_location);
                $this->assign_retval_error($rval);
            }
        } else {
            $GLOBALS["error"] = $this->error;
            $GLOBALS["error_description"] = $this->error_description;
        }
    }
    
    public function exists($shelf){
        $query = "select shelfid from db_shelf_master where shelf = '$shelf'";
        $retval["status"] = false;
        $rval = $this->query($query);
        if ($rval["status"]){
            $this->status = 4;   // assuming the shelf is not created
            $retval["status"] = true;  // As the query has suceeded
            $rval2 = $this->fetch_row();
            if ($rval2["status"]){
                $this->shelfid = $rval2["retval"][0];
                $this->status = 1;
                $retval["retval"]["shelfid"] = $rval2["retval"][0];
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
    
    public function create_shelf($shelf,$shelf_location = ""){
        $this->last_action = 1;
        $names[] = "shelf";
        $values[] = "'$shelf'";
        if ($shelf_location) {
            $names[] = "shelf_address";
            $values[] = "'$shelf_location'";
        }
        $query = "insert into  db_shelf_master (". 
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
                $this->shelfid = $rval2["rval"];
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
