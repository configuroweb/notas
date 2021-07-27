<?php if(!isset($conn)){ include 'db_connect.php'; } ?>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-result">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div id="msg" class=""></div>
            <div class="form-group">
                <label for="" class="control-label">Estudiante</label>
                <select name="student_id" id="student_id" class="form-control select2 select2-sm" required>
                  <option></option> 
                  <?php 
                        $classes = $conn->query("SELECT s.*,concat(c.level,'-',c.section) as class,concat(firstname,' ',middlename,' ',lastname) as name FROM students s inner join classes c on c.id = s.class_id order by concat(firstname,' ',middlename,' ',lastname) asc ");
                        while($row = $classes->fetch_array()):
                  ?>
                        <option value="<?php echo $row['id'] ?>" data-class_id='<?php echo $row['class_id'] ?>'  data-class='<?php echo $row['class'] ?>' <?php echo isset($student_id) && $student_id == $row['id'] ? "selected" : '' ?>><?php echo $row['student_code'].' | '.ucwords($row['name']) ?></option>
                  <?php endwhile; ?>
                </select>
                <small id="class"><?php echo isset($class) ? "Current Class: ".$class : "" ?></small>
                <input type="hidden" name="class_id" value="<?php echo isset($class_id) ? $class_id: '' ?>">
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div class="d-flex justify-content-center align-items-center">
            	<div class="form-group col-sm-4">
	                <label for="" class="control-label">Materia</label>
	                <select name="" id="subject_id" class="form-control select2 select2-sm input-sm">
	                  <option></option> 
	                  <?php 
	                        $classes = $conn->query("SELECT * FROM subjects order by subject asc ");
	                        while($row = $classes->fetch_array()):
	                  ?>
	                        <option value="<?php echo $row['id'] ?>" data-json='<?php echo json_encode($row) ?>'><?php echo $row['subject_code'].' | '.ucwords($row['subject']) ?></option>
	                  <?php endwhile; ?>
	                </select>
	            </div>
	            <div class="form-group col-sm-3">
	                <label for="" class="control-label">Nota</label>
	                <input type="text" class="form-control form-control-sm text-right number" id="mark" maxlength="6">
	            </div>
	            <button class="btn btn-sm btn-primary bg-gradient-primary" type="button" id="add_mark">Agregar</button>
            </div>
        </div>
    	<hr>
    	<div class="col-md-8 offset-md-2">
            <table class="table table-bordered" id="mark-list">
            	<thead>
            		<tr>
            			<th>Código Materia</th>
            			<th>Materia</th>
            			<th>Nota</th>
            			<th></th>
            		</tr>
            	</thead>
            	<tbody>
            		<?php if(isset($id)): ?>
            		<?php 
            			$items=$conn->query("SELECT r.*,s.subject_code,s.subject,s.id as sid FROM result_items r inner join subjects s on s.id = r.subject_id where result_id = $id order by s.subject_code asc");
            			while($row = $items->fetch_assoc()):
            		?>
            		<tr data-id="<?php echo $row['sid'] ?>">
            			<td><input type="hidden" name="subject_id[]" value="<?php echo $row['subject_id'] ?>"><?php echo $row['subject_code'] ?></td>
            			<td><?php echo ucwords($row['subject']) ?></td>
            			<td><input type="hidden" name="mark[]" value="<?php echo $row['mark'] ?>"><?php echo $row['mark'] ?></td>
            			<td class="text-center"><button class="btn btn-sm btn-danger" type="button" onclick="$(this).closest('tr').remove() && calc_ave()"><i class="fa fa-times"></i></button></td>
            		</tr>
            		<?php endwhile; ?>
            		<script>
            			$(document).ready(function(){
            				calc_ave()
            			})
            		</script>
            		<?php endif; ?>

            	</tbody>
            	<tfoot>
            		<tr>
            			<th colspan="2">Promedio</th>
            			<th id="average" class="text-center"></th>
            			<th></th>
            		</tr>
            	</tfoot>
            </table>
            <input type="hidden" name="marks_percentage" value="<?php echo isset($marks_percentage) ? $marks_percentage : '' ?>">
          </div>
        </div>
      </form>
  	</div>
  	<div class="card-footer border-top border-info">
  		<div class="d-flex w-100 justify-content-center align-items-center">
  			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-result">Guardar</button>
  			<a class="btn btn-flat bg-gradient-secondary mx-2" href="./index.php?page=results">Cancelar</a>
  		</div>
  	</div>
	</div>
</div>
<script>
	$('#student_id').change(function(){
		var class_id = $('#student_id option[value="'+$(this).val()+'"]').attr('data-class_id');
		var _class = $('#student_id option[value="'+$(this).val()+'"]').attr('data-class');
		$('[name="class_id"]').val(class_id)
		$('#class').text("Año actual: "+_class);
	})
	$('#add_mark').click(function(){
		var subject_id = $('#subject_id').val()
		var mark = $('#mark').val()
		if(subject_id == '' && mark == ''){
			alert_toast("Please select subject & enter a mark before adding to list.","error");
			return false;
		}
		var sData = $('#subject_id option[value="'+subject_id+'"]').attr('data-json')
			sData = JSON.parse(sData)
		if($('#mark-list tr[data-id="'+subject_id+'"]').length > 0){
			alert_toast("Materia existe actualmente","error");
			return false;
		}
		var tr = $('<tr data-id="'+subject_id+'"></tr>')
		tr.append('<td><input type="hidden" name="subject_id[]" value="'+subject_id+'">'+sData.subject_code+'</td>')
		tr.append('<td>'+sData.subject+'</td>')
		tr.append('<td class="text-center"><input type="hidden" name="mark[]" value="'+mark+'">'+mark+'</td>')
		tr.append('<td class="text-center"><button class="btn btn-sm btn-danger" type="button" onclick="$(this).closest(\'tr\').remove() && calc_ave()"><i class="fa fa-times"></i></button></td>')
		$('#mark-list tbody').append(tr)
		$('#subject_id').val('').trigger('change')
		$('#mark').val('')
		calc_ave()

	})
	function calc_ave(){
		var total = 0;
		var i = 0;
		$('#mark-list [name="mark[]"]').each(function(){
			i++;
			total = total + parseFloat($(this).val())
		})
		$('#average').text(parseFloat(total/i).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2}))
		$('[name="marks_percentage"]').val(parseFloat(total/i).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2}))
	}
	$('#manage-result').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_result',
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
              location.href = 'index.php?page=results'
					},2000)
				}else if(resp == 2){
          $('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Código de estudiante existe actualmente</div>')
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