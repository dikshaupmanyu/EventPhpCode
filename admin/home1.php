<h1>Welcome to <?php echo $_settings->info('name') ?></h1>
<hr>
<section class="content">
<div class="row">
           <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Users</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM users where type=2")->num_rows; ?>
                </span>
              </div>
            </div>
          </div>
        <!--   <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Events</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM event_list")->num_rows; ?>
                </span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Listed Audience</span>
                <span class="info-box-number"> <?php echo $conn->query("SELECT * FROM event_audience")->num_rows; ?></span>
              </div>
            </div>
          </div>
 -->
        <!--   <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Finished Event</span>
                <span class="info-box-number"><?php echo $conn->query("SELECT * FROM event_list where unix_timestamp(datetime_end) <= '".strtotime(date('Y-m-d H:i'))."' ")->num_rows; ?></span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">On-Going Events</span>
                <span class="info-box-number"><?php echo $conn->query("SELECT * FROM event_list where '".strtotime(date('Y-m-d H:i'))."' between unix_timestamp(datetime_start) and unix_timestamp(datetime_end) ")->num_rows; ?></span>
              </div>
            </div>
          </div> -->
         </div>


<!-- <script type="text/javascript" src="<?php echo base_url ?>dist/js/jquery.min.js"></script>
 -->
 <script type="text/javascript" src="<?php echo base_url ?>dist/js/Chart.min.js"></script>

    <div id="chart-container">
        <h3>Bar Graph Chart</h3>
        <canvas id="graphCanvas" style="width: 50%;height: 50%;"></canvas>
        <h3>Pie Chart (On the basis of file status)</h3>
        <canvas id="graphCanvasPie" style="width: 50%;height: 50%;"></canvas>
        <h3>Multi-Line Chart</h3>
        <canvas id="graphCanvasline" style="width: 50%;height: 50%;"></canvas>
       
    </div>

       
    <script>
        $(document).ready(function () {
            showGraph();
        });


        function showGraph()
        {
            {
                 
                $.post("../classes/Data.php",
               
                function (data)
                {

                    var obj = JSON.parse(data);

                    var name = [];
                    var marks = [];
                    var maths = [];

                    
                    for (var i in obj) {
                      //console.log(obj[i].maths_mark);
                        name.push(obj[i].title);
                        marks.push(obj[i].timeline);
                        maths.push(obj[i].file_status);
                    }

                    



                    var chartdata = {
                        labels: name,
                        datasets: [
                            {
                                label: 'File timeline',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: marks
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });

                    // var chartdataPie = {
                    //       labels: name,
                    //       datasets: [{
                    //       label: 'File timeline',
                    //       backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de','pink'],
                    //       hoverBackgroundColor: 'rgba(230, 236, 235, 0.75)',
                    //       hoverBorderColor: 'rgba(230, 236, 235, 0.75)',
                    //       data: marks

                    //     }]
                    //   };
                       var chartdataPie = {
                          labels: ["Pending","On Progress","Success","Error"],
                          datasets: [{
                          label: 'File timeline',
                          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
                          hoverBackgroundColor: 'rgba(230, 236, 235, 0.75)',
                          hoverBorderColor: 'rgba(230, 236, 235, 0.75)',
                          data: [1,3,2,1]

                        }]
                      };
                      var graphTargetPie = $("#graphCanvasPie");
                      var barGraph = new Chart(graphTargetPie, {
                      type: 'pie',
                      data: chartdataPie,

                    });

                 

                    var chartdataline = {
                        labels: name,
                        datasets: [
                            {
                                label: 'File timeline',
                                //backgroundColor: '#fffff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: marks
                       
                        }
                        // ,
                        // {
                        //         label: 'File Status',
                        //         //backgroundColor: '#fffff',
                        //         borderColor: 'red',
                        //         hoverBackgroundColor: 'yellow',
                        //         hoverBorderColor: 'green',
                        //         data: maths
                       
                        // }
                        ]
                      };
                      var graphTargetline = $("#graphCanvasline");
                      var barGraph = new Chart(graphTargetline, {
                      type: 'line',
                      data: chartdataline,

                    });



                });
            }
        }
        </script>
       
</section>

<!-- <?php
 
$dataPoints = array(
  array("y" => 39, "label" => "John"),
  array("y" => 46, "label" => "Mary"),
  array("y" => 65, "label" => "Maya"),
  array("y" => 90, "label" => "Rahul"),
  array("y" => 75, "label" => "Priya")
);
 
?>

<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
 
  data: [{
    type: "line",
    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
 
}
</script>

<div id="chartContainer" style="height: 370px; width: 100%;"></div> -->
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
       