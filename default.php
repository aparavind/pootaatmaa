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
require_once dirname(__FILE__) . "/lib.php";
require_once dirname(__FILE__) . "/config.php";
require_once dirname(__FILE__) . "/cls_configuration.php";
require_once dirname(__FILE__) . "/cls_funcs.php";
include_once dirname(__FILE__) . '/cls_dbcon.php';
include_once dirname(__FILE__) . "/cls_language.php";
include_once dirname(__FILE__) . "/error_handler.php";
include_once dirname(__FILE__) . '/cls_language_list.php';

switch ($_REQUEST["PAGE"]){
    case "add_language" :
        $clsdb = new cls_language($_REQUEST["LANGUAGE"]);
        if (!$clsdb->status){
            trigger_error("unable to add new language", E_USER_ERROR);
        }
        break;
    case "get_language_list" :
        $clslnl = new cls_language_list();
        if ($clslnl->status){
            $retval1 = $clslnl->populate_list();
            if (!$retval1["status"]){
                trigger_error("Error populating list", E_USER_ERROR);
            } else {
                print _format_json(json_encode($clslnl->id_list));
            }
        } else {
            trigger_error("Error creating the list class", E_USER_ERROR);
        }
        break;
    case "partial_language_list" :
        $clslnl = new cls_language_list();
        if ($clslnl->status){
            $retval1 = $clslnl->get_partial_list($_REQUEST["PARTIAL"]);
            if ($clslnl->assign_retval_error($retval1)){
                
            }
        } else {
            trigger_error("Error creating the list class", E_USER_ERROR);
        }
    
}

?>