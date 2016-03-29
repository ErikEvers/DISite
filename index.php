<!DOCTYPE html>
<html class="fill">
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="js/jquery-1.12.2.js"></script>
        <script src="js/balie_keuze.js"></script>
    </head>
    <body class="no_margin no_border">
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
                <ul id="layout_navigator" class="no_margin no_list_style" id="layout_options">
                    <li id="show_balie">Balies</li>
                </ul>
            </div>
            <div class="margin_40" id="layout_lists">
                <div class="layout_list" id="balie">
                    <div class="" id="layout_progress">
                        <div class="progress">1</div>
                        <div class="progress_titel">Kies uw balie</div>
                    </div>
                    <div class="input list">
                        <select id="balie_list" class="fill" multiple>
                        </select>
                    </div>
                </div>
                <div class="layout_list" id="passagier">
                    <div class="" id="layout_progress">
                        <div class="progress">2</div>
                        <div class="progress_titel">Zoek passagier</div>
                    </div>
                    <div class="input list">
                        <form id="passenger" action="#">
                            <input class="input text" id="naam_txt" type="text" name="passagiernaam" placeholder="Passagier naam"/>
                            <input class="input text" id="vlucht_txt" type="number" name="vluchtnummer" placeholder="Vlucht nummer"/>
                            <input class="input text" id="bestemming_txt" type="text" name="bestemmingsnaam" placeholder="Bestemming"/>
                            <input class="input text" id="maatschappij_txt" type="text" name="maatschappijnaam" placeholder="Maatschappij"/>
                            <input class="input text" id="vertrek_txt" type="date" name="vertrektijdstip" placeholder="Vertrekdatum"/>
                            <input class="input submit" id="passenger_submit" type="submit" value="Zoek"/>
                        </form>
                        <select id="passagier_list" class="fill" multiple>

                        </select>
                    </div>
                </div>
                <div class="layout_list" id="vlucht">
                    <div class="" id="layout_progress">
                        <div class="progress">3</div>
                        <div class="progress_titel">Check in</div>
                    </div>
                    <div class="input list">
                        <form id="checkin">
                            <input class="input text" id="stoel_txt" type="text" name="stoel" placeholder="Stoel Nummer"/>
                            <input class="input text" id="inchecktijdstip_txt" type="text" name="inchecktijdstip" placeholder="Inchecktijdstip"/>
                            <input class="input submit" type="submit" value="Check In"/>
                        </form>
                        <div class="column_parent">
                            <div class="column_2_1">
                                <ul id="passagier_gegevens" class="data_list no_list_style">

                                </ul>
                            </div>
                            <div class="column_2_1">
                                <ul id="vlucht_gegevens" class="data_list no_list_style">

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layout_list" id="bagage">
                    <div class="" id="layout_progress">
                        <div class="progress">4</div>
                        <div class="progress_titel">Pas bagage aan</div>
                    </div>
                    <div class="input list">
                        <select id="bagage_list" class="fill" multiple>
                        </select>
                        <form id="add_bagage">
                            <input class="input text" type="number" id="gewicht_txt" name="gewicht" placeholder="Gewicht" min="0" max="1000"/>
                            <input class="input submit" type="submit" value="Confirm"/>
                        </form>
                        <form id="remove_bagage">
                            <input class="input submit" type="submit" value="Remove"/>
                        </form>
                        <form id="confirm_bagage">
                            <input class="input submit" type="submit" value="Confirm"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html> <!-- HALLO ERIK -->