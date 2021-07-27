<?php
include 'db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM classes where id={$_GET['id']}")->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-class">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div id="msg" class="form-group"></div>
		<div class="form-group">
			<label for="level" class="control-label">Año / Semestre</label>
			<input type="text" class="form-control form-control-sm" name="level" id="level" value="<?php echo isset($level) ? $level : '' ?>">
		</div>
		<div class="form-group">
			<label for="section" class="control-label">Sección</label>
			<input type="text" class="form-control form-control-sm" name="section" id="section" value="<?php echo isset($section) ? $section : '' ?>">
		</div>
	</form>
</div>
<script>
	$(document).ready(function(){
		$('#manage-class').submit(function(e){
			e.preventDefault();
			start_load()
			$('#msg').html('')
			$.ajax({
				url:'ajax.php?action=save_class',
				method:'POST',
				data:$(this).serialize(),
				success:function(resp){
					if(resp == 1){
						alert_toast("Datos guardados exitosamente","success");
						setTimeout(function(){
							location.reload()	
						},1750)
					}else if(resp == 2){
						$('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Año / Semestre existe actualmente</div>')
						end_load()
					}
				}
			})
		})
	})

</script>