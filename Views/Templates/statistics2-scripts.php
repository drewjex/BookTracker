<!--<script src="http://code.highcharts.com/highcharts.js"></script>-->

<script>
$(function () {
    var seriesOptions = [],
        seriesCounter = 0,
        names = ['MSFT', 'AAPL', 'GOOG'];
        var N = 36; //36
        var statuses = [];
        for (var i=25; i<N; i++) {
            statuses.push(i);
        }
        console.log(statuses);
        console.log(statuses.length);
        var semester_code = 20171;
        var request_statuses;

        $.ajax({
            type: "POST",
            url: "?controller=command&action=get_request_statuses",
            cache: false,

            success: function(response){
                request_statuses = JSON.parse(response);
                console.log(request_statuses);
            }
        });


    /**
     * Create the chart when all data is loaded
     * @returns {undefined}
     */
    function createChart() {

        Highcharts.stockChart('container', {

            rangeSelector: {
                selected: 4
            },

            /*yAxis: {
                labels: {
                    formatter: function () {
                        return (this.value > 0 ? ' + ' : '') + this.value + '%';
                    }
                },
                plotLines: [{
                    value: 0,
                    width: 2,
                    color: 'silver'
                }]
            },*/

            /*plotOptions: {
                series: {
                    compare: 'percent',
                    showInNavigator: true
                }
            },*/

            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> <br/>', //({point.change}%)
                valueDecimals: 2,
                split: true
            },

            series: seriesOptions
        });
    }

    $.each(statuses, function (i, status_id) {

        $.getJSON('https://booktracker.byu.edu/?controller=command&action=update_graph&start_date=11/01/2016&end_date=12/30/2016&request_status='+status_id+'&semester='+semester_code, function(data) {
        //$.getJSON('https://www.highcharts.com/samples/data/jsonp.php?filename=' + name.toLowerCase() + '-c.json&callback=?',    function (data) { //just make this our command controller function!

            seriesOptions[i] = { //{timestamp, datapoint}, ...
                name: request_statuses[status_id-1].name,
                data: data,
                //type: 'spline',
            };

            // As we're loading the data asynchronously, we don't know what order it will arrive. So
            // we keep a counter and create the chart when all the data is loaded.
            seriesCounter += 1;

            if (seriesCounter === statuses.length) {
                createChart();
            }
        });
    });
});

</script>

<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>