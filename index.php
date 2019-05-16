<?php 
include 'php/koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Kripsi - Dashboard</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link rel='shortcut icon' type='image/x-icon' href='img/logo.ico' />
	
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="vendor/DataTables/DataTables-1.10.16/css/jquery.dataTables.css">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span></button>
				<a class="navbar-brand" href="#"><span>Kripsi</span>Admin</a>
			</div>
		</div><!-- /.container-fluid -->
	</nav>
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<div class="profile-sidebar">
			<div class="profile-userpic">
				<img src="img/adm.png" class="img-responsive" alt="">
			</div>
			<div class="profile-usertitle">
				<div class="profile-usertitle-name">Admin</div>
				<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="divider"></div>
		<ul class="nav menu">
			<li class="active"><a href="index.html"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>
			<!--<li><a href="login.html"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>-->
		</ul>
	</div><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Dashboard</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Dashboard</h1>
			</div>
		</div><!--/.row-->

		<div class="panel panel-container">
			<div class="row">
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-teal panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-money color-teal"></em>
							<div class="large"><?php echo $crawler->getJumlahKategori("ekonomi"); ?></div>
							<div class="text-muted">Ekonomi</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-blue panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-futbol-o color-blue"></em>
							<div class="large"><?php echo $crawler->getJumlahKategori("olahraga"); ?></div>
							<div class="text-muted">Olahraga</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-orange panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-power-off color-red"></em>
							<div class="large"><?php echo $crawler->getJumlahKategori("teknologi"); ?></div>
							<div class="text-muted">Teknologi</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-red panel-widget ">
						<div class="row no-padding"><em class="fa fa-xl fa-users color-orange"></em>
							<div class="large"><?php echo $crawler->getJumlahKategori("entertainment"); ?></div>
							<div class="text-muted">Entertainment</div>
						</div>
					</div>
				</div>
			</div><!--/.row-->
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Crawl Berita
						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
					<div class="panel-body">
						<form action="php/aksi.php" method="post">
						<div class="row">
							<div class="col-md-12">
								<label>Pilih Kategori:</label>
							</div>							
							<div class="col-md-6">
								<div class="form-group">
									<select name="kategori" class="form-control">
										<option value="ekonomi">Ekonomi</option>
                            			<option value="olahraga">Olahraga</option>
                            			<option value="teknologi">Teknologi</option>
                            			<option value="entertainment">Entertainment</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<input type="submit" name="crawl" class="btn btn-primary" value="Mulai Crawl">
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Tabel Berita (<?php echo $crawler->getJumlahBerita(); ?> Berita)
						<!--<span class="pull-right clickable panel-toggle panel-button-tab-left">
							<em class="fa fa-toggle-up"></em>
						</span>-->
						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
					</div>
					<div class="panel-body">
						<table id="dataTable" class="display dataTable" role="grid" aria-describedby="example_info" style="width: 100%;" width="100%" cellspacing="0">
                  			<thead>
                    			<tr>
                      				<th>No</th>
                      				<th>Url</th>
                      				<th>Judul</th>
                      				<th>Isi</th>
                      				<th>Kategori</th>
                      				<th>Tanggal Crawl</th>
									<th>Opsi</th>
                    			</tr>
                  			</thead>
                  			<tfoot>
                    			<tr>
                      				<th>No</th>
                      				<th>Url</th>
                      				<th>Judul</th>
                      				<th>Isi</th>
                      				<th>Kategori</th>
									<th>Opsi</th>
                    			</tr>
                  			</tfoot>
                  			<tbody>
                  			<?php
		            			$no = 1;
		            			$data = mysqli_query($koneksi,"select * from $table order by tgl_ambil desc");
		            			while($d = mysqli_fetch_array($data)){
			      			?>
                    			<tr>
                      				<td><?php echo $no; ?></td>
                      				<td><a target="_blank" href="<?php echo $d['url']; ?>"><?php echo substr(strip_tags($d['url']), 0, 64); ?>...</a></td>
                      				<td><?php echo $d['judul']; ?></td>
                      				<td><?php echo substr(strip_tags($d['isi']), 0, 128); ?>.......</td>
                      				<td><?php echo $d['kategori']; ?></td>
                      				<td><?php echo $d['tgl_ambil']; ?></td>
                      				<td style="text-align:center">
									  	<button style="margin:6px" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-id="<?php echo $d['id']; ?>">
									  		<i class="fa fa-eye" aria-hidden="true"></i>
										</button>
										<form action="php/aksi.php" method="post" onsubmit="return confirm('Hapus data berita <?php echo $d['judul'];?>');">
											<input type="text" name="id" hidden value="<?php echo $d['id']; ?>">
											<button style="margin:6px" class="btn btn-danger" name="hapus" type="submit" value="hapus">
									  			<i class="fa fa-trash" aria-hidden="true"></i>
											</button>
										</form>
									</td>
                    			</tr>
							<?php 
								$no++;
								}
							?>
                  			</tbody>
                		</table>
					</div>
				</div>
			</div>
		</div><!--/.row-->
									
		<div class="col-sm-12">
			<p class="back-link">Lumino Theme by <a href="https://www.medialoot.com">Medialoot</a></p>
		</div>
	</div>	<!--/.main-->

	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
    	<div class="modal-dialog" id="fetched-data">
      		
		</div>
	</div>

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script>
	<script type="text/javascript" src="vendor/DataTables/DataTables-1.10.16/js/jquery.dataTables.js"></script>
	<script>
    $(document).ready(function() {
	   $('#dataTable').DataTable({
        "scrollX": true
       });
	   $('#myModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'get',
                url : 'pg/beritaView.php',
                data :  'id='+ rowid,
                success : function(data){
                    $('#fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
        });
	} );
</script>
		
</body>
</html>
