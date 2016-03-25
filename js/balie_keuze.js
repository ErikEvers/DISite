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

        var passagier = passagierArray[$(this).index()];

        $.post('fetch.php', { func : 'getGegevens', args : [passagier.passagiernummer, passagier.vluchtnummer]}, function(data)
        {
            var data = JSON.parse(data)[0];

            //Check for exceptions or errors
            if(data.hasOwnProperty('err'))
            {

                return;
            }

            var vluchtData = data;
            
            for(att in data)
            {
                console.log(data[att]);

                $('#passagier_gegevens').append('<li>' + att + ': ' + data[att] + '</li>');
            }
        })
    });

    $('#checkin').submit(function( event )
    {
        var arguments = $(this).serializeArray();
        arguments.push({'name': 'balienummer', value: balienummer});

        event.preventDefault();

        $.post('fetch.php', { func : 'checkinPassagier', args ; arguments }, function(data)
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
});

function getBagageLijst(passagier, vluchtnummer)
{
    $.post('fetch.php', { func: 'getBagage', args: [vluchtData.passagiernummer, vluchtData.vluchtnummer] }, function(data)
    {
        var data = JSON.parse(data);
        
        for(var i = 0, il = data.length; i < il; i++)
        {
            var bagage = data[i];
            
            $('#bagage_list').append('<option>' + bagage.volgnummer + ' ' + bagage.gewicht + '</option>');
        }
    });
}