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
 <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
          <nav>
            <div class="nav nav-tabs nav-fill" role="tablist">
             <a class="nav-item nav-link" id="lastOneYearClick" data-toggle="tab" role="tab">Last year</a>

             <a class="nav-item nav-link" id="lastsixMonthClick" data-toggle="tab" role="tab">Last 6 Month</a>
              <a class="nav-item nav-link active" id="lastthreeMonthClick" data-toggle="tab" role="tab">Last 3 Month</a>
              <a class="nav-item nav-link" id="lastMonthClick" data-toggle="tab" role="tab">Last Month</a>
              <a class="nav-item nav-link" id="lastsevendayClick" data-toggle="tab" role="tab">Last 7 Day</a>
             <!--  <a class="nav-item nav-link" id="oneMonthClick" data-toggle="tab" role="tab">1M</a>
              <a class="nav-item nav-link" id="threeMonthClick" data-toggle="tab" role="tab">3M</a>
              <a class="nav-item nav-link" id="sixMonthClick" data-toggle="tab" role="tab">6M</a>
              <a class="nav-item nav-link" id="OneYearClick" data-toggle="tab" role="tab">1YR</a> -->
            </div>
          </nav>
         
  <br>
<form id="search-frm" method="post">
  <div class="row">
  <div class="col-md-4">
  <div class="form-group">
    <label for="startDate" class="control-label">Start date</label>
    <input type="date" class="form-control form-control-sm" name="startDate" id="startDate" required>
  </div>
  </div>
   <div class="col-md-4">
  <div class="form-group">
    <label for="endDate" class="control-label">End Date</label>
    <input type="date" class="form-control form-control-sm" name="endDate" id="endDate" required>
  </div>
  </div>
   <div class="col-md-4">
  <div class="form-group">
    <label></label>
  <input type="submit" value="Search" class="btn btn-primary">
</div>
</div>

