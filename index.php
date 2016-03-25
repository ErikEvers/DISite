<!DOCTYPE html>
<html class="fill">
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="js/jquery-1.12.2.js"></script>
        <script src="js/balie_keuze.js"></script>
    </head>
    <body class="fill no_margin no_border">
        <div class="fill" id="layout_container">
            <?php
            
                include('fetch.php');
            
            ?>
            <!--
                PROTOTYPE HEADER
                
                - Exit
                - Navigation
                - Search
            -->
            <div class="fill_width" id="layout_header">
                <ul class="no_margin no_list_style fill" id="layout_options">
                    <li id="show_balie">Balies</li>
                </ul>
            </div>
            <div class="margin_40" id="layout_lists">
                <div class="layout_list" id="balie">
                    <div class="" id="layout_progress">
                        <div class="progress">1</div>
                    </div>
                    <div class="input list">
                        <select id="balie_list" class="fill" multiple>
                        </select>
                    </div>
                </div>
                <div class="layout_list" id="passagier">
                    <form id="passenger" action="#">
                        <label for="naam_txt">Passagier naam</label>
                        <input id="naam_txt"type="text" name="passagiernaam" placeholder="search"/>
                        <label for="vlucht_txt">Vlucht nummer</label>
                        <input id="vlucht_txt" type="text" name="vluchtnummer" placeholder="search"/>
                        <label for="bestemming_txt">Bestemming</label>
                        <input id="bestemming_txt" type="text" name="bestemmingsnaam" placeholder="search"/>
                        <label for="maatschappij_txt">Maatschappij</label>
                        <input id="maatschappij_txt" type="text" name="maatschappijnaam" placeholder="search"/>
                        <label for="vertrek_txt">Vertrekdatum</label>
                        <input id="vertrek_txt" type="text" name="vertrektijdstip" placeholder="search"/>
                        <input id="passenger_submit" type="submit"/>
                    </form>
                    <div class="" id="layout_progress">
                        <div class="progress">2</div>
                    </div>
                    <div class="input list">
                        <select id="passagier_list" class="fill" multiple>
                            
                        </select>
                    </div>
                </div>
                <div class="layout_list" id="vlucht">
                    <div class="" id="layout_progress">
                        <div class="progress">3</div>
                        
                    </div>
                    <div class="input list column_parent">
                        <div class="column_2_1">
                            <ul id="passagier_gegevens">
                                
                            </ul>
                        </div>
                        <div class="column_2_1">
                            <ul id="vlucht_gegevens">
                            
                            </ul>
                        </div>
                    </div>
                    <form id="checkin">
                        <label for="stoel_txt">Stoel Nummer:</label>
                        <input id="stoel_txt" type="text" name="stoel"/>
                        <label for="inchecktijdstip_txt">Inchecktijdstip:</label>
                        <input id="inchecktijdstip_txt" type="text" name="inchecktijdstip"/>
                        <input type="submit" value="Check In"/>
                    </form>
                </div>
                <div class="layout_list" id="bagage">
                    <div class="" id="layout_progress">
                        <div class="progress">4</div>
                        
                    </div>
                    <div class="input list">
                        <select id="bagage_list" class="fill" multiple>
                        </select>
                    </div>
                    <form id="confirm">
                        <input type="submit" value="Confirm"/>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html> <!-- HALLO ERIK -->