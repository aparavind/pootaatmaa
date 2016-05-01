<?php

/* 
 * Copyright (C) 2016 aravind
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

function book($activity,$subactivity){
    if ($activity != 'book'){
        trigger_error("FUNCTION NOT MATCHED",E_USER_ERROR);
    }

    $book = filter_input(INPUT_POST, "BOOK",FILTER_VALIDATE_REGEXP,$GLOBALS["plain_string_options"]);
    $publicationid = filter_input(INPUT_POST, "PUBLICATIONID",FILTER_VALIDATE_INT);
    $authorid = filter_input(INPUT_POST, "AUTHORID",FILTER_VALIDATE_INT);
    $shelfid = filter_input(INPUT_POST, "SHELFID",FILTER_VALIDATE_INT);
    $publication_series = filter_input(INPUT_POST, "PUBLICATION_SERIES",FILTER_VALIDATE_REGEXP,$multiword_string_options);
    $clsdb = new cls_book($book,$publicationid,$authorid,$shelfid,$publication_series);

    if (!$clsdb->status){
        trigger_error("unable to add new book", E_USER_ERROR);
    }
    
    switch ($subactivity){
        case "add" :
            return book__add($clsdb);
    }
}

function book__add($clsdb){
    $retval["status"] = TRUE;
    $retval["retval"] = array("Book added",$clsdb->bookid);
    return $retval;
}

function book_list($activity,$subactivity){
    if ($activity != 'book_list'){
        trigger_error("FUNCTION NOT MATCHED",E_USER_ERROR);
    }

    $clsnl = new cls_book_list();
    
    if (!$clsnl["status"]){
        trigger_error("Error creating book list class",E_USER_ERROR);
    }
    
    switch ($subactivity){
        case "get" :
            return book_list__get($clsnl);
    }
}


function book_list__get($clsnl){
    $retval1 = $clsnl->populate_list();
    if (!$retval1["status"]){
        trigger_error("Error populating list", E_USER_ERROR);
    } else {
        return array($clsnl->id_list);
    }
}



