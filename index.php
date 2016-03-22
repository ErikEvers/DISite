<!DOCTYPE html>
<html class="fill">
    <head>
        <style type="text/css">
        
            .margin_20
            {
                margin: 20px;
            }
            
            .margin_40
            {
                margin: 40px;
            }
            
            .no_margin
            {
                margin: 0px !important;
            }
            
            .no_border
            {
                padding: 0px !important;
            }
            
            .no_list_style
            {
                list-style: none;
            }
            
            .fill
            {
                width: 100%;
                height: 100%;
            }
            
            .fill_width
            {
                width: 100%;
            }
            
            .fill_height
            {
                height: 100%;
            }
            
            .input
            {

            }
            
            .input.list
            {
                display: block;
                
                position: absolute;
                
                top: 40px;
                bottom: 0px;
                left: 150px;
                right: 0px;
                
                float: right;
            }
            
            .input.list option
            {
                display: block;
                
                padding: 10px;
                
                height: 40px;
                
                line-height: 40px;
            }
            
            #layout_container
            {
                height: auto;
                
                background-color: azure;
            }
            
            #layout_header
            {
                height: 100px;
                
                background-color: azure;
            }
            
            #layout_options
            {
                border-radius: 15px;
                
                overflow: hidden;
            }
            
            #layout_options li
            {
                width: 100px;
                height: 50px;
                
                background-color: #FFFFFF;
                
                border-radius: 10px;
                
                font-family: 'helvetica';
                color: #FFFFFF;
                line-height: 50px;
                text-indent: 15px;
            }
            
            #layout_lists
            {
                overflow: hidden;
            }
            
            .layout_list
            {
                position: relative;
                
                margin: 25px 0;
                
                padding: 0 0 50px 0;
                
                width: 100%;
                height: auto;
                
                overflow: hidden
            }
            
            .layout_list#balie
            {
                
            }
            
            .layout_list #passenger
            {
                padding: 0 0 0 150px;

                width: 100%;
                height: 40px;
            }
            
            #layout_progress
            {
                position: relative;
                
                width: 100px;
                height: auto;
            }
            
            #layout_progress .progress
            {
                margin: 0 40px;
                
                height: 100%;
                width: 20px;
                
                color: darkseagreen;
                font-family: 'helvetica';
                font-size: 80pt;
            }
        </style>
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