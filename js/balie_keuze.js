/*
            
                REQUEST OBJECT
                
                {
                    func : 'getBalies' //Function name
                    args : []          //Arguments for the function
                }
            
            
            */
            
            
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
                            console.log(data);

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
                    $('#passagier_list').toggleClass('active');
                    console.log($(this).text());
                })
            });