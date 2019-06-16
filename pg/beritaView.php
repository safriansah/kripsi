<?php
    include'../php/koneksi.php';
    $id=$_GET['id'];
	$d=$crawler->viewBerita($id);
?>
<!-- Modal content-->
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><?php echo $d['judul']; ?></h4>
	</div>
	<div class="modal-body">
		<p><?php echo $d['isi']; ?></p>
	</div>
	<div class="modal-footer">
		<?php echo $d['tgl_ambil']; ?>
	</div>
</div>
