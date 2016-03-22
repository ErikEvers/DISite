<?php

	require('php/query_airport.php');


	require('php/connectDatabase.php');

    $balie_array = [];
    $passagiers_array = [];
    
	$airport = new Airport( $server_patrick,
    		                $database_patrick,
            		        $uid_patrick,
                    		$password_patrick );

	$balie_array = getBalies();

    //Get Balies
    function getBalies()
    {
    	global $airport;

       	return $airport->verzoek_balies();
    }
    
    //Get Passagiers
    function getPassagiers($balienummer)
    {
        global $conn, $passagiers_array;

        $tsql = "
                    SELECT * 
                    FROM PassagierVoorVlucht PVV
                    INNER JOIN Passagier P
                    ON P.passagiernummer = PVV.passagiernummer
                    WHERE PVV.balienummer = " . $balienummer;
        
        $result = sqlsrv_query($conn, $tsql, null);

        if ($result === false)
        {
            die(FormatErrors(sqlsrv_errors()));
        }

        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
        {
            $passagiers_array[] = $row;
            
            //print_r($row);
        }
    }
?>