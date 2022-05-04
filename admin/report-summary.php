<?php include "inc/app-top.php"; ?>
<!DOCTYPE html>
<html>
   <head>
      <?php include "inc/head.php"; ?>
      <style>
        .user-form {
        display: inline-block !important;
        width: 100% !important;
        margin: 2px 0 !important;
        padding: 5px 0 !important;
    }

    .user-submit{
      margin-top: 20px;
      float: right;
    }

    .card-body{
      width: 100% !important;

    }

      </style>
    

   </head>
   <body class="hold-transition sidebar-mini layout-fixed" onload="getSummaryListOnLoad();">

      <div class="wrapper">
          <?php include "inc/sidebar.php"; ?>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
               <div class="container-fluid">
                  <div class="row mb-2">
                     <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Spareparts Summary by Categories at all Region</h1>
                     </div>
                     <!-- /.col -->
                     <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                           <li class="breadcrumb-item active">Summary</li>
                        </ol>
                     </div>
                     <!-- /.col -->
                  </div>
                  <!-- /.row -->
               </div>
               <!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
               <div class="container-fluid">
                  <!-- Small boxes (Stat box) -->
                  <div class="row">
                  </div>
                  <!-- /.row -->
                  <!-- Main row -->
                  <div class="row">
                     <!-- Left col -->
                     <section class="col-lg-12 connectedSortable">
                        <div class="card">
                           <!-- /.card-header -->
                           <div class="card-body">
                            <div id="test1" style="float:right;"></div>
                              <br /> <br/>
                              <div id="container">
                                <canvas id="mycanvas"></canvas>
                              </div>
                              <table id="example" class="table table-bordered table-striped"  style="text-align: center;font-size:12px">
                                 <thead>
                                    <tr>
                                       <th>Category</th>
                                       <th>Kedah</th>
                                       <th>Sabah</th>
                                       <th>Johor</th>
                                       <th>Terengganu</th>
                                       <th>Labuan</th>
                                       <th>Perak</th>
                                       <th>Kelantan</th>
                                       <th>Pulau Pinang</th>
                                       <th>Melaka</th>
                                       <th>Pahang</th>
                                       <th>Miri</th>
                                       <th>Kuching</th>
                                    </tr>
                                 </thead>
                                 
                                 <tbody id="tableData">
                                
                                 </tbody>
                                
                              </table>
                           </div>
                           <!-- /.card-body -->
                        </div>
                     </section>
                     <!-- right col -->
                  </div>
                  <!-- /.row (main row) -->
               </div>
               <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
         </div>
         <!-- /.content-wrapper -->
         <!-- <footer class="main-footer">
            <?php include "inc/footer.php"; ?>
            </footer> -->
         <!-- Control Sidebar -->
         <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
         </aside>
         <!-- /.control-sidebar -->
      </div>
      <!-- ./wrapper -->
      <?php include "inc/js.php"; ?>
      <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
         <script>
        function getSummaryListOnLoad(){
      
        $.ajax({
          type:'post',
          url:'action.php',
          data:{"action":"getSummaryListOnLoad"},
          success:function(result){
            var result_obj = JSON.parse(result);
      
            if(result_obj.valid){
              document.getElementById("tableData").innerHTML = result_obj.html;
             var table = $('#example').DataTable({
                "pageLength": 50,
                "lengthChange": false,
                "bPaginate": false
             });

             new $.fn.dataTable.Buttons( table, {
                buttons: [
                    {
                    extend:    'excelHtml5',
                    text:      '<i class="fa fa-files-o"></i> Excel',
                    titleAttr: 'Excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                    },
                    {
                    extend:    'pdfHtml5',
                    text:      '<i class="fa fa-file-pdf-o"></i> PDF',
                    titleAttr: 'PDF',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    customize: function(doc) {
                      doc.defaultStyle.alignment = 'center',
                      doc.content[1].margin = [ 100, 0, 100, 0 ]
                    }, 
                    exportOptions: {
                        columns: ':visible'
                    }
                    },                 
                ]
            } );
            table.buttons().container().appendTo('#test1');
      
            }else{
      
            }
          }
        })
      }

    </script> 

    <script src="plugins/chart.js/Chart.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function(){
      $.ajax({
        type:'post',
        url:'action.php',
        data:{"action":"getSummaryGraph"},
        dataType : "JSON",
        success: function(data) {
          console.log(data);
          var category = [];
          var kedah = [];
          var sabah = [];
          var johor = [];
          var terengganu = [];
          var labuan = [];
          var perak = [];
          var kelantan = [];
          var penang = [];
          var melaka = [];
          var pahang = [];
          var miri = [];
          var kuching = [];

          for(var i in data) {
            category.push(data[i].category_desc);
            kedah.push(data[i].kedah);
            sabah.push(data[i].sabah);
            johor.push(data[i].johor);
            terengganu.push(data[i].terengganu);
            labuan.push(data[i].labuan);
            perak.push(data[i].perak);
            kelantan.push(data[i].kelantan);
            penang.push(data[i].penang);
            melaka.push(data[i].melaka);
            pahang.push(data[i].pahang);
            miri.push(data[i].miri);
            kuching.push(data[i].kuching);
          }

          var chartdata = {
            labels: category,
            datasets : [
              {
                label: 'Kedah',
                barThickness: 5, 
                data: kedah,
                backgroundColor:'rgba(255, 99, 132, 0.2)'
              },
              {
                label: 'Sabah',
                barThickness: 5, 
                data: sabah,
                backgroundColor:'rgba(54, 162, 235, 0.2)'
              },
              {
                label: 'Johor',
                barThickness: 5, 
                data: johor,
                backgroundColor:'rgba(255, 206, 86, 0.2)'
              },
              {
                label: 'Terengganu',
                barThickness: 5, 
                data: terengganu,
                backgroundColor:'rgba(75, 192, 192, 0.2)'
              },
              {
                label: 'Labuan',
                barThickness: 5, 
                data: labuan,
                backgroundColor:'rgba(153, 102, 255, 0.2)'
              },
              {
                label: 'Perak',
                barThickness: 5, 
                data: perak,
                backgroundColor:'rgba(255, 159, 64, 0.2)'
              },
              {
                label: 'Kelantan',
                barThickness: 5, 
                data: kelantan,
                backgroundColor:'rgba(128, 128, 0, 0.2)'
              },
              {
                label: 'Penang',
                barThickness: 5, 
                data: penang,
                backgroundColor:'rgba(25, 25, 112, 0.2)'
              },
              {
                label: 'Melaka',
                barThickness: 5, 
                data: melaka,
                backgroundColor:'rgba(0, 206, 209, 0.2)'              
              },
              {
                label: 'Pahang',
                barThickness: 5, 
                data: pahang,
                backgroundColor:'rgba(139, 0, 0, 0.2)'
              },
              {
                label: 'Miri',
                barThickness: 5, 
                data: miri,
                backgroundColor:'rgba(0, 255, 0, 0.2)'
              },
              {
                label: 'Kuching',
                barThickness: 5, 
                data: kuching,
                backgroundColor:'rgba(255, 255, 0, 0.2)'
              }
            ]
          };

          var options = {
              responsive:true,
              maintainAspectRatio: false,
              legend: {
                    display: true
              },
              scales: {
                  yAxes: [{
                      ticks: {
                          beginAtZero: true,
                          stepSize: 1
                      }
                  }],
                  xAxes: [{
                      scaleLabel: {
                          display: true,
                          labelString: 'Category'
                      }
                  }]
              }
          };

          var ctx = $("#mycanvas");

          var barGraph = new Chart(ctx, {
            type: 'bar',
            data: chartdata,
            options: options
          });
        },
        error: function(data) {
          console.log(data);
        }
      });
    });  

    </script>
   </body>
</html>