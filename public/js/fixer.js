// set endpoint and your access key
endpoint = 'latest'
access_key = $('input[name=hiddenkey]').val();

$(document).ready(function(){

    //Check cookie is set if not set to default USD
    var getData = checkCookie();

    if(getData){
       $( "#currency_selector").val(getData);
       $( "#currency_selector option:selected" ).attr("selected","selected");
    } else {
       $( "#currency_selector").val("USD");
       $( "#currency_selector option:selected" ).attr("selected","selected");
    }   

    var to = $( "#currency_selector option:selected" ).val();
    var currency_symbol = $( "#currency_selector option:selected" ).attr('symbol');

    //Get conversion of the selected value
    getPrice(to,currency_symbol);

    $('#currency_selector').change(function(){

        var element = $(this).find('option:selected');
        var value_selected = $(this).val();

        //set cookie to the changed value
        setCookie('setCurrency',value_selected,1);
        var currency = getCookie("setCurrency");

        currency_symbol = element.attr('symbol');  

        //Get conversion of the selected value
        getPrice(value_selected,currency_symbol);     

    });
});

function getPrice(to,symbol){
  if(access_key){
    $.ajax({
        url: '/getPrice?to='+to+'&endpoint='+endpoint+'&key='+access_key,    
        dataType: 'json',
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
      return currency;
  } else {
    currency = $( "#currency_selector option:selected" ).val();
    if (currency != "" && currency != null) {
      setCookie("setCurrency", currency, 1);
    }
  }
}