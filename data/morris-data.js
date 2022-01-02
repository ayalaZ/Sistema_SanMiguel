$(function() {

    /*Morris.Area({
        element: 'morris-area-chart',
        data: [{
            period: '2010 Q1',
            Suspenciones: 2666,
            Instalaciones: null,
            Renovaciones: 2647
        }, {
            period: '2010 Q2',
            Suspenciones: 2778,
            Instalaciones: 2294,
            Renovaciones: 2441
        }, {
            period: '2010 Q3',
            Suspenciones: 4912,
            Instalaciones: 1969,
            Renovaciones: 2501
        }, {
            period: '2010 Q4',
            Suspenciones: 3767,
            Instalaciones: 3597,
            Renovaciones: 5689
        }, {
            period: '2011 Q1',
            Suspenciones: 6810,
            Instalaciones: 1914,
            Renovaciones: 2293
        }, {
            period: '2011 Q2',
            Suspenciones: 5670,
            Instalaciones: 4293,
            Renovaciones: 1881
        }, {
            period: '2011 Q3',
            Suspenciones: 4820,
            Instalaciones: 3795,
            Renovaciones: 1588
        }, {
            period: '2011 Q4',
            Suspenciones: 15073,
            Instalaciones: 5967,
            Renovaciones: 5175
        }, {
            period: '2012 Q1',
            Suspenciones: 10687,
            Instalaciones: 4460,
            Renovaciones: 2028
        }, {
            period: '2012 Q2',
            Suspenciones: 8432,
            Instalaciones: 5713,
            Renovaciones: 1791
        }],
        xkey: 'period',
        ykeys: ['Suspenciones', 'Instalaciones', 'Renovaciones'],
        labels: ['Renovaciones', 'Suspenciones', 'Instalaciones'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });*/

    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Instalaciones",
            value: enc
        }, {
            label: "Suspensiones",
            value: enc3
        }, {
            label: "Renovaciones",
            value: enc2
        }, {
            label: "Reconexiones",
            value: enc4
        }],
        resize: true,
        colors: ['#4CAF50', '#d32f2f', '#3F51B5', '#F7591E']
    });

    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '2006',
            a: 100,
            b: 90
        }, {
            y: '2007',
            a: 75,
            b: 65
        }, {
            y: '2008',
            a: 50,
            b: 40
        }, {
            y: '2009',
            a: 75,
            b: 65
        }, {
            y: '2010',
            a: 50,
            b: 40
        }, {
            y: '2011',
            a: 75,
            b: 65
        }, {
            y: '2012',
            a: 100,
            b: 90
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        hideHover: 'auto',
        resize: true
    });

});
