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

    //Get Vlucht
    function getGegevens($identification)
    {
        global $airport;
        
        echo json_encode($airport->vraag_gegevens($identification[0], $identification[1]));
    }
        
    //Check in Passagier
    function checkinPassagier($args)
    {
        global $airport;
        
        echo json_encode($airport->checkin_passagier($args[0]['value'], 
                                                     $args[1]['value'], 
                                                     $args[2]['value'],
                                                     $args[3]['value'],
                                                     $args[4]['value']));
    }

    //Get Bagage
    function getBagage($args)
    {
        global $airport;
        
        echo json_encode($airport->get_bagage($args[0], $args[1]));
    }
?>