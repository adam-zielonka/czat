var pogoda;
$(document).ready(function () {
    $.get('http://api.openweathermap.org/data/2.5/forecast/daily?q=Czestochowa&mode=json&units=metric&cnt=7&appid=23766fd4774176927c13f3510b23f1e2', function (dane) {
        pogoda = dane;
        Wyswietl();
    });
});


function Wyswietl(){
    var nazwa = pogoda.city.name;
    var wst = ' <caption>Pogoda ' + nazwa + '</caption><tr><td class="pogoda">Kiedy</td><td class="pogoda">Temperatura</td><td class="pogoda">Zachmurzenie</td></tr>';
    $("#komunikatJSON").hide();
    $('#tablicaPogodowaJSON').append($(wst)); 
     
    var count = Object.keys(pogoda.list).length;	
    for(i = 0; i < count; i++) {
            var time = pogoda.list[i].dt;
            var data1 = new Date(time*1000);
            data = data1.getDate()+ "." + (data1.getMonth()+1)+"." + data1.getUTCFullYear();
			var temp = pogoda.list[i].temp.day;
			var symbol = pogoda.list[i].weather[0].description;

            var html = '<tr><td class="pogoda">' + data + '</td>';
			html += '<td class="pogoda">' + temp + '&deg;C</td>';
			html += '<td class="pogoda">' + symbol + '</td>';
            html += '</tr>';
 
            $('#tablicaPogodowaJSON').append($(html));
    }
}

/*
{"city":{"id":3100946,"name":"Czestochowa","coord":{"lon":19.12409,"lat":50.796459},"country":"PL","population":0},
 "cod":"200","message":0.0597,"cnt":7,
 "list":[{"dt":1447754400,"temp":{"day":9.43,"min":9.43,"max":10.69,"night":10.69,"eve":10.07,"morn":9.43},"pressure":997.8,"humidity":98,"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10d"}],"speed":4.38,"deg":218,"clouds":88,"rain":1.32},
         {"dt":1447840800,"temp":{"day":11.15,"min":8.3,"max":12.27,"night":8.3,"eve":9.42,"morn":11.12},"pressure":989.94,"humidity":100,"weather":[{"id":501,"main":"Rain","description":"moderate rain","icon":"10d"}],"speed":9.31,"deg":265,"clouds":92,"rain":9.51},
         {"dt":1447927200,"temp":{"day":8.57,"min":7.6,"max":10.69,"night":9.32,"eve":9.79,"morn":8.85},"pressure":994.12,"humidity":96,"weather":[{"id":501,"main":"Rain","description":"moderate rain","icon":"10d"}],"speed":9.71,"deg":243,"clouds":92,"rain":9.81},
         {"dt":1448013600,"temp":{"day":7.38,"min":7.16,"max":8.64,"night":7.6,"eve":8.02,"morn":7.17},"pressure":990.66,"humidity":100,"weather":[{"id":501,"main":"Rain","description":"moderate rain","icon":"10d"}],"speed":4.82,"deg":254,"clouds":92,"rain":5.89},
         {"dt":1448100000,"temp":{"day":5.7,"min":1.87,"max":6.67,"night":1.87,"eve":5.51,"morn":6.67},"pressure":973.38,"humidity":98,"weather":[{"id":501,"main":"Rain","description":"moderate rain","icon":"10d"}],"speed":6.82,"deg":280,"clouds":88,"rain":5.79},
         {"dt":1448186400,"temp":{"day":6.82,"min":3.81,"max":6.82,"night":3.81,"eve":5.83,"morn":4.65},"pressure":995.07,"humidity":0,"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10d"}],"speed":7.27,"deg":245,"clouds":59,"rain":1.16},
         {"dt":1448272800,"temp":{"day":5.1,"min":3.27,"max":5.68,"night":4.98,"eve":5.68,"morn":3.27},"pressure":989.86,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"moderate rain","icon":"10d"}],"speed":12.13,"deg":249,"clouds":98,"rain":6.5}
         ]}
*/