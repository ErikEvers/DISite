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


var balieArray = [];
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

                balieArray = data;
                
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
        //$('#passagier').toggleClass('active');
        next($('.layout_list').get(0));
        
        balienummer = balieArray[$(this).index()].balienummer;
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

            passagierArray = [];
            
            //Loop through all data and add all passangers to select list
            for(var i = 0, il = data.length; i < il; i++)
            {
                var passagier = data[i];

                passagierArray.push(passagier);

                $('#passagier_list').empty();
                $('#passagier_list').append('<option>' + passagier.passagiernaam + ' ' + passagier.vluchtnummer + ' ' + passagier.bestemming + ' ' + passagier.maatschappijnaam + ' ' + new Date(passagier.vertrektijdstip.date).toLocaleDateString() + ' ' + new Date(passagier.vertrektijdstip.date).toLocaleTimeString() + '</option>');
            }
        })

        return false;
    });

    //Search for option when clicked on #passagier_list
    $('#passagier_list').on('click', 'option', function()
    {
        next($('.layout_list').get(1));

        passagier = passagierArray[$(this).index()];

        console.log(passagier);
        
        $.post('fetch.php', { func : 'getGegevens', args : [passagier.passagiernummer, passagier.vluchtnummer]}, function(data)
        {    
            console.log(data);
            
            var data = JSON.parse(data)[0];
            
            console.log(data);

            //Check for exceptions or errors
            if(data.hasOwnProperty('err'))
            {

                return;
            }

            vluchtData = data;
            var pk = [
                'passagiernummer',
                'naam',
                'geslacht',
            ];
            
            $('#passagier_gegevens').empty();
            
            for(var i = 0, il = pk.length; i < il; i++)
            {
                $('#passagier_gegevens').append('<li>' + pk[i] + ': ' + data[pk[i]] + '</li>');
            }
            
            $('#passagier_gegevens').append('<li>Geboortedatum: ' + new Date(data['geboortedatum']['date']).toLocaleDateString() + '</li>');
            
            
            var vk = [
                'vluchtnummer',
                'vliegtuigtype',
                'luchthavencode',
                'gatecode',
                'maatschappijnaam'
            ];
            
            $('#vlucht_gegevens').empty();
            
            for(i = 0, il = vk.length; i < il; i++)
            {
                $('#vlucht_gegevens').append('<li>' + vk[i] + ': ' + data[vk[i]] + '</li>');
            }
            
            $('#vlucht_gegevens').append('<li>Vertrektijdstip: ' + new Date(data['vertrektijdstip']['date']).toLocaleDateString() + ' ' + new Date(data['vertrektijdstip']['date']).toLocaleTimeString() +'</li>');
            
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
                console.log(data);
                
                var unwantedMessage = "[Microsoft][SQL Server Native Client 11.0][SQL Server]";
                
                alert(data['message'].substr(unwantedMessage.length, data['message'].length));
                
                return;
            }

            //Confirmation of inchecking
            if(data.hasOwnProperty('succes'))
            {
                next($('.layout_list').get(2));
                
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
                 next($('.layout_list').get(0));
            }
        });
    });
    
    $('#add_bagage').submit(function( event )
    {
        event.preventDefault();
        
        var gewicht = parseFloat($(this).find('input[name=gewicht]').val());
        
        console.log(gewicht);
        
        //If no items are selected exit runtime;
        if((/[^0-9]/g).test(gewicht) || !isFinite(gewicht))
        {
            if(gewicht < 1)
            {
                alert('Het gewicht kan niet 0 of minder zijn!')
            }
            else
            {
                alert('Geef een nummer voor het gewicht!')
            }
            
            return false;
        }
            
        $.post('fetch.php', { func : 'add_bagage', args :[passagier.passagiernummer, passagier.vluchtnummer, gewicht] }, function(data)
        {
            var data = JSON.parse(data);
            
             //Check for exceptions or errors
            if(data.hasOwnProperty('err'))
            {
                
                var unwantedMessage = "[Microsoft][SQL Server Native Client 11.0][SQL Server]";
                
                alert(data['message'].substr(unwantedMessage.length, data['message'].length));

                return;
            }

            //Confirmation of inchecking
            if(data.hasOwnProperty('succes'))
            {
                getBagageLijst(passagier.passagiernummer, passagier.vluchtnummer);
            }
        });
    });
    
    $('#remove_bagage').submit(function( event )
    {
        event.preventDefault();
        
        var selected = [];
        
        $( "#bagage_list option:selected").each(function(n, element)
        {
            selected.push($(element).val());
        });
        
        //If no items are selected exit runtime;
        if(selected.length < 1)
            return false;
        
        $.post('fetch.php', { func : 'remove_bagages', args :[passagier.passagiernummer, passagier.vluchtnummer, selected] }, function(data)
        {
            var data = JSON.parse(data);
            
             //Check for exceptions or errors
            if(data.hasOwnProperty('err'))
            {
                alert('failed');

                return;
            }

            //Confirmation of inchecking
            if(data.hasOwnProperty('succes'))
            {
                getBagageLijst(passagier.passagiernummer, passagier.vluchtnummer);
            }
        });
    });
});

//Next option
function next(element)
{
    var active = $(element);
    
    
    
    if($(active).hasClass('active') || $(active).hasClass('inactive'))
    {
        $(active).removeClass('active');
        $(active).addClass('inactive');
        
        $(active).prevAll().each(function(n, element)
        {
            if(!$(element).hasClass('inactive'))
                $(element).addClass('inactive');
        });

        $(active).nextAll().each(function(n, element)
        {
            if($(element).hasClass('active'))
                $(element).removeClass('active');

            if($(element).hasClass('inactive'))
                $(element).removeClass('inactive');
        });
        
        var next_option = $(active).next();
        
        next_option.addClass('active');

         $('html, body').animate({
            scrollTop: $(next_option).offset().top
        }, 400);

        $(next_option).find('input[type=text],select').filter(':visible:first').focus();
    }
}

//Get list of bagage of passenger on flight
function getBagageLijst(passagier, vluchtnummer)
{
    $.post('fetch.php', { func: 'getBagage', args: [vluchtData.passagiernummer, vluchtData.vluchtnummer] }, function(data)
    {
        var data = JSON.parse(data);
        
        if(data.length > 0)
        {
            var max = data[0].max_ppgewicht;

            $('#bagage_list').empty();
            
            for(var i = 0, il = data.length; i < il; i++)
            {
                var bagage = data[i];
                max -= data[i].gewicht;

                $('#bagage_list').append('<option value="' + bagage.volgnummer + '">Volgnummer: ' + bagage.volgnummer + ', Gewicht: ' + bagage.gewicht + '</option>');
            }

            $("#gewicht_txt").attr('max', max);
        }
        else
        {
            $('#bagage_list').empty();
            $('#bagage_list').append('<option></option');
            $("#gewicht_txt").attr('max', 1000);
        }
    });
}