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
 * Description of cls_book
 *
 * @book admin
 */
require_once dirname(__FILE__) . "/cls_dbcon.php";
class cls_book extends cls_dbcon {
    /**
     *
     * @var string
     */
    public $current_book;
    
    /**
     *
     * @var int
     */
    public $bookid;
    
    /**
     * values are 
     * 1 : create book
     * 2 : delete book
     * 3 : add book
     * 4 : check book exists
     * @var int
     */
    public $last_action;
    
    public function __construct($book,$book_series = NULL) {
        $this->tableName = "db_book_master";
        parent::__construct();
        $rval2 = $this->exists($book);
        if ($this->assign_retval_error($rval2)){
            if (! $rval2["retval"]["status"]){

                $rval = $this->create_book($book,$book_series);
                $this->assign_retval_error($rval);
            }
        } else {
            $GLOBALS["error"] = $this->error;
            $GLOBALS["error_description"] = $this->error_description;
        }
    }
    
    public function exists($book){
        $query = "select bookid from db_book_master where book = '$book'";
        $retval["status"] = false;
        $rval = $this->query($query);
        if ($rval["status"]){
            $this->status = 4;   // assuming the book is not created
            $retval["status"] = true;  // As the query has suceeded
            $rval2 = $this->fetch_row();
            if ($rval2["status"]){
                $this->bookid = $rval2["retval"][0];
                $this->status = 1;
                $retval["retval"]["bookid"] = $rval2["retval"][0];
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
   /*
    *     book varchar(255) not null unique key,
    publicationid int(11) ,
    authorid int(11) , 
    shelfid int(11) ,
    publication_series varchar(255),

    */ 
    public function create_book($book,$publicationid  = 0,$authorid = 0,$shelfid = 0,$publication_series = ""){
        $this->last_action = 1;
        $names[] = "book";
        $values[] = "'$book'";
        if ($publicationid) {
            $names[] = "publicationid";
            $values[] = "'$publicationid'";
        }
        if ($authorid) {
            $names[] = "authorid";
            $values[] = "'$authorid'";
        }
        if ($shelfid) {
            $names[] = "shelfid";
            $values[] = "'$shelfid'";
        }
        if ($publication_series) {
            $names[] = "publicationseries";
            $values[] = "'$publication_series'";
        }
        $query = "insert into  db_book_master (". 
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
                $this->bookid = $rval2["rval"];
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
