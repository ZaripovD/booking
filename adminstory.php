<?php include('includes/session.php')?>

<div class="container text-center">
<form action="adminstory.php" method="post">
  <nav id="adminNav">
    <ul class="list-inline">
      <li class="list-inline-item">
        <button class="btn btn-primary" name="accepted">Одобренные</button>
        <button class="btn btn-secondary" name="nonAccepted">На рассмотрении</button>
      </li>
    </ul>
    <ul class="list-inline">
      <li class="list-inline-item">
        Начиная с: <input type="date" name="starting">
        <button class="btn btn-secondary" name="search">Показать</button>
      </li>
    </ul>
  </nav>
</form>


<section id="adminstory">
	<div class="container">
		<?php
/* 
Когда назначают горничную, важно, чтобы не указали первый вариант из списка. Запрещаем это делать. Если выбран кто-то другой, обновляем данные операции
*/
		if (isset($_POST['accept'])) {
			if ($_POST['worker'] == 1) {
				echo "Назначьте горничную";
			}else {
				$book = mysqli_query($connection, "
					UPDATE booking
					SET id_worker = '{$_POST['worker']}', id_status = '2'
					WHERE id = '{$_POST['id']}' ");
				if (!$book) {
					echo mysqli_error($connection);
				}else {
					echo "Горничная назначена!";
				}
				
			}
		}

/*
 Если нажали на кнопку ГОСТЬ СЪЕЗЖАЕТ, сверяем дату выезда с нынешней. Если выезд был раньше нынешней даты, ничего не делаем. Если выезд будет позже, меняем дату на нынешнею
*/
    if (isset($_POST['delete'])) {
      if ($_POST['end'] <= date('Y-m-d')) {
        echo "Гость уже уехал";
      }else {
        $now = date('Y-m-d');
        $out = mysqli_query($connection, "
          UPDATE room_book
          SET `end` = '$now'
          WHERE id = '{$_POST['id']}' ");
        echo "Комната освобождена";
      }
    }

//Нажатие на кнопку Одобренные формирует запрос с условием, чтобы ИД статуса НЕ был равен одному

if (isset($_POST['accepted'])) {
    $sql = mysqli_query($connection, "SELECT booking.id as 'ID', room.number as 'number', summary, room_book.start as 'start', room_book.end as 'end', status.id as 'idStat', status.name as 'status', workers.name as 'workerN', workers.family as 'workerF'
 FROM booking
 LEFT JOIN workers on booking.id_worker = workers.id
 LEFT JOIN room_book on room_book.id = booking.id_room_book 
 LEFT JOIN status on booking.id_status = status.id
 LEFT JOIN user on booking.id_user = user.id
 LEFT JOIN room on room_book.id_room = room.id
 WHERE booking.id_status <> 1
 ORDER BY room_book.start DESC");
}else

//Нажатие на кнопку На рассмотрении формирует запрос с условием, чтобы ИД статуса был равен одному

if (isset($_POST['nonAccepted'])) {
     $sql = mysqli_query($connection, "SELECT booking.id as 'ID', room.number as 'number', summary, room_book.start as 'start', room_book.end as 'end', status.id as 'idStat', status.name as 'status', workers.name as 'workerN', workers.family as 'workerF'
 FROM booking
 LEFT JOIN workers on booking.id_worker = workers.id
 LEFT JOIN room_book on room_book.id = booking.id_room_book 
 LEFT JOIN status on booking.id_status = status.id
 LEFT JOIN user on booking.id_user = user.id
 LEFT JOIN room on room_book.id_room = room.id
 WHERE booking.id_status = 1
 ORDER BY room_book.start DESC");
}else

/*
Нажатие на кнопку ПОКАЗАТЬ формирует запрос с условием, в котором дата начала операции была больше или равна введенному значению
*/

if (isset($_POST['search'])) {
	$sql = mysqli_query($connection, "SELECT booking.id as 'ID', room.number as 'number', summary, room_book.start as 'start', room_book.end as 'end', status.id as 'idStat', status.name as 'status', workers.name as 'workerN', workers.family as 'workerF'
 FROM booking
 LEFT JOIN workers on booking.id_worker = workers.id
 LEFT JOIN room_book on room_book.id = booking.id_room_book 
 LEFT JOIN status on booking.id_status = status.id
 LEFT JOIN user on booking.id_user = user.id
 LEFT JOIN room on room_book.id_room = room.id
 WHERE room_book.start >= '{$_POST['starting']}'
 ORDER BY room_book.start DESC");
} else {
  
/*
При простой загрузке страницы выводим все значения подряд.
Берем из главной таблицы BOOKING, подключаем к ней все возможные внешние ключи
через LEFT JOIN
*/

	$sql = mysqli_query($connection, "SELECT booking.id as 'ID', room.number as 'number', summary, room_book.start as 'start', room_book.end as 'end', status.id as 'idStat', status.name as 'status', workers.name as 'workerN', workers.family as 'workerF'
 FROM booking
 LEFT JOIN workers on booking.id_worker = workers.id
 LEFT JOIN room_book on room_book.id = booking.id_room_book
 LEFT JOIN status on booking.id_status = status.id
 LEFT JOIN user on booking.id_user = user.id
 LEFT JOIN room on room_book.id_room = room.id
 ORDER BY room_book.start DESC");
}

while ($result = mysqli_fetch_array($sql)) {

  echo "<form action='adminstory.php' method='post'>
  <div class='row story'>
      <div class='col-md-2'>
      <input type='hidden' name='id' value='{$result['ID']}'>
        <h4>Номер комнаты</h4>
        <p>{$result['number']}</p>
      </div>
      <div class='col-md-2'>
        <h4>Дата въезда</h4>
        <p>{$result['start']}</p>
      </div>
      <div class='col-md-2'>
      <input type='hidden' name='end' value='{$result['end']}'>
        <h4>Дата выезда</h4>
        <p>{$result['end']}</p>
      </div>
      <div class='col-md-1'>
        <h4>Сумма</h4>
        <p>{$result['summary']}</p>
      </div>
      <div class='col-md-2'>
        <h4>Статус</h4>
        <p>{$result['status']}</p>
      </div>
      <div class='col-md-3'>
        <h4>Обслуживает</h4>";
/*
Прямо в цикле вывода значений находится условие, которое
проверяет статус операции. 
Если статус = 1 (На рассмотрении), то он выводит выпадающий список
с именами сотрудников для назначения
и кнопку НАЗНАЧИТЬ.

Если ИД статуса = 2, выводит просто имя назначенной горницы и 
кнопку гость съезжает
*/
        if ($result['idStat'] == 1) {
          echo "<select name='worker'>";
           $worker = mysqli_query($connection, "SELECT * FROM workers");
            if($worker)          
              {
                $workerrows = mysqli_num_rows($worker); // количество полученных строк     

               for ($i = 0 ; $i < $workerrows ; ++$i)
                {
                  $workerrow = mysqli_fetch_row($worker);
                  echo " <option>$workerrow[0] $workerrow[1] $workerrow[2] </option>";
                }
              }
          echo "</select></div>
 </div>
 <div class='row'>  
  <div class='col-md-2 offset-md-10'>
    <button class='btn btn-success' name='accept'>Назначить</button>
  </div>
 </div>
</form>";
  }else {
    echo "
    <p>{$result['workerF']}</p>
  <p>{$result['workerN']}</p>
  </div>
  </div>
   <div class='row'>  
  <div class='col-md-3 offset-md-8'>
    <button class='btn btn-danger' name='delete'>Гость съезжает</button>
  </div>
 </div>
</form>";
}
  echo"    
      <hr>";
}

 ?>
	</div>
  
</section>



<?php include('includes/footer.php') ?>