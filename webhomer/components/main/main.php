<?php
/*
 * HOMER Web Interface
 * Homer's index.php
 *
 * Copyright (C) 2011-2012 Alexandr Dubovikov <alexandr.dubovikov@gmail.com>
 * Copyright (C) 2011-2012 Lorenzo Mangani <lorenzo.mangani@gmail.com>
 *
 * The Initial Developers of the Original Code are
 *
 * Alexandr Dubovikov <alexandr.dubovikov@gmail.com>
 * Lorenzo Mangani <lorenzo.mangani@gmail.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
*/

require_once ('main.html.php');

class HomerMain {

       function openPage () {
        
           global $userlevel, $task, $component, $components;

           $titles = array("search" => "Search", "toolbox" => "ToolBox", "statistic" => "Stats", "admin" => "Admin", "account" =>"Account");

           $mytoolbar = array();
           
	   $title = '';
           if (isset($component)) {
                if(array_key_exists($component, $titles)) $title = $titles[$component];
           }

	   /* Background */
	   if (DAYNIGHT == 1) { 
		$date = date("G");
	        if ($date >= 6 AND $date <= 20) { $bglogo = "bgwave.jpg"; $bgcolor = "#FFFFFF"; } 
		else { $bglogo = "bgwave2.jpg"; $bgcolor = "#000000"; }
	   } else if (DAYNIGHT == 2) { $bglogo = "bgwave2.jpg"; $bgcolor = "#000000"; } 
	   else { $bglogo = "bgwave.jpg"; $bgcolor = "#FFFFFF"; }

	   if (! isset($header) ) $header = '';
	   if (! isset($level) ) $level = '';

           HTML_mainhtml::displayStart($title, $header, $task, $level, $bgcolor);
           
           HTML_mainhtml::displayBackground($bglogo);

           /* For login we do nothing */
           if($component == "login") return;
                  
           /* Check userlevel */   
           foreach($components as $key=>$value) {             
           
                  if($value < $userlevel) continue;                                          
                  $mytoolbar[$key]=$titles[$key];                                                       
           }                   
                    
           $uptime = exec("/usr/bin/uptime |  awk '{print $1,$2,$3,$4}' | sed  's/.$//'");
           
           HTML_mainhtml::displayToolBar($mytoolbar, $component, $uptime);                                                                                                                                                                                                                                
                                                                                                                                      
           HTML_mainhtml::displayUserBar($component, $task);
                      
           if($component != "admin") HTML_mainhtml::displayFormOpen();                      
       }
       
       function closePage () {
       
         global $component;
                  
         if($component != "admin") HTML_mainhtml::displayFormClose($component);                    
         HTML_mainhtml::displayStop();
         
       }
}

?>
