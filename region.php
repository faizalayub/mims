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
   <body class="hold-transition sidebar-mini layout-fixed" onload="getRegionListOnLoad();">
      <div class="wrapper">
          <?php include "inc/sidebar.php"; ?>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
               <div class="container-fluid">
                  <div class="row mb-2">
                     <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Region List</h1>
                     </div>
                     <!-- /.col -->
                     <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                           <li class="breadcrumb-item active">Region List</li>
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
                            <p id="userstable_filter">Filter:
                            </p>
                              <table id="example" class="table table-bordered table-striped" style="text-align: center;">
                                 <thead>
                                    <tr>
                                       <th>Region</th>
                                       <th>Site</th>
                                       <th>Agency</th>
                                       <th>Model</th>
                                       <th>Serial No</th>
                                       <th>Brand</th>
                                       <th>Category</th>
                                       <th>Date</th>
                                       <th>Action</th>
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
      <script>
      function getRegionListOnLoad(){
      
        $.ajax({
          type:'post',
          url:'action.php',
          data:{"action":"getRegionListOnLoad"},
          success:function(result){
            var result_obj = JSON.parse(result);
      
            if(result_obj.valid){
             document.getElementById("tableData").innerHTML = result_obj.html;
             $('#example').DataTable({
                initComplete: function () {
                    this.api().columns(0).every( function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo('#userstable_filter')
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
    
            }else{
      
            }
          }
        })
      }

      function deleteItem(item_id){
          swal({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
          }).then((result) => {
            if(result.value){
              var formData = {
                "action"     : "deleteItem",
                "item_id" : item_id
              };
      
              $.ajax({
                type:'post',
                url:'action.php',
                data:formData,
                success:function(result){
                  var result_obj = JSON.parse(result);
      
                  if(result_obj.valid){
                    swal({
                      type:'success',
                      title:'Success',
                      html:result_obj.msg
                    }).then(function(){
                      location.reload();
                    });
                  }else{
                    swal({
                      type:'error',
                      title:'Oops..',
                      html:result_obj.msg
                    });
                  }
                }
              })
            }
          });
      }

    </script>  
   </body>
</html>