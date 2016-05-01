<?php
ob_start();
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
include_once dirname(__FILE__) . '/cls_author_list.php';
include_once dirname(__FILE__) . '/cls_author.php';
include_once dirname(__FILE__) . '/cls_shelf_list.php';
include_once dirname(__FILE__) . '/cls_shelf.php';

include_once dirname(__FILE__) . '/language_funcs.php';
include_once dirname(__FILE__) . "./author_funcs.php";
include_once dirname(__FILE__) . "./shelf_funcs.php";
include_once dirname(__FILE__) . "./publication_funcs.php";
include_once dirname(__FILE__) . "./book_funcs.php";

$page = filter_input(INPUT_POST, "PAGE",FILTER_VALIDATE_REGEXP,$plain_string_options);

$activity = split("__",$page);
$parent = $activity[0];

$out_array = call_user_func($activity[0],$activity);
if (!$out_array["status"]){
    trigger_error("Unable to get the out string");
}
print _format_json(json_encode($out_array["retval"]));
