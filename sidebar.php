  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="dropdown">
   	<a href="javascript:void(0)" class="brand-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <?php if(empty($_SESSION['login_avatar'])): ?>
        <span class="brand-image img-circle elevation-3 d-flex justify-content-center align-items-center bg-primary text-white font-weight-500" style="width: 38px;height:50px"><?php echo strtoupper(substr($_SESSION['login_firstname'], 0,1).substr($_SESSION['login_lastname'], 0,1)) ?></span>
        <?php else: ?>
          <span class="image">
            <img src="../assets/uploads/<?php echo $_SESSION['login_avatar'] ?>" style="width: 38px;height:38px" class="img-circle elevation-2" alt="User Image">
          </span>
        <?php endif; ?>
        <span class="brand-text font-weight-light"><?php echo ucwords($_SESSION['login_firstname'].' '.$_SESSION['login_lastname']) ?></span>

      </a>
      <div class="dropdown-menu" style="">
        <a class="dropdown-item manage_account" href="javascript:void(0)" data-id="<?php echo $_SESSION['login_id'] ?>">Gestionar Cuenta</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="ajax.php?action=logout">Cerrar Sesión</a>
      </div>
    </div>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item dropdown">
            <a href="./" class="nav-link nav-home">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>   
          <li class="nav-item dropdown">
            <a href="./index.php?page=classes" class="nav-link nav-classes">
              <i class="nav-icon fas fa-th-list"></i>
              <p>
                Año Escolar - Semestres
              </p>
            </a>
          </li>    
          <li class="nav-item dropdown">
            <a href="./index.php?page=subjects" class="nav-link nav-subjects">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Materias
              </p>
            </a>
          </li>   
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_student">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Estudiantes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=new_student" class="nav-link nav-new_student tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Agregar Nuevo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=student_list" class="nav-link nav-student_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Lista Estudiantes</p>
                </a>
              </li>
            </ul>
          </li>
           <li class="nav-item dropdown">
            <a href="./index.php?page=results" class="nav-link nav-results nav-new_result nav-edit_result">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Resultados
              </p>
            </a>
          </li>  
        </ul>
      </nav>
    </div>
  </aside>
  <script>
  	$(document).ready(function(){
  		var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
  		if($('.nav-link.nav-'+page).length > 0){
  			$('.nav-link.nav-'+page).addClass('active')
          console.log($('.nav-link.nav-'+page).hasClass('tree-item'))
  			if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
          $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
  				$('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
  			}
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

  		}
      $('.manage_account').click(function(){
        uni_modal('Gestionar Cuenta','manage_user.php?id='+$(this).attr('data-id'))
      })
  	})
  </script>