</div>
</div>
</form>
<br>
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
           //showGraph();
           pageLoadGraph();
        });


        function showGraph()
        {
            {
                 
                $.post("../classes/FileData.php",
               
                function (data)
                {

                    var obj = JSON.parse(data);

                    var name = [];
                    var marks = [];
                    var maths = [];

                    
                    for (var i in obj) {
                       // console.log(obj[i]);
                        name.push(obj[i].title);
                        marks.push(obj[i].timeline);
                        maths.push(obj[i].file_status);
                    }

                    



                    var chartdata = {
                        labels: ["Pending","On Progress","Success","Error"],
                        datasets: [
                            {
                                label: 'File timeline',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [1,3,2,1]
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


<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
 function formatDate(date) {
    
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('-');

}

function pageLoadGraph()  {

   var currntDate = formatDate(new Date());
   var now = new Date();
   now.setDate(now.getDate() - 365);
   var finalDate = formatDate(now);

    $.post("../classes/FileDataRever.php?date="+currntDate+"&date1="+finalDate, function (data)
                {
                  console.log(data);
                  if(data == []){

                      var chartdata = {
                        labels: ["Pending","On Progress","Success","Error"],

                        datasets: [
                            {
                                label: 'File timeline',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [0,0,0,0]
                            }
                        ]

                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });


                  }else{

                    var obj = JSON.parse(data);
                    var pending_filter = obj.filter( element => element.file_status =="Pending")
                    //alert(pending_filter.length);
                    var progre_filter = obj.filter( element => element.file_status =="On Progress")
                    //alert(progre_filter.length);
                    var done_filter = obj.filter( element => element.file_status =="Success")
                    //alert(done_filter.length);
                    var error_filter = obj.filter( element => element.file_status =="Error")
                    //alert(error_filter.length);

                    var name = [];
                    var marks = [];
                    var maths = [];

                    
                    for (var i in obj) {
                       // alert(obj[i].title);
                        name.push(obj[i].title);
                        marks.push(obj[i].timeline);
                        maths.push(obj[i].file_status);
                    }

                      var chartdata = {
                        labels: ["Pending","On Progress","Success","Error"],

                        datasets: [
                            {
                                label: 'File timeline',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
                            }
                        ]

                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });

                    var chartdataPie = {
                          labels: ["Pending","On Progress","Success","Error"],
                          datasets: [{
                          label: 'File timeline',
                          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
                          hoverBackgroundColor: 'rgba(230, 236, 235, 0.75)',
                          hoverBorderColor: 'rgba(230, 236, 235, 0.75)',
                          data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]

                        }]
                      };
                      var graphTargetPie = $("#graphCanvasPie");
                      var barGraph = new Chart(graphTargetPie, {
                      type: 'pie',
                      data: chartdataPie,

                    });

                 

                    var chartdataline = {
                        labels: ["Pending","On Progress","Success","Error"],
                        datasets: [
                            {   
                                label: 'File timeline',
                                //backgroundColor: '#fffff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
                       
                        }]

                      };
                      var graphTargetline = $("#graphCanvasline");
                      var barGraph = new Chart(graphTargetline, {
                      type: 'line',
                      data: chartdataline,

                    });

                  }

                    
      });

}
//do something
  //alert(formatDate(new Date()));

 $('#lastMonthClick').click(function(){
  //do something
  var currntDate = formatDate(new Date());
  var now = new Date();
   now.setDate(now.getDate() - 30);
  var finalDate = formatDate(now);

    $.post("../classes/FileDataRever.php?date="+currntDate+"&date1="+finalDate, function (data)
                {
                  console.log(data);
                  if(data == []){

                      var chartdata = {
                        labels: ["Pending","On Progress","Success","Error"],

                        datasets: [
                            {
                                label: 'File timeline',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [0,0,0,0]
                            }
                        ]

                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });


                  }else{

                    var obj = JSON.parse(data);
                    var pending_filter = obj.filter( element => element.file_status =="Pending")
                    //alert(pending_filter.length);
                    var progre_filter = obj.filter( element => element.file_status =="On Progress")
                    //alert(progre_filter.length);
                    var done_filter = obj.filter( element => element.file_status =="Success")
                    //alert(done_filter.length);
                    var error_filter = obj.filter( element => element.file_status =="Error")
                    //alert(error_filter.length);

                    var name = [];
                    var marks = [];
                    var maths = [];

                    
                    for (var i in obj) {
                       // alert(obj[i].title);
                        name.push(obj[i].title);
                        marks.push(obj[i].timeline);
                        maths.push(obj[i].file_status);
                    }

                      var chartdata = {
                        labels: ["Pending","On Progress","Success","Error"],

                        datasets: [
                            {
                                label: 'File timeline',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
                            }
                        ]

                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });

                    var chartdataPie = {
                          labels: ["Pending","On Progress","Success","Error"],
                          datasets: [{
                          label: 'File timeline',
                          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
                          hoverBackgroundColor: 'rgba(230, 236, 235, 0.75)',
                          hoverBorderColor: 'rgba(230, 236, 235, 0.75)',
                          data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]

                        }]
                      };
                      var graphTargetPie = $("#graphCanvasPie");
                      var barGraph = new Chart(graphTargetPie, {
                      type: 'pie',
                      data: chartdataPie,

                    });

                 

                    var chartdataline = {
                        labels: ["Pending","On Progress","Success","Error"],
                        datasets: [
                            {   
                                label: 'File timeline',
                                //backgroundColor: '#fffff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
                       
                        }]

                      };
                      var graphTargetline = $("#graphCanvasline");
                      var barGraph = new Chart(graphTargetline, {
                      type: 'line',
                      data: chartdataline,

                    });

                  }

                    
      });
     
});
$('#lastthreeMonthClick').click(function(){
  //do something
  var currntDate = formatDate(new Date());
  var now = new Date();
   now.setDate(now.getDate() - 90);
  var finalDate = formatDate(now);

    $.post("../classes/FileDataRever.php?date="+currntDate+"&date1="+finalDate, function (data)
                {
                  console.log(data);
                  if(data == []){

                      var chartdata = {
                        labels: ["Pending","On Progress","Success","Error"],

                        datasets: [
                            {
                                label: 'File timeline',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [0,0,0,0]
                            }
                        ]

                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });


                  }else{

                    var obj = JSON.parse(data);
                    var pending_filter = obj.filter( element => element.file_status =="Pending")
                    //alert(pending_filter.length);
                    var progre_filter = obj.filter( element => element.file_status =="On Progress")
                    //alert(progre_filter.length);
                    var done_filter = obj.filter( element => element.file_status =="Success")
                    //alert(done_filter.length);
                    var error_filter = obj.filter( element => element.file_status =="Error")
                    //alert(error_filter.length);

                    var name = [];
                    var marks = [];
                    var maths = [];

                    
                    for (var i in obj) {
                       // alert(obj[i].title);
                        name.push(obj[i].title);
                        marks.push(obj[i].timeline);
                        maths.push(obj[i].file_status);
                    }

                      var chartdata = {
                        labels: ["Pending","On Progress","Success","Error"],

                        datasets: [
                            {
                                label: 'File timeline',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
                            }
                        ]

                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });

                    var chartdataPie = {
                          labels: ["Pending","On Progress","Success","Error"],
                          datasets: [{
                          label: 'File timeline',
                          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
                          hoverBackgroundColor: 'rgba(230, 236, 235, 0.75)',
                          hoverBorderColor: 'rgba(230, 236, 235, 0.75)',
                          data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]

                        }]
                      };
                      var graphTargetPie = $("#graphCanvasPie");
                      var barGraph = new Chart(graphTargetPie, {
                      type: 'pie',
                      data: chartdataPie,

                    });

                 

                    var chartdataline = {
                        labels: ["Pending","On Progress","Success","Error"],
                        datasets: [
                            {   
                                label: 'File timeline',
                                //backgroundColor: '#fffff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
                       
                        }]

                      };
                      var graphTargetline = $("#graphCanvasline");
                      var barGraph = new Chart(graphTargetline, {
                      type: 'line',
                      data: chartdataline,

                    });

                  }

                    
      });
     
});
$('#lastsixMonthClick').click(function(){
  //do something
  var currntDate = formatDate(new Date());
  var now = new Date();
   now.setDate(now.getDate() - 180);
  var finalDate = formatDate(now);

    $.post("../classes/FileDataRever.php?date="+currntDate+"&date1="+finalDate, function (data)
                {
                  console.log(data);
                  if(data == []){

                      var chartdata = {
                        labels: ["Pending","On Progress","Success","Error"],

                        datasets: [
                            {
                                label: 'File timeline',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [0,0,0,0]
                            }
                        ]

                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });


                  }else{

                    var obj = JSON.parse(data);
                    var pending_filter = obj.filter( element => element.file_status =="Pending")
                    //alert(pending_filter.length);
                    var progre_filter = obj.filter( element => element.file_status =="On Progress")
                    //alert(progre_filter.length);
                    var done_filter = obj.filter( element => element.file_status =="Success")
                    //alert(done_filter.length);
                    var error_filter = obj.filter( element => element.file_status =="Error")
                    //alert(error_filter.length);

                    var name = [];
                    var marks = [];
                    var maths = [];

                    
                    for (var i in obj) {
                       // alert(obj[i].title);
                        name.push(obj[i].title);
                        marks.push(obj[i].timeline);
                        maths.push(obj[i].file_status);
                    }

                      var chartdata = {
                        labels: ["Pending","On Progress","Success","Error"],

                        datasets: [
                            {
                                label: 'File timeline',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
                            }
                        ]

                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });

                    var chartdataPie = {
                          labels: ["Pending","On Progress","Success","Error"],
                          datasets: [{
                          label: 'File timeline',
                          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
                          hoverBackgroundColor: 'rgba(230, 236, 235, 0.75)',
                          hoverBorderColor: 'rgba(230, 236, 235, 0.75)',
                          data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]

                        }]
                      };
                      var graphTargetPie = $("#graphCanvasPie");
                      var barGraph = new Chart(graphTargetPie, {
                      type: 'pie',
                      data: chartdataPie,

                    });

                 

                    var chartdataline = {
                        labels: ["Pending","On Progress","Success","Error"],
                        datasets: [
                            {   
                                label: 'File timeline',
                                //backgroundColor: '#fffff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
                       
                        }]

                      };
                      var graphTargetline = $("#graphCanvasline");
                      var barGraph = new Chart(graphTargetline, {
                      type: 'line',
                      data: chartdataline,

                    });

                  }

                    
      });
     
});
$('#lastOneYearClick').click(function(){
  //do something
  var currntDate = formatDate(new Date());
  var now = new Date();
   now.setDate(now.getDate() - 365);
  var finalDate = formatDate(now);

    $.post("../classes/FileDataRever.php?date="+currntDate+"&date1="+finalDate, function (data)
                {
                  console.log(data);
                  if(data == []){

                      var chartdata = {
                        labels: ["Pending","On Progress","Success","Error"],

                        datasets: [
                            {
                                label: 'File timeline',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [0,0,0,0]
                            }
                        ]

                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });


                  }else{

                    var obj = JSON.parse(data);
                    var pending_filter = obj.filter( element => element.file_status =="Pending")
                    //alert(pending_filter.length);
                    var progre_filter = obj.filter( element => element.file_status =="On Progress")
                    //alert(progre_filter.length);
                    var done_filter = obj.filter( element => element.file_status =="Success")
                    //alert(done_filter.length);
                    var error_filter = obj.filter( element => element.file_status =="Error")
                    //alert(error_filter.length);

                    var name = [];
                    var marks = [];
                    var maths = [];

                    
                    for (var i in obj) {
                       // alert(obj[i].title);
                        name.push(obj[i].title);
                        marks.push(obj[i].timeline);
                        maths.push(obj[i].file_status);
                    }

                      var chartdata = {
                        labels: ["Pending","On Progress","Success","Error"],

                        datasets: [
                            {
                                label: 'File timeline',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
                            }
                        ]

                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });

                    var chartdataPie = {
                          labels: ["Pending","On Progress","Success","Error"],
                          datasets: [{
                          label: 'File timeline',
                          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
                          hoverBackgroundColor: 'rgba(230, 236, 235, 0.75)',
                          hoverBorderColor: 'rgba(230, 236, 235, 0.75)',
                          data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]

                        }]
                      };
                      var graphTargetPie = $("#graphCanvasPie");
                      var barGraph = new Chart(graphTargetPie, {
                      type: 'pie',
                      data: chartdataPie,

                    });

                 

                    var chartdataline = {
                        labels: ["Pending","On Progress","Success","Error"],
                        datasets: [
                            {   
                                label: 'File timeline',
                                //backgroundColor: '#fffff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
                       
                        }]

                      };
                      var graphTargetline = $("#graphCanvasline");
                      var barGraph = new Chart(graphTargetline, {
                      type: 'line',
                      data: chartdataline,

                    });

                  }

                    
      });
     
});
  


