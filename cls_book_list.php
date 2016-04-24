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
 * Description of cls_book_list
 *
 * @book admin
 */
class cls_book_list extends cls_dbcon{
    //put your code here
    
    /**
     * Array of all the books the key is book name and value id
     * @var cls_book[]
     */
    public $book_list;
    
    /**
     * Array of all the book key is id and value is name
     * @var 
     */
    public $id_list;
    
    /**
     * Array of all the book key is id and value is object
     * @var type 
     */
    public $obj_list;
    
    /**
     * This is the status of object values are
     * 1 -> list generated
     * 0 -> error
     * 2 -> empty object
     * @var type 
     */
    public $status;
    
    /**
     *  simple constructor which initialized empty array
     */
    public function __construct() {
        parent::__construct();
        $this->book_list = array();
        $this->id_list = array();
        $this->obj_list = array();
        $this->status = 2;
   }
   
   public function populate_list(){
       $query = "select book,bookid,book_series from db_book_master";
       $retval = $this->query($query);
       $rval["status"] = true;
       if ($this->assign_retval_error($retval)){
           $retval2 = $this->fetch_row();
           while ($retval2["status"]){
               $row = $retval2["retval"];
               $this->book_list[$row[0]]["book_name"] = $row[1];
               $this->id_list[$row[1]]["book_id"] = $row[0];
               $this->book_list[$row[0]]["book_series"] = $row[2];
               $this->id_list[$row[1]]["book_series"] = $row[2];
               $retval2 = $this->fetch_row();
           }
       } else {
           $rval = $retval;
       }
       return $rval;
   }
   
   /**
    * THis gets 5 books based on the frist string
    * @param string $str
    */
   public function get_partial_list($str){
       $cma = "";
       foreach ($this->book_list as $value) {
           if (preg_match("/$str/", $value)){
               print $cma . $value;
           } else {
               $cma = ",";
           }
       }
   }
}
