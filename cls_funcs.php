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
 * Description of class_funcs
 *
 * @author admin
 */


class cls_funcs extends configuration {
    //put your code here
    public $tableName;

    /**
     *values are
     * 0 -> error
     * 1 -> already exists
     * 2 -> created
     * 3 -> deleted
     * 4 -> not yet created
     * @var int
     */
    public $status;
    
    /**
     *
     * @var int this is the last returned error 
     */
    public $error;
    
    /**
     *
     * @var string description of error
     */
    public $error_description;
    
   
    public function assign_retval_error($retval){
        if ($retval["status"]){
            $this->error = 0;
            $this->error_description = "";
            return true;
        } else {
            $this->error = $retval["error"];
            $this->error_description = $retval["error_description"];
        }
    }
    
}
