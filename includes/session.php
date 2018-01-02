<?php

session_start();
If (!isset($_SESSION["message"])){$_SESSION["message"]="";}

function message() {
                if (isset($_SESSION["message"])) { 
                $output= "<div class=\"message\"><p>";
                $output.= htmlentities($_SESSION["message"]);
                $output.= "</p></div>";
                // clear message after use
                $_SESSION["message"] = null;
                return $output;
                }
            }
            
            
function errors() {
                if (isset($_SESSION["errors"])) { 
                $errors = $_SESSION["errors"];
                
                // clear message after use
                $_SESSION["errors"] = null;
                return $errors;
                }
            }
?>