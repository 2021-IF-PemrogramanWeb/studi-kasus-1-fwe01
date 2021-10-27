<?php

class TableRow extends RecursiveArrayIterator
{
	private $data;

	function __construct($data)
	{
		$this->data = $data;
	}

	function toRow()
	{
		$string = '<tr>';
		foreach ($this->data as $item) {
			$string .= '<td>';
			$string .= $item;
			$string .= '</td>';
		}
		$string .= '</tr>';
		return $string;
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Database and Table</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="adminlte/dist/css/adminlte.min.css">
    <!-- Datatable -->
    <link rel="stylesheet" href="adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <!--    <div class="content-wrapper">-->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Graph And Table</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">Graph And Table</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Table using Datatable Library, Connected to a database</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="myTable" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Sepal Length</th>
                                    <th>Sepal Width</th>
                                    <th>Petal Length</th>
                                    <th>Petal Width</th>
                                    <th>Class</th>
                                </tr>
                                </thead>
                                <tbody>
								<?php
								//Setting untuk di server
								$servername = "127.0.0.1"; $username = "u939538109_pweb"; $password = "!x=Oi8Uy"; $DBName = "u939538109_pweb";

								//Setting untuk di local
//								$servername = "127.0.0.1"; $username = "root"; $password = ""; $DBName = "pweb";

								try {
									$conn = new PDO("mysql:host=$servername;dbname=$DBName", $username, $password);
									// set the PDO error mode to exception
									$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									//Prepare MySQL statment
									$statement = $conn->prepare("select * from iris");
									$statement->execute();
									$results = $statement->setFetchMode(PDO::FETCH_ASSOC);
									foreach ($statement->fetchAll() as $result) {
										$row = new TableRow($result);
										echo $row->toRow();
									}
								} catch (PDOException $e) {
									echo "Getting data from database failed: " . $e->getMessage();
								}
								?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Sepal Length</th>
                                    <th>Sepal Width</th>
                                    <th>Petal Length</th>
                                    <th>Petal Width</th>
                                    <th>Class</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- End Of Table-->
        </div><!-- /.container-fluid -->
    </section>

    <footer class="main-footer" style="width: 100%; margin-left: 0">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.0.5
        </div>
        <strong>Copyright &copy; 2021 <a href="https://frederickwilliame.com">Frederick William E.</a> | Powered by <a
                    href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="adminlte/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI -->
<script src="adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="adminlte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="adminlte/dist/js/demo.js"></script>
<!-- FLOT CHARTS -->
<script src="adminlte/plugins/flot/jquery.flot.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="adminlte/plugins/flot-old/jquery.flot.resize.min.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="adminlte/plugins/flot-old/jquery.flot.pie.min.js"></script>
<!-- Page script -->
<!-- DataTables -->
<script src="adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- Init data table script-->
<script>
    $(function () {
        $("#myTable").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    });
</script>
</body>
</html>