$('#lastsevendayClick').click(function(){
  //do something
  var currntDate = formatDate(new Date());
  var now = new Date();
   now.setDate(now.getDate() - 7);
  var finalDate = formatDate(now);

    $.post("../classes/FileDataRever.php?date="+currntDate+"&date1="+finalDate, function (data)
                {
                  console.log(data);
                  if(data == []){

                      var chartdata = {
                        labels: ["Pending","On Progress","Success","Error"],

                        datasets: [
                            {
                                label: 'File timeline',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [0,0,0,0]
                            }
                        ]

                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });


                  }else{

                    var obj = JSON.parse(data);
                    var pending_filter = obj.filter( element => element.file_status =="Pending")
                    //alert(pending_filter.length);
                    var progre_filter = obj.filter( element => element.file_status =="On Progress")
                    //alert(progre_filter.length);
                    var done_filter = obj.filter( element => element.file_status =="Success")
                    //alert(done_filter.length);
                    var error_filter = obj.filter( element => element.file_status =="Error")
                    //alert(error_filter.length);

                    var name = [];
                    var marks = [];
                    var maths = [];

                    
                    for (var i in obj) {
                       // alert(obj[i].title);
                        name.push(obj[i].title);
                        marks.push(obj[i].timeline);
                        maths.push(obj[i].file_status);
                    }

                      var chartdata = {
                        labels: ["Pending","On Progress","Success","Error"],

                        datasets: [
                            {
                                label: 'File timeline',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
                            }
                        ]

                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });

                    var chartdataPie = {
                          labels: ["Pending","On Progress","Success","Error"],
                          datasets: [{
                          label: 'File timeline',
                          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
                          hoverBackgroundColor: 'rgba(230, 236, 235, 0.75)',
                          hoverBorderColor: 'rgba(230, 236, 235, 0.75)',
                          data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]

                        }]
                      };
                      var graphTargetPie = $("#graphCanvasPie");
                      var barGraph = new Chart(graphTargetPie, {
                      type: 'pie',
                      data: chartdataPie,

                    });

                 

                    var chartdataline = {
                        labels: ["Pending","On Progress","Success","Error"],
                        datasets: [
                            {   
                                label: 'File timeline',
                                //backgroundColor: '#fffff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
                       
                        }]

                      };
                      var graphTargetline = $("#graphCanvasline");
                      var barGraph = new Chart(graphTargetline, {
                      type: 'line',
                      data: chartdataline,

                    });

                  }

                    
      });
     
});

