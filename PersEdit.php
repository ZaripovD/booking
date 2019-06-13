<!DOCTYPE html>
<title>Личный кабинет</title>

<?php include("includes/session.php");

// Здесь все значения берутся из сессии и вставляются в ТЕКСТОВЫЕ поля

/*
При нажатии на кнопку ИЗМЕНИТЬ меняем все значения поля с информацией о юзере на те, что были введены в поля
*/ 

if (isset($data['change'])) { 
  $sql = mysqli_query($connection, "UPDATE user SET name = '{$data['name']}', family = '{$data['family']}', father = '{$data['father']}', phone = '{$data['phone']}' WHERE phone = '{$_SESSION['logged_user']->phone}'");
  if ($sql){
    echo "<div class='row text-center'><h4>Изменения войдут в силу после перезахода в аккаунт</h4></div>";
  }
  else{
    echo mysqli_error($connection);
  }
}

 ?>

<section id="description">
  <div class="container">
    <?php include("includes/sidebar.php");  ?>
    <form action="persedit.php" method="post">
        <div class="text-center">
            <h1>Личный кабинет</h1>            
          </div>

          <div class="row">
            <div class="col-md-1 offset-md-11">
              <a href="Persarea.php">Вернуться назад</a>
          </div>
          </div>

          <div class="row">
            
          <div class="col-md-3 offset-md-1">
            <h3>Фамилия: </h3>
            <input name="family" type="text" value="<?php echo $_SESSION['logged_user']->family;?>">
            <h3>Номер телефона:</h3>
            <input name="phone" type="text" value="<?php echo $_SESSION['logged_user']->phone; ?>">
            
          </div>

          <div class="col-md-3 offset-md-1">
            
            <h3>Имя:</h3>
            <input name="name" type="text" value="<?php echo $_SESSION['logged_user']->name; ?>">
            
          </div>

          <div class="col-md-3 offset-md-1">            
            <h3>Отчество:</h3>
            <input name="father" type="text" value="<?php echo $_SESSION['logged_user']->father; ?>">         
          </div>

        </div>
        <div class="row">
          <div class="col-md-3 offset-md-1"><br>
            <button type="submit" name="change">Изменить</button>
          </div>
        </div>
    </form>
  </div>
</section>

 <?php include("includes/footer.php"); ?>