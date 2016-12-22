$(document).ready(function() {
    var options = {
        chart: {
            renderTo: 'container',
            type: 'bar'
        },
        title: {
            text: 'Highcharts Chart PHP with MySQL Example',
            x: -20 //center
        },
        subtitle: {
            text: 'Sumber : Jabatan XYZ',
            x: -20
        },
        xAxis: {
            categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas'],
        },
        yAxis: {
            title: {
                text: 'Jumlah Pelawat'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>:<b>{point.y}</b> of total<br/>'
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        series: []
    };
    $.getJSON("traer", {desde: $desde, hasta: $hasta}, function(json) {
        options.xAxis.categories = json.datos['categorias']; //xAxis: {categories: []}
        options.series[0] = json.datos['series'];
        chart = new Highcharts.Chart(options);
    });
});