// $('#oneMonthClick').click(function(){
//   //do something
//   var currntDate = formatDate(new Date());
//   var now = new Date();
//    now.setDate(now.getDate() + 30);
//   var finalDate = formatDate(now);

//     $.post("../classes/FileData.php?date="+currntDate+"&date1="+finalDate, function (data)
//                 {
//                   console.log(data);
//                   if(data == []){

//                       var chartdata = {
//                         labels: ["Pending","On Progress","Success","Error"],

//                         datasets: [
//                             {
//                                 label: 'File timeline',
//                                 backgroundColor: '#49e2ff',
//                                 borderColor: '#46d5f1',
//                                 hoverBackgroundColor: '#CCCCCC',
//                                 hoverBorderColor: '#666666',
//                                 data: [0,0,0,0]
//                             }
//                         ]

//                     };

//                     var graphTarget = $("#graphCanvas");

//                     var barGraph = new Chart(graphTarget, {
//                         type: 'bar',
//                         data: chartdata
//                     });


//                   }else{

//                     var obj = JSON.parse(data);
//                     var pending_filter = obj.filter( element => element.file_status =="Pending")
//                     //alert(pending_filter.length);
//                     var progre_filter = obj.filter( element => element.file_status =="On Progress")
//                     //alert(progre_filter.length);
//                     var done_filter = obj.filter( element => element.file_status =="Success")
//                     //alert(done_filter.length);
//                     var error_filter = obj.filter( element => element.file_status =="Error")
//                     //alert(error_filter.length);

