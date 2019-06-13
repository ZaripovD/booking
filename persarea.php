<!DOCTYPE html>
<title>Личный кабинет</title>

<?php include("includes/session.php");

// Здесь все значения берутся из активной сессии и подставляются в форму
 ?>

     

<section id="description">
      <div class="container">
        
        <?php include("includes/sidebar.php"); ?>

        <div class="text-center">
            <h1>Личный кабинет</h1>            
          </div>
          <div class="row">
          	<div class="col-md-1 offset-md-11">
          		<a href="PersEdit.php">Обновить информацию</a>
      		</div>
          </div>
          <div class="row">
          <div class="col-md-3 offset-md-1">
            <h3>Фамилия: </h3>
            <p><?php echo $_SESSION['logged_user']->family;?></p>
            <h3>Номер телефона:</h3>
            <p><?php echo $_SESSION['logged_user']->phone; ?></p>
            
            <br>
          </div>

          <div class="col-md-3 offset-md-1">
            
            
            
            <h3>Имя:</h3>
            <p><?php echo $_SESSION['logged_user']->name; ?></p>
            
            <br>
          </div>

          <div class="col-md-3 offset-md-1">            
            <h3>Отчество:</h3>
            <p><?php echo $_SESSION['logged_user']->father; ?></p>         
          </div>
        </div>
      </div>
</section>

<?php include('includes/footer.php') ?>