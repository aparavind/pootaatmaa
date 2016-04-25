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
function myErrorHandler($errno, $errstr, $errfile, $errline){
    
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }
    
    switch ($errno) {
    case E_USER_ERROR:
        $error["system_error"] = $GLOBALS["error"];
        $error["error_description"] = $GLOBALS["error_description"];
        $error["file"] = $errfile;
        $error["lineno"] = $errline;
        $error["errstr"] = $errstr;
        $error["error"] = $errno;
        print _format_json(json_encode($error),TRUE);
        exit($errno);
        break;

    case E_USER_WARNING:
        echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
        break;

    case E_USER_NOTICE:
        echo "<b>My NOTICE</b> [$errno] $errstr [$errfile], $errline<br />\n";
        error_log("<b>My NOTICE</b> [$errno] $errstr [$errfile], $errline<br />\n");
        break;

    default:
        echo "Unknown error type: [$errno] $errstr<br />\n";
        break;
    }

    /* Don't execute PHP internal error handler */
    return true;
}

// set to the user defined error handler
/* @var $old_error_handler string */
$old_error_handler = set_error_handler("myErrorHandler");
