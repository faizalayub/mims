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
   <body class="hold-transition sidebar-mini layout-fixed" onload="getMonthlyItemListOnLoad();">

      <div class="wrapper">
          <?php include "inc/sidebar.php"; ?>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
               <div class="container-fluid">
                  <div class="row mb-2">
                     <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Monthly Spareparts Summary by Categories at HQ</h1>
                     </div>
                     <!-- /.col -->
                     <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                           <li class="breadcrumb-item active">Monthly</li>
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
                                       <th>January</th>
                                       <th>February</th>
                                       <th>March</th>
                                       <th>April</th>
                                       <th>May</th>
                                       <th>June</th>
                                       <th>July</th>
                                       <th>August</th>
                                       <th>September</th>
                                       <th>October</th>
                                       <th>November</th>
                                       <th>December</th>
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
        function getMonthlyItemListOnLoad(){
      
        $.ajax({
          type:'post',
          url:'action.php',
          data:{"action":"getMonthlyItemListOnLoad"},
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

    <script type="text/javascript">
    $(document).ready(function(){
      $.ajax({
        type:'post',
        url:'action.php',
        data:{"action":"getMonthlyGraph"},
        dataType : "JSON",
        success: function(data) {
          console.log(data);
          var category = [];
          var january = [];
          var february = [];
          var march = [];
          var april = [];
          var may = [];
          var june = [];
          var july = [];
          var august = [];
          var september = [];
          var october = [];
          var november = [];
          var december = [];

          for(var i in data) {
            category.push(data[i].category_desc);
            january.push(data[i].january);
            february.push(data[i].february);
            march.push(data[i].march);
            april.push(data[i].april);
            may.push(data[i].may);
            june.push(data[i].june);
            july.push(data[i].july);
            august.push(data[i].august);
            september.push(data[i].september);
            october.push(data[i].october);
            november.push(data[i].november);
            december.push(data[i].december);
          }

          var chartdata = {
            labels: category,
            datasets : [
              {
                label: 'January',
                barThickness: 5, 
                data: january,
                backgroundColor:'rgba(255, 99, 132, 0.2)'
              },
              {
                label: 'February',
                barThickness: 5, 
                data: february,
                backgroundColor:'rgba(54, 162, 235, 0.2)'
              },
              {
                label: 'March',
                barThickness: 5, 
                data: march,
                backgroundColor:'rgba(255, 206, 86, 0.2)'
              },
              {
                label: 'April',
                barThickness: 5, 
                data: april,
                backgroundColor:'rgba(75, 192, 192, 0.2)'
              },
              {
                label: 'May',
                barThickness: 5, 
                data: may,
                backgroundColor:'rgba(153, 102, 255, 0.2)'
              },
              {
                label: 'June',
                barThickness: 5, 
                data: june,
                backgroundColor:'rgba(255, 159, 64, 0.2)'
              },
              {
                label: 'July',
                barThickness: 5, 
                data: july,
                backgroundColor:'rgba(128, 128, 0, 0.2)'
              },
              {
                label: 'August',
                barThickness: 5, 
                data: august,
                backgroundColor:'rgba(25, 25, 112, 0.2)'
              },
              {
                label: 'September',
                barThickness: 5, 
                data: september,
                backgroundColor:'rgba(0, 206, 209, 0.2)'            
              },
              {
                label: 'October',
                barThickness: 5, 
                data: october,
                backgroundColor:'rgba(139, 0, 0, 0.2)'
              },
              {
                label: 'November',
                barThickness: 5, 
                data: november,
                backgroundColor:'rgba(0, 255, 0, 0.2)'
              },
              {
                label: 'December',
                barThickness: 5, 
                data: december,
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
                          labelString: 'Category',
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