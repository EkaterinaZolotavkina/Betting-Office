<?php
try {
    	$db = new PDO("pgsql:dbname=db; host=localhost; user=postgres; password=admin");
	   
}	
catch(PDOException $e)
    {
    echo $e->getMessage();
    }
