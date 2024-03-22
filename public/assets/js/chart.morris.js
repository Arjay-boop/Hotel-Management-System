$(document).ready(function () {
    lineChart();
    donutChart();
    barChart();
    Bar();
    donut();

    $(window).resize(function () {
        window.lineChart.redraw();
        window.donutChart.redraw();
        window.barChart.redraw();
        window.Bar.redraw();
        window.donut.redraw();
    });
});

function lineChart() {
    window.lineChart = Morris.Line({
        element: 'line-chart',
        data: [
            { y: '2006', a: 100, b: 90 },
            { y: '2007', a: 75, b: 65 },
            { y: '2008', a: 50, b: 40 },
            { y: '2009', a: 75, b: 65 },
            { y: '2010', a: 50, b: 40 },
            { y: '2011', a: 75, b: 65 },
            { y: '2012', a: 100, b: 90 }
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        lineColors: ['#009688', '#cdc6c6'],
        lineWidth: '3px',
        resize: true,
        redraw: true
    });
}

function donutChart() {
    window.donutChart = Morris.Donut({
        element: 'donut-chart',
        data: [
            { label: "Normal Room", value: 50 },
            { label: "Ac Room", value: 25 },
            { label: "Special Room", value: 5 },
            { label: "DoubleBed room", value: 10 },
            { label: "Video Room", value: 10 },
        ],
        backgroundColor: '#f2f5fa',
        labelColor: '#009688',
        colors: ['#0BA462', '#39B580', '#67C69D', '#95D7BB'],
        resize: true,
        redraw: true
    });
}

function barChart() {
    window.barChart = Morris.Bar({
        element: 'bar-chart',
        data: [
            { y: '2006', a: 50, b: 40 },
            { y: '2007', a: 30, b: 25 },
            { y: '2008', a: 20, b: 15 },
            { y: '2009', a: 30, b: 25 },
            { y: '2010', a: 20, b: 15 },
            { y: '2011', a: 30, b: 25 },
            { y: '2012', a: 50, b: 40 }
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        barColors: ['#3498db', '#e74c3c'],
        resize: true,
        redraw: true
    });
}

function Bar() {
    window.Bar = Morris.Bar({
        element: 'bar',
        data: [
            { y: 'RET', a: 80 },
            { y: 'CRDC', a: 70 },
            { y: 'Guest House', a: 90 },
        ],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Occupancy Rate'],
        barColors: ['#3498db'],
        resize: true,
        redraw: true
    })
}

function donut() {
    window.donut = Morris.Donut({
        element: 'donut',
        data: [
            { label: 'RET', value: 40 },
            { label: 'CRDC', value: 30 },
            { label: 'Guest House', value: 30 },
        ],
        backgroundColor: '#f2f5fa',
        labelColor: '#009688',
        colors: ['#0BA462', '#39B580', '#67C69D'],
        resize: true,
        redraw: true
    });

}

