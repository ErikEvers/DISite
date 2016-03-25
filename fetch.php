<?php

	require('php/query_airport.php');
	require('php/connectDatabase.php');


    $airport = new Airport( $server,
    		                $database,
            		        $uid,
                    		$password );

    //If POST attribute args exist use args
    if(isset($_POST['args']))
        $args = $_POST['args'];
    else
        $args = [];

    if(isset($_POST['func']))
    {
        $_POST['func']($args);
    }


    //Get Balies
    function getBalies()
    {
    	global $airport;

       	echo json_encode($airport->verzoek_balies());
    }
    
    //Get Passagiers
    function getPassagiers($searchables)
    {
        global $airport;
        
        echo json_encode($airport->vind_passagier($searchables));
    }
?>