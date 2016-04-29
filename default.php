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

$plain_string_options = array("options"=>array("regexp"=>"/^[A-Za-z0-9_]+$/"));
$multiword_string_options = array("options"=>array("regexp"=>"/^[A-Za-z0-9_ \.]+$/"));


$page = filter_input(INPUT_POST, "PAGE",FILTER_VALIDATE_REGEXP,$plain_string_options);
switch ($page){
    case "language__add" :
        trigger_error("");
        $language = filter_input(INPUT_POST, "LANGUAGE",FILTER_VALIDATE_REGEXP,$plain_string_options);
        trigger_error("");
        $clsdb = new cls_language($language);
        trigger_error("");
        if (!$clsdb->status){
            trigger_error("unable to add new language", E_USER_ERROR);
        }
        print _format_json(json_encode(array("language added",$clsdb->languageid)));
        break;
    case "language_list__get" :
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
    case "language_list__partial_get" :
        $clslnl = new cls_language_list();
        $partial_string = filter_input(INPUT_POST, "PARTIAL",FILTER_VALIDATE_REGEXP,$plain_string_options);
        if ($clslnl->status){
            $retval1 = $clslnl->get_partial_list($partial_string);
            if ($clslnl->assign_retval_error($retval1)){
                
            }
        } else {
            trigger_error("Error creating the list class", E_USER_ERROR);
        }
        break;
    case "author__add" :
        $author = filter_input(INPUT_POST, "AUTHOR",FILTER_VALIDATE_REGEXP,$multiword_string_options);
        $clsdb = new cls_author($author);
        if (!$clsdb->status){
            trigger_error("unable to add new author", E_USER_ERROR);
        } 
        print _format_json(json_encode(array("Author added",$clsdb->authorid)));
        break;
    case "author_list__get" :
        $clslnl = new cls_author_list();
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
    case "shelf__add" :
        $shelf = filter_input(INPUT_POST, "SHELF",FILTER_VALIDATE_REGEXP,$plain_string_options);        
        $shelf_address = filter_input(INPUT_POST, "SHELF_ADDRESS",FILTER_VALIDATE_REGEXP,$multiword_string_options);
        
        $clsdb = new cls_shelf($shelf,$shelf_address);
        if (!$clsdb->status){
            trigger_error("unable to add new shelf", E_USER_ERROR);
        }
        break;
    case "shelf_list__get" :
        $clslnl = new cls_shelf_list();
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
    case "publication__add" :
        $publication = filter_input(INPUT_POST, "PUBLICATION",FILTER_VALIDATE_REGEXP,$plain_string_options);        
        $publication_series = filter_input(INPUT_POST, "PUBLICATION_SERIES",FILTER_VALIDATE_REGEXP,$plain_string_options);
        
        $clsdb = new cls_publication($publication,$publication_series);
        if (!$clsdb->status){
            trigger_error("unable to add new publication", E_USER_ERROR);
        }
        break;
    case "publication_list__get" :
        $clslnl = new cls_publication_list();
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
    case "book__add" :
        $book = filter_input(INPUT_POST, "BOOK",FILTER_VALIDATE_REGEXP,$plain_string_options);        
        $publicationid = filter_input(INPUT_POST, "PUBLICATIONID",FILTER_VALIDATE_INT);
        $authorid = filter_input(INPUT_POST, "AUTHORID",FILTER_VALIDATE_INT);
        $shelfid = filter_input(INPUT_POST, "SHELFID",FILTER_VALIDATE_INT);
        $publication_series = filter_input(INPUT_POST, "PUBLICATION_SERIES",FILTER_VALIDATE_REGEXP,$multiword_string_options);
       $clsdb = new cls_book($book,$publicationid,$authorid,$shelfid,$publication_series);
        if (!$clsdb->status){
            trigger_error("unable to add new book", E_USER_ERROR);
        }
        break;
    case "book_list__get" :
        $clslnl = new cls_book_list();
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
        
        
    
}
