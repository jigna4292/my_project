// set endpoint and your access key
endpoint = 'latest'
access_key = $('input[name=hiddenkey]').val();
var products;

$(document).ready(function(){

    $.ajax({  
       url:        '/productajax',  
       type:       'POST',   
       dataType:   'json',  
       async:      false,  
       
       success: function(data, status) {  
          products = data.message;

          var getData = checkCookie();

          $( "#currency_selector").val(getData);
          $( "#currency_selector option:selected" ).attr("selected","selected");

          var currency_symbol = $( "#currency_selector option:selected" ).attr('symbol');

          getPrice(getData,currency_symbol);

      },  
       error : function(xhr, textStatus, errorThrown) {  
          alert('Ajax request failed.');  
       }  
    }); 

    $('#currency_selector').change(function(){

        var element = $(this).find('option:selected');
        var value_selected = $(this).val();

        setCookie('setCurrency',value_selected,1);
        var currency = getCookie("setCurrency");

        currency_symbol = element.attr('symbol');  

        getPrice(currency,currency_symbol);     

    });
});

function getPrice(to,symbol){
  if(access_key){
        // get the most recent exchange rates via the "latest" endpoint:
        $.ajax({
            url: 'http://data.fixer.io/api/' + endpoint + '?access_key=' + access_key,    
            dataType: 'jsonp',
            async : false,
            success: function(json) {

               if(json.error){
                   alert("Please check your API Key. We got response " + json.error['info']) 
               }  else {
                 var base = json.rates[to];      
                 var convert_to_eur = 1/json.rates["USD"];

                 for(i=0; i<products.length ; i++) {
                     var converted_price_to_eur =  products[i].price * convert_to_eur ;
                     var converted_price = converted_price_to_eur * base;
                     $('.currency_symbol').text(symbol);
                     $('#product_'+products[i].id).text(Number(converted_price.toFixed(2)));
                 }
               }                  
            }
        });
    } else {
        alert("Please add your API KEY in .env file");
    }
}

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function checkCookie() {
  var currency = getCookie("setCurrency");
  if (currency != "") {
    if(currency != "$"){
      return currency;
    } else {
      currency = "USD";
      if (currency != "" && currency != null) {
        setCookie("setCurrency", currency, 1);
      }
    }
  } else {
    currency = $( "#currency_selector option:selected" ).val();
    if (currency != "" && currency != null) {
      setCookie("setCurrency", currency, 1);
    }
  }
}