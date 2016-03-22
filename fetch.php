<?php

	require('php/query_airport.php');
	require('php/connectDatabase.php');

    $balie_array = [];
    $passagiers_array = [];
    
	$airport = new Airport( $server,
    		                $database,
            		        $uid,
                    		$password );

	$balie_array = getBalies();
    $passagiers_array = getPassagiers(1);

    //Get Balies
    function getBalies()
    {
    	global $airport;

       	return $airport->verzoek_balies();
    }
    
    //Get Passagiers
    function getPassagiers($balienummer)
    {
        global $airport;
        
        return $airport->verzoek_vlucht($balienummer);
    }
?>