//                     var name = [];
//                     var marks = [];
//                     var maths = [];

                    
//                     for (var i in obj) {
//                        // alert(obj[i].title);
//                         name.push(obj[i].title);
//                         marks.push(obj[i].timeline);
//                         maths.push(obj[i].file_status);
//                     }

//                       var chartdata = {
//                         labels: ["Pending","On Progress","Success","Error"],

//                         datasets: [
//                             {
//                                 label: 'File timeline',
//                                 backgroundColor: '#49e2ff',
//                                 borderColor: '#46d5f1',
//                                 hoverBackgroundColor: '#CCCCCC',
//                                 hoverBorderColor: '#666666',
//                                 data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
//                             }
//                         ]

//                     };

//                     var graphTarget = $("#graphCanvas");

//                     var barGraph = new Chart(graphTarget, {
//                         type: 'bar',
//                         data: chartdata
//                     });

//                     var chartdataPie = {
//                           labels: ["Pending","On Progress","Success","Error"],
//                           datasets: [{
//                           label: 'File timeline',
//                           backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
//                           hoverBackgroundColor: 'rgba(230, 236, 235, 0.75)',
//                           hoverBorderColor: 'rgba(230, 236, 235, 0.75)',
//                           data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]

//                         }]
//                       };
//                       var graphTargetPie = $("#graphCanvasPie");
//                       var barGraph = new Chart(graphTargetPie, {
//                       type: 'pie',
//                       data: chartdataPie,

//                     });

                 

//                     var chartdataline = {
//                         labels: ["Pending","On Progress","Success","Error"],
//                         datasets: [
//                             {   
//                                 label: 'File timeline',
//                                 //backgroundColor: '#fffff',
//                                 borderColor: '#46d5f1',
//                                 hoverBackgroundColor: '#CCCCCC',
//                                 hoverBorderColor: '#666666',
//                                 data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
                       
//                         }]

//                       };
//                       var graphTargetline = $("#graphCanvasline");
//                       var barGraph = new Chart(graphTargetline, {
//                       type: 'line',
//                       data: chartdataline,

//                     });

//                   }

                    
//       });
     
// });
// $('#threeMonthClick').click(function(){
//   //do something
//   var currntDate = formatDate(new Date());
//   var now = new Date();
//    now.setDate(now.getDate() + 90);
//   var finalDate = formatDate(now);

