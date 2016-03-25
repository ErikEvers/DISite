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
            
                
            $dataQuery = "SELECT P.passagiernummer, P.naam AS passagiernaam, V.vluchtnummer, L.naam AS bestemming, M.naam AS maatschappijnaam, V.vertrektijdstip FROM PassagierVoorVlucht PVV INNER JOIN Passagier P ON PVV.passagiernummer = P.passagiernummer INNER JOIN Vlucht V ON PVV.vluchtnummer = V.vluchtnummer INNER JOIN Luchthaven L ON V.luchthavencode = L.luchthavencode INNER JOIN Maatschappij M ON V.maatschappijcode = M.maatschappijcode WHERE" . $passagierNaamSearch . $vluchtNaamSearch . $bestemmingNaamSearch . $maatschappijNaamSearch . $vertrektijdstipSearch ;
            
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

    	public function vraag_gegevens($passagiernummer, $vluchtnummer)
    	{
            $dataQuery = "SELECT P.passagiernummer, P.naam, P.geslacht, P.geboortedatum, PVV.balienummer, PVV.inchecktijdstip, PVV.stoel, V.vluchtnummer, V.gatecode, V.maatschappijcode, V.luchthavencode, V.vliegtuigtype, V.max_aantal_psgrs, V.max_totaalgewicht, V.max_ppgewicht, V.vertrektijdstip, V.aankomsttijdstip
FROM Passagier P INNER JOIN PassagierVoorVlucht PVV ON P.passagiernummer = PVV.passagiernummer 
INNER JOIN Object O ON O.passagiernummer = PVV.passagiernummer AND O.vluchtnummer = PVV.vluchtnummer 
INNER JOIN Vlucht V ON PVV.vluchtnummer = V.vluchtnummer
WHERE P.passagiernummer = ? AND V.vluchtnummer = ?";
            
			$result = $this->verzendQuery($dataQuery, array((int)$passagiernummer, (int)$vluchtnummer));
    		
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
        
        public function checkin_passagier($stoel, $inchecktijdstip, $balienummer)
        {
            $dataQuery = "UPDATE PassagierVoorVlucht PVV SET stoel = ?, inchecktijdstip = ?, balienummer = ?";
            
            //VERWIJDER DIT VOOR ECHTE VERSIE
            $this->beginTransaction();
            
			$result = $this->verzendQuery($dataQuery, array($stoel, $inchecktijdstip, $balienummer));
    		
            //VERWIJDER DIT VOOR ECHTE VERSIE
            $this->rollbackTransaction();
            
            if($result)
            {
				return ["succes" => true];
			}

			return false;
        }

        public function get_bagage($passagiernummer, $vluchtnummer)
        {
            $dataQuery = "SELECT O.volgnummer, O.gewicht, V.max_ppgewicht FROM Object O INNER JOIN Vlucht V ON V.vluchtnummer = O.vluchtnummer WHERE O.passagiernummer = ? AND V.vluchtnummer = ?";
            
            $result = $this->verzendQuery($dataQuery, [$passagiernummer, $vluchtnummer]);
            
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