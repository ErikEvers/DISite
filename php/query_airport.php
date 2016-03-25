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
        
        public function vind_passagier($searchables)
        {
            $values = [];
            
            $passagierNaamSearch = "";
            $vluchtNaamSearch = "";
            $bestemmingNaamSearch = "";
            $maatschappijNaamSearch = "";
            $vertrektijdstipSearch = "";
            
            //Passagiernaam
            if(!empty($searchables[0]['value']))
            {
                $passagierNaamSearch = " P.naam LIKE ? AND";
                $values[] = '%' . $searchables[0]['value'] . '%';
            }
            //Vluchtnummer
            if(!empty($searchables[1]['value']))
            {
                $vluchtNaamSearch = " PVV.vluchtnummer = ? AND";
                $values[] = (int)$searchables[1]['value'];
            }
            //Bestemmingsnaam
            if(!empty($searchables[2]['value']))
            {
                $bestemmingNaamSearch = " L.naam LIKE '%?%' AND";
                $values[] = $searchables[2]['value'];
            }
            //Maatschappijnaam
            if(!empty($searchables[3]['value']))
            {
                $maatschappijNaamSearch = " M.naam LIKE '%?%' AND";
                $values[] = $searchables[3]['value'];
            }
            //Vlucht vertrektijdstip en aankomsttijdstip
            //ERIK VIND DAT ER TWEE WAARDES IN MOETEN??
            if(!empty($searchables[4]['value']))
            {
                $vertrektijdstipSearch = " V.vertrektijdstip BETWEEN '? 00:00:00' AND '? 23:59:59' AND";
                $values[] = $searchables[4]['value'];
            }
            
                
            $dataQuery = "SELECT * FROM PassagierVoorVlucht PVV INNER JOIN Passagier P ON PVV.passagiernummer = P.passagiernummer INNER JOIN Vlucht V ON PVV.vluchtnummer = V.vluchtnummer INNER JOIN Luchthaven L ON V.luchthavencode = L.luchthavencode INNER JOIN Maatschappij M ON V.maatschappijcode = M.maatschappijcode WHERE" . $passagierNaamSearch . $vluchtNaamSearch . $bestemmingNaamSearch . $maatschappijNaamSearch . $vertrektijdstipSearch ;
            
            $dataQuery = substr($dataQuery, 0, -3);

            //var_dump($dataQuery);
            
            
            $result = $this->verzendQuery($dataQuery, $values);
            
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
            $dataQuery = "SELECT *
                                FROM PassagierVoorVlucht PVV INNER JOIN Passagier P ON PVV.passagiernummer = P.passagiernummer
                                INNER JOIN Vlucht V ON PVV.vluchtnummer = V.vluchtnummer
                                INNER JOIN Luchthaven L ON V.luchthavencode = L.luchthavencode
                                INNER JOIN Maatschappij M ON V.maatschappijcode = M.maatschappijcode";
            
            
            return [];
            /*
			$result = $this->verzendQuery("
    WHERE P.naam LIKE '%?%' OR PVV.vluchtnummer = ? OR L.naam LIKE '%?%' OR M.naam LIKE '%?%' OR V.vertrektijdstip BETWEEN '? 00:00:00' AND '? 23:59:59'", array($balienummer));
    		
			if($result)
			{
				$fetch_array = [];

				while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
				{
					$fetch_array[] = $row;
				}

				return $fetch_array;
			}

			return false;*/
    	}

	}


?>