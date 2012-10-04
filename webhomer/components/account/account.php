<?php
/*
 * HOMER Web Interface
 * Homer's account.php
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

defined( '_HOMEREXEC' ) or die( 'Restricted access' );

require_once ('account.html.php');

include("../../preferences.php");

class Component {

          function executeComponent() {
                    
                    global $task;          
                              
                    //Go if all ok
                    switch ($task) {
                    
                       case 'account':
                          $this->editAccount();
                          break;
                       case 'resetpwd':
                       	  $this->resetPassword();
                       	  break;
                       default:
                          $this->editAccount();
                          break;    
                  }
          }

          function editAccount() {
          
                HTML_Account::displayAccount();                
          }
          
          function resetPassword(){
          		
          		global $db;
          	
          		$this->editAccount();
          		$pwd = getVar('password', NULL, 'post', 'string');
          		$retpwd = getVar('retype-pwd', NULL, 'post', 'string');
          		
          		$authtype = AUTHENTICATION;
          		if ($authtype != "internal"){
          			echo "<script> $('#pwdtext').prepend('<font color=orange>Feature not supported for this authentication mode!<br></font>');</script>";
          		}
          		else if ($retpwd != $pwd){
          			echo "<script> $('#pwdtext').prepend('<font color=red>The two passwords do not match!<br></font>');</script>";
          		}
          		
          		else {
          			$test = $_SESSION['loggedin'];
          			$aa = md5($pwd);
          			$query = $db->makeQuery("update homer_logon SET password ='?' WHERE useremail = '?' limit 1;" , md5($pwd), $_SESSION['loggedin']);
          			$db->executeQuery($query);
          			echo "<script> $('#pwdtext').prepend('<font color=green>Password reset successfuly.<br></font>');</script>";
          		}
          		
          }
}

?>
