/*

CACHE OBJECTS:

BALIE NUMMER
PASSAGIERVOORVLUCHT



REQUEST OBJECT

    {
        func : 'getBalies' //Function name
        args : []          //Arguments for the function
    }


*/


var passagierArray  = [];
var passagier       = null;
var vluchtData     = [];
var balienummer     = null;

$(document).ready(function()
{
    //When balie button is pressed
    $("#show_balie").click(function()
    {
        $('#balie').toggleClass('active');
        $('#balie_list').empty();

        //Check if #balie has class active
        if($('#balie').hasClass('active'))
        {
            //Send post request to file: fetch.php
            $.post('fetch.php', {func: 'getBalies'}, function(data)
            {
                //Parse data from PHP to JSON
                var data = JSON.parse(data);

                //Check for exceptions or errors
                if(data.hasOwnProperty('err'))
                {


                    return;
                }

                //Loop though all data and add all balies to select list
                for(var i = 0, il = data.length; i < il; i++)
                {
                    var balie = data[i];

                    $('#balie_list').append('<option>' + balie.balienummer + ' ' + balie.naam + '</option>');
                }
            });
        }
    });

    //Search for option when clicked on #balie_list
    $('#balie_list').on('click', 'option', function()
    {
        $('#passagier').toggleClass('active');

        balienummer = $(this).index() + 1;
        
        console.log(balienummer);
    });

    $('#passenger').submit(function( event )
    {
        var arguments = $( this ).serializeArray();
        event.preventDefault();

        console.log(arguments);

        $.post('fetch.php', { func : 'getPassagiers', args : arguments }, function(data)
        {
            var data = JSON.parse(data);

            //Check for exceptions or errors
            if(data.hasOwnProperty('err'))
            {

                return;
            }

            //Loop through all data and add all passangers to select list
            for(var i = 0, il = data.length; i < il; i++)
            {
                var passagier = data[i];

                passagierArray.push(passagier);

                $('#passagier_list').append('<option>' + passagier.passagiernaam + ' ' + passagier.vluchtnummer + ' ' + passagier.bestemming + ' ' + passagier.maatschappijnaam + ' ' + passagier.vertrektijdstip + '</option>');
            }
        })

        return false;
    });

    //Search for option when clicked on #passagier_list
    $('#passagier_list').on('click', 'option', function()
    {
        $('#vlucht').toggleClass('active');

        passagier = passagierArray[$(this).index()];

        console.log(passagier);
        
        $.post('fetch.php', { func : 'getGegevens', args : [passagier.passagiernummer, passagier.vluchtnummer]}, function(data)
        {
            var data = JSON.parse(data)[0];

            //Check for exceptions or errors
            if(data.hasOwnProperty('err'))
            {

                return;
            }

            vluchtData = data;
            
            for(att in data)
            {
                $('#passagier_gegevens').append('<li>' + att + ': ' + data[att] + '</li>');
            }
        })
    });

    $('#checkin').submit(function( event )
    {
        var arguments = $(this).serializeArray();
        arguments = arguments.concat([  {'name': 'balienummer', value: balienummer},
                                        {'name': 'passagiernummer', value: vluchtData.passagiernummer},
                                        {'name': 'vluchtnummer', value: vluchtData.vluchtnummer}]);
        event.preventDefault();
        
        console.log(arguments);

        $.post('fetch.php', { func : 'checkinPassagier', args : arguments }, function(data)
        {
            var data = JSON.parse(data);

            //Check for exceptions or errors
            if(data.hasOwnProperty('err'))
            {

                return;
            }

            //Confirmation of inchecking
            if(data.hasOwnProperty('succes'))
            {
                $('#bagage').toggleClass('active');

                getBagageLijst(arguments[0].value, arguments[1].value);
            }
        });
    });
    
    $('#confirm_bagage').submit(function( event )
    {
        event.preventDefault();
        
        $.post('fetch.php', { func : 'check_bagage', args :[passagier.passagiernummer, passagier.vluchtnummer] }, function(data)
        {
            var data = JSON.parse(data);
            
             //Check for exceptions or errors
            if(data.hasOwnProperty('err'))
            {

                return;
            }

            //Confirmation of inchecking
            if(data.hasOwnProperty('succes'))
            {
                
            }
        });
    })
});

function getBagageLijst(passagier, vluchtnummer)
{
    $.post('fetch.php', { func: 'getBagage', args: [vluchtData.passagiernummer, vluchtData.vluchtnummer] }, function(data)
    {
        var data = JSON.parse(data);
        
        for(var i = 0, il = data.length; i < il; i++)
        {
            var bagage = data[i];
            
            $('#bagage_list').append('<option>Volgnummer: ' + bagage.volgnummer + ', Gewicht: ' + bagage.gewicht + '</option>');
        }
    });
}