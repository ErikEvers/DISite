<?php

	require('php/query_airport.php');
	require('php/connectDatabase.php');


    $airport = new Airport( $server,
    		                $database,
            		        $uid,
                    		$password );

    if(isset($_POST['func']))
    {
        $_POST['func']();
    }


    //Get Balies
    function getBalies()
    {
    	global $airport;

       	echo json_encode($airport->verzoek_balies());
    }
    
    //Get Passagiers
    function getPassagiers($balienummer)
    {
        global $airport;
        
        echo json_encode($airport->verzoek_vlucht($balienummer));
    }
?>