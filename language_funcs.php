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

function language($activity,$subactivity){
    if ($activity != 'language'){
        trigger_error("FUNCTION NOT MATCHED",E_USER_ERROR);
    }
    
    $language = filter_input(INPUT_POST, "LANGUAGE",FILTER_VALIDATE_REGEXP,$GLOBALS["plain_string_options"]);
    $clsdb = new cls_language($language);

    if (!$clsdb->status){
        trigger_error("unable to add new language", E_USER_ERROR);
    }

    
    switch ($subactivity){
        case "add":
            return language__add($clsdb);
    }
}


function language__add($clsdb){
    $retval["status"] = true;
    $retval["retval"] = array("language added",$clsdb->languageid);
    return $retval;
}


function language_list($activity,$subactivity){
   
    // Trigger Error and exit if activity is not proper
    if ($activity != 'language_list'){
        trigger_error("FUNCTION NOT MATCHED",E_USER_ERROR);
    }
    
    // New language list class
    $clslnl = new cls_language_list();
    if (! $clslnl->status){
        trigger_error("Error creating the list class", E_USER_ERROR);
    }
    
    switch ($subactivity){
        case "get":
            return language_list__get($clslnl);
        case "partial_get" :
            return language_list__partial_get($clslnl);
    }
}

function language_list__get($clslnl){
    $retval1 = $clslnl->populate_list();
    if (!$retval1["status"]){
        trigger_error("Error populating list", E_USER_ERROR);
    }
    $retval["status"] = true;
    $retval["retval"] = array($clslnl->id_list);
    return $retval;
}


function language_list__partial_get($clslnl){
    $partial_string = filter_input(INPUT_POST, "PARTIAL",FILTER_VALIDATE_REGEXP,$GLOBALS["plain_string_options"]);
    return  $clslnl->get_partial_list($partial_string);
}    

