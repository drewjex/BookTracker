<!-- Chart.js -->
    <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
<!-- Select2 -->
<script src="../vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Flot -->
    <script src="../vendors/Flot/jquery.flot.js"></script>
    <script src="../vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../vendors/Flot/jquery.flot.time.js"></script>
    <script src="../vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../production/js/moment/moment.min.js"></script>
    <script src="../production/js/datepicker/daterangepicker.js"></script>


<!--<script>
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
                buttons: [{
                    type: 'day',
                    count: 1,
                    text: '1D'
                }, {
                    type: 'week',
                    count: 1,
                    text: '1W'
                }, {
                    type: 'year',
                    count: 1,
                    text: '1Y'
                }, {
                    type: 'all',
                    count: 1,
                    text: 'All'
                }],
                selected: 1,
                inputEnabled: false
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

</script>-->

<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>

    <script>

      var seriesOptions = [],
        seriesCounter = 0;

      function createChart() {

        Highcharts.stockChart('container', {

            rangeSelector: {
                buttons: [{
                    type: 'day',
                    count: 1,
                    text: '1D'
                }, {
                    type: 'week',
                    count: 1,
                    text: '1W'
                }, {
                    type: 'year',
                    count: 1,
                    text: '1Y'
                }, {
                    type: 'all',
                    count: 1,
                    text: 'All'
                }],
                selected: 4,
                inputEnabled: false
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
                valueDecimals: 0,
                split: true
            },

            series: seriesOptions
        });
    }

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

      $("#datatable-responsive").DataTable();
      $(".select2_multiple").select2({
          placeholder: "Please Select",
          allowClear: true
      });
      function updateGraph(e) {
        if (e != null)
            e.preventDefault();
        var selected_dates = document.getElementById("time_frame");
        var dates = selected_dates.value.split(" - ");

        var selected_status = document.getElementById("request_status");
        var statuses = selected_status.selectedOptions;

        //alert(statuses[0].value);
        //alert(statuses[1].value);

        var selected_semester = document.getElementById("semester");
        var semester = selected_semester.value;

        console.log(semester);

        //var data_dates = [];
        var data_statuses = [];
        //var data_semesters = [];

        //data_dates.push(dates[0]);
        //data_dates.push(dates[1]);

        Array.prototype.forEach.call(statuses, element => {
          data_statuses.push(element.value);
        });

        /*Array.prototype.forEach.call(semesters, element => {
          data_semesters.push(element.value);
        });

        var dates_json = JSON.stringify(data_dates);
        var statuses_json = JSON.stringify(data_statuses);
        var semesters_json = JSON.stringify(data_semesters);*/

        seriesOptions = [],
        seriesCounter = 0;

        $.each(data_statuses, function (i, status_id) {

          $.getJSON('https://booktracker.byu.edu/?controller=command&action=update_graph&start_date='+dates[0]+'&end_date='+dates[1]+'&request_status='+status_id+'&semester='+semester, function(data) {
          //$.getJSON('https://www.highcharts.com/samples/data/jsonp.php?filename=' + name.toLowerCase() + '-c.json&callback=?',    function (data) { //just make this our command controller function!

              seriesOptions[i] = { //{timestamp, datapoint}, ...
                  name: request_statuses[status_id-1].name,
                  data: data,
                  //type: 'spline',
              };

              // As we're loading the data asynchronously, we don't know what order it will arrive. So
              // we keep a counter and create the chart when all the data is loaded.
              seriesCounter += 1;

              if (seriesCounter === data_statuses.length) {
                  createChart();
              }
          });
      });
        
    }

    updateGraph(null);

</script>