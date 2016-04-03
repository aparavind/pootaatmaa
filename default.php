<!DOCTYPE html>
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

switch ($_REQUEST["PAGE"]){
    case "add_language" :
        $clsdb = new cls_language($_REQUEST["LANGUAGE"]);
        print_r($clsdb);
        break;
}

?>