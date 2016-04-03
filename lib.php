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
 * Formats a JSON string for pretty printing
 *
 * @param string $json The JSON to make pretty
 * @param bool $html Insert nonbreaking spaces and <br />s for tabs and linebreaks
 * @return string The prettified output
 * @link https://gist.github.com/GloryFish/1045396
 * @author Jay Roberts
 */
 function _format_json($json, $html = false) {
        $tabcount = 0; 
        $result = ''; 
        $inquote = false; 
        $ignorenext = false; 
        if ($html) { 
            $tab = "&nbsp;&nbsp;&nbsp;"; 
            $newline = "<br/>"; 
        } else { 
            $tab = "\t"; 
            $newline = "\n"; 
        } 
        for($i = 0; $i < strlen($json); $i++) { 
            $char = $json[$i]; 
            if ($ignorenext) { 
                $result .= $char; 
                $ignorenext = false; 
            } else { 
                switch($char) { 
                    case '{': 
                        $tabcount++; 
                        $result .= $char . $newline . str_repeat($tab, $tabcount); 
                        break; 
                    case '}': 
                        $tabcount--; 
                        $result = trim($result) . $newline . str_repeat($tab, $tabcount) . $char; 
                        break; 
                    case ',': 
                        $result .= $char . $newline . str_repeat($tab, $tabcount); 
                        break; 
                    case '"': 
                        $inquote = !$inquote; 
                        $result .= $char; 
                        break; 
                    case '\\': 
                        if ($inquote) $ignorenext = true; 
                        $result .= $char; 
                        break; 
                    default: 
                        $result .= $char; 
                } 
            } 
        } 
        return $result; 
}