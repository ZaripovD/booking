<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Friendly hotel</title>
  
  <link href="css/style.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
</html>

<header>

<!-- Панель навигации, полностью взятая с сайта BOOTSTRAP-->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">

      <a class="navbar-brand" href="index.php">
        <img src="img/logo.png" alt="Логотип">
      </a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">     
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Главная</a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Отель</a>

            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="staff.php">Персонал</a>
            </div>
          </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Профиль</a>

          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="admin.php">Панель администратора</a>

              <div class="dropdown-menu" aria-labelledby="navbarDropdown">                
                <a href="adminlist.php" class="dropdown-item">Номера</a>
                <a href="ADMINusers.php" class="dropdown-item">Пользователи</a>
                <a href="ADMINstaff.php" class="dropdown-item">Сотрудники</a>
                <a href="ADMINstory.php" class="dropdown-item">История операций</a>
              </div>

            <a class="dropdown-item" href="persAREA.php">Личный кабинет</a>
            <a class="dropdown-item" href="php/logout.php">Выйти</a>
          </div>
        </li>

        </ul>
        <div class="col-md-3">
          <?php echo ('Вы администратор '.$_SESSION['logged_user']->family);  ?>
        </div>

      </div>
    </div>
  </nav>

</header>
