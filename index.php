<!DOCTYPE html>
<html class="fill">
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
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
                    <li>Balies</li>
                </ul>
            </div>
            <div class="margin_40" id="layout_lists">
                <div class="layout_list" id="balie">
                    <div class="" id="layout_progress">
                        <div class="progress">1</div>
                    </div>
                    <div class="input list">
                        <select class="fill" multiple>
                            <?php

                                for($i = 0, $il = count($balie_array); $i < $il; $i++)
                                    echo '<option>Balie ' . $balie_array[$i]['balienummer'] . '   ' . $balie_array[$i]['maatschappijcode'] .  ' ' . $balie_array[$i]['naam'] . '</option>';

                            ?>
                        </select>
                    </div>
                </div>
                <div class="layout_list">
                    <div id="passenger">
                        <label for="naam">Passagier naam</label>
                        <input id="naam"type="text" placeholder="search"/>
                        <input type="text" placeholder="search"/>
                        <input type="text" placeholder="search"/>
                        <input type="text" placeholder="search"/>
                        <input type="text" placeholder="search"/>
                    </div>
                    <div class="" id="layout_progress">
                        <div class="progress">2</div>
                    </div>
                    <div class="input list">
                        <select class="fill" multiple>
                            <?php

                                for($i = 0, $il = count($passagiers_array); $i < $il; $i++)
                                    echo '<option>Passagier ' . $passagiers_array[$i]['passagiernummer'] . ' ' . date_format( $passagiers_array[$i]['geboortedatum'], 'd/m/y') .  ' ' . $passagiers_array[$i]['naam'] . ' op vluchtnummer ' . $passagiers_array[$i]['vluchtnummer'] . '</option>';

                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html> <!-- HALLO ERIK -->