<?php include('includes/header.php');?>


<section id="register">
 <div class="container">
<?php
require 'php/db.php';

  $data = $_POST;

  //если кликнули на button
  if ( isset($data['signup']) )
  {
    // проверка формы на пустоту полей
    $errors = array();

    if ( trim($data['family']) == '' || trim($data['name']) == '' || trim($data['father']) == '' )
    {
      $errors[] = 'Введите полное имя';
    }

    if (strlen($data['password']) < 7 || strlen($data['password']) > 15) 
    {
      $errors[] = 'Укажите пароль от 7 до 15 символов!'. strlen($data['password']);
    }

    if (strlen(trim($data['passport'])) != 10) 
    {
      $errors[] = 'Укажите корректные паспортные данные!';
    }

    if ( $data['passwordcheck'] != $data['password'] )
    {
      $errors[] = 'Повторный пароль введен не верно!';
    }

    if ( trim($data['phone']) == '')
    {
      $errors[] = 'Введите номер телефона';
    }

    //проверка на существование одинакового телефона
    if ( R::count('user', "phone = ?", array($data['phone'])) > 0)
    {
      $errors[] = 'Номер телефона уже зарегистрирован в системе!';
    }

    if ( empty($errors) )
    {
      //ошибок нет, теперь регистрируем
      $user = R::dispense('user');
      $user->family = $data['family'];
      $user->name = $data['name'];
      $user->father = $data['father'];
      $user->passport = trim($data['passport']);
      $user->Password = MD5($data['password']); //пароль нельзя хранить в открытом виде, мы его шифруем при помощи функции password_hash для php > 5.6
      $user->phone = $data['phone'];
      R::store($user);
      echo '<div class="row text-center" id="success" style="color:green; padding-top: 50px;;">Вы успешно зарегистрированы!</div><hr>';
    }else
    {
      echo '<div class="row text-center" id="errors" style="color:red; padding-top: 50px; ">' .array_shift($errors). '</div><hr>';
    }

  }
 ?>

<!--Все классы элементов принадлежат Bootstrap 4 -->

            <form class="form-horizontal" method="post" action="registration.php">
                <div class="col-md-2">
                    <h2>Регистрация</h2>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label">Имя</label>
                    <div class="col-sm-9">
                        <input type="text" name="name" placeholder="Имя" class="form-control" autofocus value="<?php echo @$data['name']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Фамилия</label>
                    <div class="col-sm-9">
                        <input type="text" name="family" placeholder="Фамилия" class="form-control" autofocus value="<?php echo @$data['family']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Отчество</label>
                    <div class="col-sm-9">
                        <input type="text" name="father" placeholder="Отчество" class="form-control" autofocus value="<?php echo @$data['father']; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Паспорт</label>
                    <div class="col-sm-9">
                        <input type="text" name="passport" placeholder="Паспорт" class="form-control" autofocus value="<?php echo @$data['passport']; ?>">
                        <span>Без пробелов</span>
                    </div>
                </div>

                <div class="form-group">
                    <label  class="col-sm-3 control-label">Пароль</label>
                    <div class="col-sm-9">
                        <input type="password" name="password" placeholder="Пароль" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Подтвердите пароль</label>
                    <div class="col-sm-9">
                        <input type="password" name="passwordcheck" placeholder="Пароль" class="form-control" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Номер телефона</label>
                    <div class="col-sm-9">
                        <input type="phone" name="phone" placeholder="Номер телефона" class="form-control" value="<?php echo @$data['phone']; ?>">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="signup">Зарегистрироваться</button>
                <a href="login.php" class="btn btn-secondary btn-block">Уже есть аккаунт</a>
            </form> 
</div>  
</section>
<?php include('includes/footer.php'); ?>