//     $.post("../classes/FileData.php?date="+currntDate+"&date1="+finalDate, function (data)
//                 {
//                   console.log(data);
//                   if(data == []){

//                       var chartdata = {
//                         labels: ["Pending","On Progress","Success","Error"],

//                         datasets: [
//                             {
//                                 label: 'File timeline',
//                                 backgroundColor: '#49e2ff',
//                                 borderColor: '#46d5f1',
//                                 hoverBackgroundColor: '#CCCCCC',
//                                 hoverBorderColor: '#666666',
//                                 data: [0,0,0,0]
//                             }
//                         ]

//                     };

//                     var graphTarget = $("#graphCanvas");

//                     var barGraph = new Chart(graphTarget, {
//                         type: 'bar',
//                         data: chartdata
//                     });


//                   }else{

//                     var obj = JSON.parse(data);
//                     var pending_filter = obj.filter( element => element.file_status =="Pending")
//                     //alert(pending_filter.length);
//                     var progre_filter = obj.filter( element => element.file_status =="On Progress")
//                     //alert(progre_filter.length);
//                     var done_filter = obj.filter( element => element.file_status =="Success")
//                     //alert(done_filter.length);
//                     var error_filter = obj.filter( element => element.file_status =="Error")
//                     //alert(error_filter.length);

//                     var name = [];
//                     var marks = [];
//                     var maths = [];

                    
//                     for (var i in obj) {
//                        // alert(obj[i].title);
//                         name.push(obj[i].title);
//                         marks.push(obj[i].timeline);
//                         maths.push(obj[i].file_status);
//                     }

//                       var chartdata = {
//                         labels: ["Pending","On Progress","Success","Error"],

//                         datasets: [
//                             {
//                                 label: 'File timeline',
//                                 backgroundColor: '#49e2ff',
//                                 borderColor: '#46d5f1',
//                                 hoverBackgroundColor: '#CCCCCC',
//                                 hoverBorderColor: '#666666',
//                                 data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
//                             }
//                         ]

//                     };

//                     var graphTarget = $("#graphCanvas");

//                     var barGraph = new Chart(graphTarget, {
//                         type: 'bar',
//                         data: chartdata
//                     });

//                     var chartdataPie = {
//                           labels: ["Pending","On Progress","Success","Error"],
//                           datasets: [{
//                           label: 'File timeline',
//                           backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
//                           hoverBackgroundColor: 'rgba(230, 236, 235, 0.75)',
//                           hoverBorderColor: 'rgba(230, 236, 235, 0.75)',
//                           data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]

//                         }]
//                       };
//                       var graphTargetPie = $("#graphCanvasPie");
//                       var barGraph = new Chart(graphTargetPie, {
//                       type: 'pie',
//                       data: chartdataPie,

//                     });

                 

//                     var chartdataline = {
//                         labels: ["Pending","On Progress","Success","Error"],
//                         datasets: [
//                             {   
//                                 label: 'File timeline',
//                                 //backgroundColor: '#fffff',
//                                 borderColor: '#46d5f1',
//                                 hoverBackgroundColor: '#CCCCCC',
//                                 hoverBorderColor: '#666666',
//                                 data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
                       
//                         }]

//                       };
//                       var graphTargetline = $("#graphCanvasline");
//                       var barGraph = new Chart(graphTargetline, {
//                       type: 'line',
//                       data: chartdataline,

//                     });

//                   }

                    
//       });
     
// });
// $('#sixMonthClick').click(function(){
//   //do something
//   var currntDate = formatDate(new Date());
//   var now = new Date();
//    now.setDate(now.getDate() + 180);
//   var finalDate = formatDate(now);

//     $.post("../classes/FileData.php?date="+currntDate+"&date1="+finalDate, function (data)
//                 {
//                   console.log(data);
//                   if(data == []){

//                       var chartdata = {
//                         labels: ["Pending","On Progress","Success","Error"],

//                         datasets: [
//                             {
//                                 label: 'File timeline',
//                                 backgroundColor: '#49e2ff',
//                                 borderColor: '#46d5f1',
//                                 hoverBackgroundColor: '#CCCCCC',
//                                 hoverBorderColor: '#666666',
//                                 data: [0,0,0,0]
//                             }
//                         ]

//                     };

//                     var graphTarget = $("#graphCanvas");

