$(function() {

    var Airports = [];
    $.getJSON('/../json/airports.json', function (data) {

        $.each(data, function (key, airport) {
            Airports.push({ label: airport.name, value: airport.code});
        })

    });

    console.log(Airports);

    $(".departure_input").autocomplete({
        minLength: 2,
        delay: 300,
        source: Airports
    });
    $(".arrival_input").autocomplete({
        minLength: 2,
        delay: 300,
        source: Airports
    });

});