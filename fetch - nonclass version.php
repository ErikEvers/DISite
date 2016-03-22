<?php

	require('/php/database.php');
/*
    $serverName = "PAT\SQLEXPRESS";
    $connectionInfo = array("Database" => "gelre_airport", "UID" => "sa", "PWD" => "nopassword");
    $conn = sqlsrv_connect($serverName, $connectionInfo);
 */   
    $balie_array = [];
    $passagiers_array = [];

    if($conn)
    {
        echo "Connection esteblished.<br>";

        getBalies($conn);
        getPassagiers(1);
        
        sqlsrv_close($conn);
    } else {
        echo "Connection could not be established. <br>";
        die(print_r(sqlsrv_errors(), true));
    }
    
    //Get Balies
    function getBalies()
    {
        global $conn, $balie_array;

        $tsql = "SELECT * 
    FROM IncheckenBijMaatschappij IBM 
    INNER JOIN Maatschappij M
    ON M.maatschappijcode = IBM.maatschappijcode";

        $result = sqlsrv_query($conn, $tsql, null);

        if ($result === false)
        {
            die(FormatErrors(sqlsrv_errors()));
        }

        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
        {
            $balie_array[] = $row;
        }
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