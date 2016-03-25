<!DOCTYPE html>
<html class="fill">
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="js/jquery-1.12.2.js"></script>
        <script src="js/balie_keuze.js"></script>
    </head>
    <body class="fill no_margin no_border">
        <form class="fill" id="layout_container">
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
                <div class="layout_list" id="passagier_list">
                    <form id="passenger" action="#">
                        <label for="naam_txt">Passagier naam</label>
                        <input id="naam_txt"type="text" name="passagiernaam" placeholder="search"/>
                        <label for="vlucht_txt">Vlucht nummer</label>
                        <input id="vlucht_txt" type="text" name="vluchtnummer" placeholder="search"/>
                        <label for="bestemming_txt">Bestemming</label>
                        <input id="bestemming_txt" type="text" name="bestemmingnaam" placeholder="search"/>
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
                        <select class="fill" multiple>
                            
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html> <!-- HALLO ERIK -->