//                     var barGraph = new Chart(graphTarget, {
//                         type: 'bar',
//                         data: chartdata
//                     });


//                   }else{

//                     var obj = JSON.parse(data);
//                     var pending_filter = obj.filter( element => element.file_status =="Pending")
//                     //alert(pending_filter.length);
//                     var progre_filter = obj.filter( element => element.file_status =="On Progress")
//                     //alert(progre_filter.length);
//                     var done_filter = obj.filter( element => element.file_status =="Success")
//                     //alert(done_filter.length);
//                     var error_filter = obj.filter( element => element.file_status =="Error")
//                     //alert(error_filter.length);

//                     var name = [];
//                     var marks = [];
//                     var maths = [];

                    
//                     for (var i in obj) {
//                        // alert(obj[i].title);
//                         name.push(obj[i].title);
//                         marks.push(obj[i].timeline);
//                         maths.push(obj[i].file_status);
//                     }

//                       var chartdata = {
//                         labels: ["Pending","On Progress","Success","Error"],

//                         datasets: [
//                             {
//                                 label: 'File timeline',
//                                 backgroundColor: '#49e2ff',
//                                 borderColor: '#46d5f1',
//                                 hoverBackgroundColor: '#CCCCCC',
//                                 hoverBorderColor: '#666666',
//                                 data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
//                             }
//                         ]

//                     };

//                     var graphTarget = $("#graphCanvas");

//                     var barGraph = new Chart(graphTarget, {
//                         type: 'bar',
//                         data: chartdata
//                     });

//                     var chartdataPie = {
//                           labels: ["Pending","On Progress","Success","Error"],
//                           datasets: [{
//                           label: 'File timeline',
//                           backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
//                           hoverBackgroundColor: 'rgba(230, 236, 235, 0.75)',
//                           hoverBorderColor: 'rgba(230, 236, 235, 0.75)',
//                           data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]

//                         }]
//                       };
//                       var graphTargetPie = $("#graphCanvasPie");
//                       var barGraph = new Chart(graphTargetPie, {
//                       type: 'pie',
//                       data: chartdataPie,

//                     });

                 

//                     var chartdataline = {
//                         labels: ["Pending","On Progress","Success","Error"],
//                         datasets: [
//                             {   
//                                 label: 'File timeline',
//                                 //backgroundColor: '#fffff',
//                                 borderColor: '#46d5f1',
//                                 hoverBackgroundColor: '#CCCCCC',
//                                 hoverBorderColor: '#666666',
//                                 data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
                       
//                         }]

//                       };
//                       var graphTargetline = $("#graphCanvasline");
//                       var barGraph = new Chart(graphTargetline, {
//                       type: 'line',
//                       data: chartdataline,

//                     });

//                   }

                    
//       });
     
// });
// $('#OneYearClick').click(function(){
//   //do something
//   var currntDate = formatDate(new Date());
//   var now = new Date();
//    now.setDate(now.getDate() + 365);
//   var finalDate = formatDate(now);

//     $.post("../classes/FileData.php?date="+currntDate+"&date1="+finalDate, function (data)
//                 {
//                   console.log(data);
//                   if(data == []){

//                       var chartdata = {
//                         labels: ["Pending","On Progress","Success","Error"],

//                         datasets: [
//                             {
//                                 label: 'File timeline',
//                                 backgroundColor: '#49e2ff',
//                                 borderColor: '#46d5f1',
//                                 hoverBackgroundColor: '#CCCCCC',
//                                 hoverBorderColor: '#666666',
//                                 data: [0,0,0,0]
//                             }
//                         ]

//                     };

//                     var graphTarget = $("#graphCanvas");

//                     var barGraph = new Chart(graphTarget, {
//                         type: 'bar',
//                         data: chartdata
//                     });


//                   }else{

//                     var obj = JSON.parse(data);
//                     var pending_filter = obj.filter( element => element.file_status =="Pending")
//                     //alert(pending_filter.length);
//                     var progre_filter = obj.filter( element => element.file_status =="On Progress")
//                     //alert(progre_filter.length);
//                     var done_filter = obj.filter( element => element.file_status =="Success")
//                     //alert(done_filter.length);
//                     var error_filter = obj.filter( element => element.file_status =="Error")
//                     //alert(error_filter.length);

