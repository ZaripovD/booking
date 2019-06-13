<?php include('includes/session.php'); 
include('includes/adminstaffSIDE.php');?>

<section id="register">
 <div class="container">
<?php

  $data = $_POST;

  //если кликнули на button
  if ( isset($data['signup']) )
  {
    // проверка формы на пустоту полей
    $errors = array();

    if ( trim($data['family']) == '' || trim($data['name']) == '' || trim($data['father']) == '' )
    {
      $errors[] = 'Введите полное имя сотрудника';
    }

    if (strlen(trim($data['passport'])) != 10) 
    {
      $errors[] = 'Укажите корректные паспортные данные сотрудника';
    }

    if ( trim($data['phone']) == '')
    {
      $errors[] = 'Введите номер телефона сотрудника';
    }

    //проверка на существование одинакового телефона
    if ( R::count('workers', "phone = ?", array($data['phone'])) > 0)
    {
      $errors[] = 'Номер телефона уже зарегистрирован в системе';
    }

    if ( empty($errors) )
    {
      //ошибок нет, теперь регистрируем
      $workers = R::dispense('workers');
      $workers->family = $data['family'];
      $workers->name = $data['name'];
      $workers->father = $data['father'];
      $workers->passport = trim($data['passport']);
      $workers->phone = $data['phone'];
      R::store($workers);
      echo '<div class="row text-center" id="success" style="color:green; padding-top: 50px;;">Сотрудник успешно зарегистрирован</div><hr>';
    }else
    {
      echo '<div class="row text-center" id="errors" style="color:red; padding-top: 50px; ">' .array_shift($errors). '</div><hr>';
    }

  }
 ?>



            <form class="form-horizontal" method="post" action="adminstaffADD.php">
                <div class="col-md-2">
                    <h2>Регистрация сотрудника</h2>
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
                    <label class="col-sm-3 control-label">Номер телефона</label>
                    <div class="col-sm-9">
                        <input type="phone" name="phone" placeholder="Номер телефона" class="form-control" value="<?php echo @$data['phone']; ?>">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="signup">Зарегистрировать</button>
            </form> 
</div>  
</section>



<?php include('includes/footer.php') ?>