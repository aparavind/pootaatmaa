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

function shelf($activity,$subactivity){
    if ($activity != 'shelf'){
        trigger_error("FUNCTION NOT MATCHED",E_USER_ERROR);
    }

    $shelf = filter_input(INPUT_POST, "SHELF",FILTER_VALIDATE_REGEXP,$GLOBALS["plain_string_options"]);
    $shelf_address = filter_input(INPUT_POST, "SHELF_ADDRESS",FILTER_VALIDATE_REGEXP,$GLOBALS["multiword_string_options"]);
    $clsdb = new cls_shelf($shelf,$shelf_address);

    if (!$clsdb->status){
        trigger_error("unable to add new shelf", E_USER_ERROR);
    }
    
    switch ($subactivity){
        case "add" :
            return shelf__add($clsdb);
    }
}

function shelf__add($clsdb){
    $retval["status"] = TRUE;
    $retval["retval"] = array("Shelf added",$clsdb->shelfid);
    return $retval;
}

function shelf_list($activity,$subactivity){
    if ($activity != 'shelf_list'){
        trigger_error("FUNCTION NOT MATCHED",E_USER_ERROR);
    }

    $clsnl = new cls_shelf_list();
    
    if (!$clsnl["status"]){
        trigger_error("Error creating shelf list class",E_USER_ERROR);
    }
    
    switch ($subactivity){
        case "get" :
            return shelf_list__get($clsnl);
    }
}


function shelf_list__get($clsnl){
    $retval1 = $clsnl->populate_list();
    if (!$retval1["status"]){
        trigger_error("Error populating list", E_USER_ERROR);
    } else {
        return array($clsnl->id_list);
    }
}


