// set endpoint and your access key
endpoint = 'latest'
access_key = $('input[name=hiddenkey]').val();
var products;

$(document).ready(function(){
    var currency_symbol = $( "#currency_selector option:selected" ).attr('symbol');
    $('.currency_symbol').text(currency_symbol);

    $.ajax({  
       url:        '/productajax',  
       type:       'POST',   
       dataType:   'json',  
       async:      true,  
       
       success: function(data, status) {  
            products = data.message;
            //console.log(products);
       },  
       error : function(xhr, textStatus, errorThrown) {  
          alert('Ajax request failed.');  
       }  
    });  

    $('#currency_selector').change(function(){
        var element = $(this).find('option:selected');
        var value_selected = $(this).val();
        currency_symbol = element.attr('symbol');

        if(access_key){
            // get the most recent exchange rates via the "latest" endpoint:
            $.ajax({
                url: 'http://data.fixer.io/api/' + endpoint + '?access_key=' + access_key,    
                dataType: 'jsonp',
                success: function(json) {

                   var base = json.rates[value_selected];
                   var convert_to_eur = 1/json.rates["USD"];

                   var i;
                   for(i=0; i<products.length ; i++) {
                       var converted_price_to_eur =  products[i].price * convert_to_eur ;
                       //console.log(converted_price_to_eur);
                       var converted_price = converted_price_to_eur * base;
                       //console.log(converted_price);
                       $('.currency_symbol').text(currency_symbol);
                       $('#product_'+products[i].id).text(Number(converted_price.toFixed(2)));
                   }

                   if(json.error){
                       alert("Please check your API Key. We got response " + json.error['info']) 
                   } else {
                       console.log(json);
                   }
                    
                }
            });
        } else {
            alert("Please add your API KEY in .env file");
        }
    });
});