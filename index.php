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
                    <div id="passenger">
                        <label for="naam">Passagier naam</label>
                        <input id="naam"type="text" placeholder="search"/>
                        <label for="vlucht">Vlucht naam</label>
                        <input id="vlucht" type="text" placeholder="search"/>
                        <label for="bestemming">Bestemming</label>
                        <input id="bestemming" type="text" placeholder="search"/>
                        <label for="maatschappij">Maatschappij</label>
                        <input id="maatschappij" type="text" placeholder="search"/>
                        <label for="vertrek">Vertrekdatum</label>
                        <input id="vertrek" type="text" placeholder="search"/>
                    </div>
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