//                     var name = [];
//                     var marks = [];
//                     var maths = [];

                    
//                     for (var i in obj) {
//                        // alert(obj[i].title);
//                         name.push(obj[i].title);
//                         marks.push(obj[i].timeline);
//                         maths.push(obj[i].file_status);
//                     }

//                       var chartdata = {
//                         labels: ["Pending","On Progress","Success","Error"],

//                         datasets: [
//                             {
//                                 label: 'File timeline',
//                                 backgroundColor: '#49e2ff',
//                                 borderColor: '#46d5f1',
//                                 hoverBackgroundColor: '#CCCCCC',
//                                 hoverBorderColor: '#666666',
//                                 data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
//                             }
//                         ]

//                     };

//                     var graphTarget = $("#graphCanvas");

//                     var barGraph = new Chart(graphTarget, {
//                         type: 'bar',
//                         data: chartdata
//                     });

//                     var chartdataPie = {
//                           labels: ["Pending","On Progress","Success","Error"],
//                           datasets: [{
//                           label: 'File timeline',
//                           backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
//                           hoverBackgroundColor: 'rgba(230, 236, 235, 0.75)',
//                           hoverBorderColor: 'rgba(230, 236, 235, 0.75)',
//                           data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]

//                         }]
//                       };
//                       var graphTargetPie = $("#graphCanvasPie");
//                       var barGraph = new Chart(graphTargetPie, {
//                       type: 'pie',
//                       data: chartdataPie,

//                     });

                 

//                     var chartdataline = {
//                         labels: ["Pending","On Progress","Success","Error"],
//                         datasets: [
//                             {   
//                                 label: 'File timeline',
//                                 //backgroundColor: '#fffff',
//                                 borderColor: '#46d5f1',
//                                 hoverBackgroundColor: '#CCCCCC',
//                                 hoverBorderColor: '#666666',
//                                 data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
                       
//                         }]

//                       };
//                       var graphTargetline = $("#graphCanvasline");
//                       var barGraph = new Chart(graphTargetline, {
//                       type: 'line',
//                       data: chartdataline,

//                     });

//                   }

                    
//       });
     
// });

  $('#search-frm').submit(function(e){
    e.preventDefault();
   // start_loader()
    $.ajax({
      url:_base_url_+'classes/Master.php?f=filter',
      data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
      success:function(resp){
       //  alert(resp);
       
                    var obj = JSON.parse(resp);
                    var pending_filter = obj.filter( element => element.file_status =="Pending")
                    //alert(pending_filter.length);
                    var progre_filter = obj.filter( element => element.file_status =="On Progress")
                    //alert(progre_filter.length);
                    var done_filter = obj.filter( element => element.file_status =="Success")
                    //alert(done_filter.length);
                    var error_filter = obj.filter( element => element.file_status =="Error")
                    //alert(error_filter.length);

                    var name = [];
                    var marks = [];
                    var maths = [];

                    
                    for (var i in obj) {
                       // alert(obj[i].title);
                        name.push(obj[i].title);
                        marks.push(obj[i].timeline);
                        maths.push(obj[i].file_status);
                    }

                      var chartdata = {
                        labels: ["Pending","On Progress","Success","Error"],

                        datasets: [
                            {
                                label: 'File timeline',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
                            }
                        ]

                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });

                      var chartdataPie = {
                          labels: ["Pending","On Progress","Success","Error"],
                          datasets: [{
                          label: 'File timeline',
                          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
                          hoverBackgroundColor: 'rgba(230, 236, 235, 0.75)',
                          hoverBorderColor: 'rgba(230, 236, 235, 0.75)',
                          data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]

                        }]
                      };
                      var graphTargetPie = $("#graphCanvasPie");
                      var barGraph = new Chart(graphTargetPie, {
                      type: 'pie',
                      data: chartdataPie,

                    });

                 

                    var chartdataline = {
                        labels: ["Pending","On Progress","Success","Error"],
                        datasets: [
                            {   
                                label: 'File timeline',
                                //backgroundColor: '#fffff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: [pending_filter.length,progre_filter.length,done_filter.length,error_filter.length]
                       
                        }]

                      };
                      var graphTargetline = $("#graphCanvasline");
                      var barGraph = new Chart(graphTargetline, {
                      type: 'line',
                      data: chartdataline,

                    });


        }
    })
  })

</script>
