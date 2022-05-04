<?php include "inc/app-top.php"; 
   ?>
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
   <body class="hold-transition sidebar-mini layout-fixed" onload="getItemListByAgencyOnLoad();">

      <div class="wrapper">
          <?php include "inc/sidebar.php"; ?>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
               <div class="container-fluid">
                  <div class="row mb-2">
                     <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Item List By Agency</h1>
                     </div>
                     <!-- /.col -->
                     <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                           <li class="breadcrumb-item active">Agency</li>
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
                            <div id="test" style="float:left;">Filter: </div>
                            <div id="test1" style="float:right;"></div>
                              <br /> <br/>
                              <div id="chart-container">
                                <canvas id="mycanvas"></canvas>
                              </div>
                              <table id="example" class="table table-bordered table-striped"  style="text-align: center;">
                                 <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>Category</th>
                                      <th>Brand</th>
                                      <th>Serial No</th>
                                       <th>Model</th>
                                       <th>Region</th>
                                       <th>Agency</th>
                                       <th>Site</th>
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
         function getItemListByAgencyOnLoad(){
      
        $.ajax({
          type:'post',
          url:'action.php',
          data:{"action":"getItemListByAgencyOnLoad"},
          success:function(result){
            var result_obj = JSON.parse(result);
      
            if(result_obj.valid){
              document.getElementById("tableData").innerHTML = result_obj.html;
             var table = $('#example').DataTable({
                initComplete: function () {
                    this.api().columns(6).every( function () {
                        var column = this;
                        var select = $('<select><option value="">All</option></select>')
                            .appendTo('#test')
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
         
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );
                            $( select ).click( function(e) {
                                e.stopPropagation();
                            });
         
                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                }
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
                    customize: function(doc) {
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
        data:{"action":"getAgencyGraph"},
        dataType : "JSON",
        success: function(data) {
          console.log(data);
          var agency = [];
          var total = [];

          for(var i in data) {
            agency.push(data[i].agency_desc);
            total.push(data[i].total);
          }

          var chartdata = {
            labels: agency,
            datasets : [
              {
                label: 'Total',
                barThickness: 20, 
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                data: total,
              }
            ]
          };

          var options = {
              responsive:true,
              maintainAspectRatio: false,
              legend: {
                    display: false
              },
              scales: {
                  yAxes: [{
                      scaleLabel: {
                          display: true,
                          labelString: 'Agency'
                      }
                  }],
                  xAxes: [{
                      ticks: {
                          beginAtZero: true,
                          stepSize: 1
                      }
                  }]
              }
          };

          var ctx = $("#mycanvas");

          var barGraph = new Chart(ctx, {
            type: 'horizontalBar',
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