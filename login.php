<?php include('includes/header.php');   

require 'php/db.php';

  $data = $_POST;
  if ( isset($data['login']) )
  {
    $user = R::findOne('user', 'phone = ?', array($data['phone']));
    if ( $user )
    {
      //логин существует
      if ( md5($data['password'], $user->password) )
      {
        //если пароль совпадает, то нужно авторизовать пользователя
        $_SESSION['logged_user'] = $user;
          header('location: persarea.php');
      }else
      {
        $errors[] = 'Неверно введен пароль!';
      }

    }else
    {
      $errors[] = 'Пользователь с таким номером не найден!';
    }
    
    if ( ! empty($errors) )
    {
      //выводим ошибки авторизации
      echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div><hr>';
    }

  }

?>

<section id="register">
    <div class="container">
         <form class="form-horizontal" method="post" action="login.php">

            <div class="col-md-2">
                    <h2>Авторизация</h2>
            </div>

            <div class="form-group">
                <label name="phone" class="col-sm-3 control-label">Номер телефона</label>
                <div class="col-sm-9">
                    <input type="phone" name="phone" placeholder="Номер телефона" class="form-control" autofocus>
                </div>
            </div>

             <div class="form-group">
                 <label name="password" class="col-sm-3 control-label">Пароль</label>
                 <div class="col-sm-9">
                     <input type="password" id="password" placeholder="Пароль" class="form-control">
                 </div>
             </div>

             <button type="submit" class="btn btn-primary btn-block" name="login">Войти</button>
             <a href="registration.php" class="btn btn-secondary btn-block">Создать аккаунтт</a>
             
        </form> 
    </div>  
</section>

<?php include('includes/footer.php'); ?>