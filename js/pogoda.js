$(document).ready(function () {
    //$.get('dane/daily.xml', function(d){
    $.get('http://api.openweathermap.org/data/2.5/forecast/daily?q=Czestochowa&mode=xml&units=metric&cnt=7&appid=23766fd4774176927c13f3510b23f1e2', function (d) {
        $("#komunikatXML").hide();
        var nazwa = $(d).find('name').text();
        var wst = ' <caption>Pogoda ' + nazwa + '</caption><tr><td class="pogoda">Kiedy</td><td class="pogoda">Temperatura</td><td class="pogoda">Zachmurzenie</td></tr>';
        $('#tablicaPogodowa').append($(wst));

        $(d).find('time').each(function () {

            var $time = $(this);
            var data = $time.attr("day");
            var temp = $time.find('temperature').attr('day');
            var symbol = $time.find('symbol').attr('name');

            var html = '<tr><td class="pogoda">' + data + '</td>';
            html += '<td class="pogoda">' + temp + '&deg;C</td>';
            html += '<td class="pogoda">' + symbol + '</td>';
            html += '</tr>';

            $('#tablicaPogodowa').append($(html));

            $('.loadingPic').fadeOut(1400);
        });
    });
});





