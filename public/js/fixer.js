access_key = $('input[name=hiddenkey]').val();

$(document).ready(function(){

    $('#currency_selector').change(function(){

        var element = $(this).find('option:selected');
        var value_selected = $(this).val();

        currency_symbol = element.attr('symbol');  

        $.ajax({
            url: '/changeCurrency?to='+value_selected,    
            dataType: 'json',
            success: function(data, status) {       
            }
        });   

        getRate(value_selected,currency_symbol);

    });
});

function getRate(to,symbol){
  if(access_key){
    $.ajax({
        url: '/getRate?to='+to,    
        dataType: 'json',
        async:true,
        success: function(data, status) {  

          var status = data.status;
          var product_price = data.message;

          if(product_price.error){
               //Display Error msg of API
               alert("Please check your API Key. We got response " + product_price.error['info']) 
           }  else {
             //Update converted price for each product
             for(i=0; i<product_price.length ; i++) {
                 var converted_price = product_price[i].price;
                 $('.currency_symbol').text(symbol);
                 $('#product_'+product_price[i].id).text(Number(converted_price.toFixed(2)));
             }
           }       
        }
    }); 
  } else {
    //Display error for the API Key is not entered
    alert("Please Update API Key in .ENV file for the price conversion");
  }
}