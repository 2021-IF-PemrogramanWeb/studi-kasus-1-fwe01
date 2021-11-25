<?php

session_start();

if (!isset($_SESSION['auth_username'])) {
	header("Location: login.html");
	die();
}

include 'DBConnection.php';

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
                    <a  class="float-right" href="logout.php">
                        <div class="btn btn-outline-danger"> Logout</div>
                    </a>
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
                            <h3 class="card-title">Table using Datatable Library, Connected to a database with iris
                                dataset</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="iris-datatable" class="table table-bordered table-hover">
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
								try {
									//Prepare MySQL statement
									$statement = $conn->prepare("select * from iris");
									$statement->execute();
									$statement->setFetchMode(PDO::FETCH_ASSOC);
									$results = $statement->fetchAll();
									foreach ($results as $result) {
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
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="far fa-chart-bar"></i>
                                Chart of Reason, Connected to a database with reasons dataset
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="bar-chart" style="height: 600px;"></div>
                        </div>
                        <!-- /.card-body-->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Table using Datatable Library, Connected to a database with reasons
                                dataset</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="reason-datatable" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Reason</th>
                                    <th>Count</th>
                                </tr>
                                </thead>
                                <tbody>
								<?php
								try {
									//Prepare MySQL statement
									$statement = $conn->prepare(
										"
                                            select r.id, r.reason, s.total
                                            from (
                                                     select reason_id, count(id) as total
                                                     from service
                                                     group by reason_id
                                                 ) s
                                            join reasons r on s.reason_id = r.id
									    "
									);
									$statement->execute();
									$statement->setFetchMode(PDO::FETCH_ASSOC);
									$results = $statement->fetchAll();
									$nomor = 1;
									foreach ($results as $result) {
										$row = new TableRow($result);
										echo $row->toRow();
										$nomor++;
									}
								} catch (PDOException $e) {
									echo "Getting data from database failed: " . $e->getMessage();
								}
								?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Reason</th>
                                    <th>Count</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>

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
        $("#reason-datatable").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
        $("#iris-datatable").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    });
</script>
<script>
    $(function () {
        var data = []
        var bar_data = {
            // data : [[1,10], [2,8], [3,4], [4,13], [5,17], [6,9], ],
            data: [
				<?php
				foreach ($results as $result) {
					echo '[' . $result['id'] . ', ' . '' . $result['total'] . '],';
				}
				?>
            ],
            bars: {show: true}
        }
        $.plot('#bar-chart', [bar_data], {
            grid: {
                borderWidth: 1,
                borderColor: '#f3f3f3',
                tickColor: '#f3f3f3'
            },
            series: {
                bars: {
                    show: true, barWidth: 0.5, align: 'center',
                },
            },
            colors: ['#3c8dbc'],
        })
    })

    function labelFormatter(label, series) {
        return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
            + label
            + '<br>'
            + Math.round(series.percent) + '%</div>'
    }
</script>
</body>
</html>
