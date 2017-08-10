$(document).ready(function () {
    $cityElement = $("#city");
    $postalCodeElement = $("#cp");
    $cityContainer = $("#cityContainer");

    //La ville est masquée au départ
    $cityContainer.hide();

    function showCities(){
        postalCode = $postalCodeElement.val();
        if(postalCode.length == 5){
            $.getJSON("/villes-par-code-postal/"+ postalCode, function (data) {
                cityOptions = "";
                data.forEach(function (item) {
                    cityOptions += "<option value="+ item.id +">" + item.city_name + "</option>";
                });

                $cityElement.html(cityOptions);
                $cityContainer.show();
                $cityElement.focus();
            })
        }
    }

    $postalCodeElement.blur(showCities);

});
