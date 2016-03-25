<?php

	/*
	 
		- Zet in deze class alle queries die nodig zijn om de informatie voor de applicatie op te vragen.
		- Gebruik de functie $this->verzendQuery(QUERY, PARAMS) om informatie uit de database te halen.
		  Dit zorgt er voor dat er geen SQL injecties worden uitgevoerd doordat de php plugin functies dat zelf doen.
		  Voorbeeld data: "SELECT ?, ?, ?, ?, ? FROM Passagier', (id, naam, geslacht, geboortedatum, etc)

	*/

	require('database.php');

	class Airport extends Database
	{

		public function __construct($server, $database, $uid, $password)
    	{
    		parent::__construct($server, $database, $uid, $password);

    		if(!$this->checkConnectie())
    		{
    			die('Connection: OK');
    		}
    	}

    	public function verzoek_balies()
    	{
			$result = $this->verzendQuery("SELECT * FROM IncheckenBijMaatschappij IBM INNER JOIN Maatschappij M ON M.maatschappijcode = IBM.maatschappijcode", null);
    		
			if($result)
			{
				$fetch_array = [];

				while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
				{
					$fetch_array[] = $row;
				}

				return $fetch_array;
			}

			return false;
    	}

    	public function verzoek_vlucht($balienummer)
    	{
			$result = $this->verzendQuery("SELECT * 
                    FROM PassagierVoorVlucht PVV
                    INNER JOIN Passagier P
                    ON P.passagiernummer = PVV.passagiernummer
                    WHERE PVV.balienummer = ?", array($balienummer));
    		
			if($result)
			{
				$fetch_array = [];

				while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
				{
					$fetch_array[] = $row;
				}

				return $fetch_array;
			}

			return false;
    	}

	}


?>