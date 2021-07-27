<?php if(!isset($conn)){ include 'db_connect.php'; } ?>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-student">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row">
          <div class="col-md-6">
            <div id="msg" class=""></div>
            <div class="form-group text-dark">
              <div class="form-group">
                <label for="" class="control-label">ID Estudiante</label>
                <input type="text" class="form-control form-control-sm" name="student_code" value="<?php echo isset($student_code) ? $student_code : '' ?>" required>
              </div>
            </div>
            <div class="form-group text-dark">
              <div class="form-group">
                <label for="" class="control-label">Nombre</label>
                <input type="text" class="form-control form-control-sm" name="firstname" value="<?php echo isset($firstname) ? $firstname : '' ?>" required>
              </div>
            </div>
            <div class="form-group text-dark">
              <div class="form-group">
                <label for="" class="control-label">Apellido</label>
                <input type="text" class="form-control form-control-sm" name="middlename" value="<?php echo isset($middlename) ? $middlename : '' ?>">
              </div>
            </div>
            <div class="form-group text-dark">
              <div class="form-group">
                <label for="" class="control-label">Segundo Apellido</label>
                <input type="text" class="form-control form-control-sm" name="lastname" value="<?php echo isset($lastname) ? $lastname : '' ?>" required>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Género</label>
              <select name="gender" id="" class="custom-select custom-select-sm" required>
                <option>Femenino</option>
                <option>Masculino</option>
              </select>
            </div>
            <div class="form-group text-dark">
              <div class="form-group">
                <label for="" class="control-label">Dirección</label>
                <textarea name="address" id="address" cols="30" rows="4" class="form-control"><?php echo isset($address) ? $address : '' ?></textarea>
              </div>
            </div>
            <div class="form-group text-dark">
              <div class="form-group">
                <label for="" class="control-label">Año/Semestre</label>
                <select name="class_id" id="" class="form-control select2 select2-sm" required>
                  <option></option> 
                  <?php 
                        $classes = $conn->query("SELECT * FROM classes order by level asc,section asc ");
                        while($row = $classes->fetch_array()):
                  ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($class_id) && $class_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['level'].'-'.$row['section']) ?></option>
                  <?php endwhile; ?>
                </select>
              </div>
            </div>
          </div>
        </div>
      </form>
  	</div>
  	<div class="card-footer border-top border-info">
  		<div class="d-flex w-100 justify-content-center align-items-center">
  			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-student">Guardar</button>
  			<a class="btn btn-flat bg-gradient-secondary mx-2" href="./index.php?page=student_list">Cancelar</a>
  		</div>
  	</div>
	</div>
</div>
<script>
	$('#manage-student').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_student',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Datos guardados exitosamente',"success");
					setTimeout(function(){
              location.href = 'index.php?page=student_list'
					},2000)
				}else if(resp == 2){
          $('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Código de estudiante existe actualmente.</div>')
          end_load()
        }
			}
		})
	})
  function displayImgCover(input,_this) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#cover').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
  }
</script>