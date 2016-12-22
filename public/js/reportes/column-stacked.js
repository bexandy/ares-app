/**
 * Created by brodriguez on 02/11/16.
 */
$(function () {
    var categoryImg = {
        'Apples': '<img src="/htimg/htprofileimage_display/user/1.png">',
        'Oranges': '<img src="/htimg/htprofileimage_display/user/2.png">',
        'Pears': '<img src="/htimg/htprofileimage_display/user/3.png">',
        'Grapes': '<img src="/htimg/htprofileimage_display/user/4.png">',
        'Bananas': '<img src="/htimg/htprofileimage_display/user/5.png">'
    };

    $('#container').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Stacked column chart'
        },
        yAxis: {
            categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas'],
            labels: {
                x: 50,
                useHTML: true,
                formatter: function(){
                    return '<div class="myToolTip" tittle="Hello ' + this.value + ' ">' + categoryImg[this.value] + '</div>';
                },
                overflow: "justify"
            }
        },
        xAxis: {
            min: 0,
            title: {
                text: 'Total fruit consumption'
            },
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>:<b>{point.y}</b> of total<br/>',
        },

        legend: {
            reversed: true
        },
        plotOptions: {
            series: {
                stacking: 'normal',
                dataLabels: {

                }
            }
        },
        series: [{
            name: 'John',
            data: [5, 3, 4, 7, 2]
        }, {
            name: 'Jane',
            data: [2, 2, 3, 2, 1]
        }, {
            name: 'Joe',
            data: [3, 4, 4, 2, 5]
        }]
    });
});