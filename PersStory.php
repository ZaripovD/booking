<!DOCTYPE html>
<title>Личный кабинет</title>

<?php include("includes/session.php");?>

     

     <section id="description">
      <div class="container text-center">
        <?php include("includes/sidebar.php"); ?>
            <h1>История операций</h1>
            <div class="col-md-1 col-md-offset-11">
      </div>
    <?php

    if (isset($_POST['extend'])) {

// При нажатии на кнопку ПРОДЛИТЬ появляется поле ввода новой даты
// в скрытых полях находятся старые значения

      echo "Выберите новую дату:
    <form method='post' action='persstory.php'>
     <div class='row'>
     <input type='hidden' value='{$_POST['idE']}' name='idE'>
     <input type='hidden' value='{$_POST['oldEnd']}' name='oldEnd'>
     <input type='hidden' value='{$_POST['oldStart']}' name='oldStart'>
     <input type='hidden' value='{$_POST['oldSum']}' name='oldSum'>
    <input type='hidden' value='{$_POST['cost']}' name='cost'>
        <div class='col-md-5 offset-md-7'>
          <input type='date' name='newEnd'>
          <button name='done'>Продлить</button>
        </div>
      </div>
    </form>";
    }

    if (isset($_POST['done'])) {

// Когда юзер нажимает на кнопку ПРОДЛИТЬ в новой строке, проверяем правильность даты
// Сравниваем старую дату выезда с новой. Разница должна быть больше или равна одному
      if ($_POST['newEnd'] <= $_POST['oldEnd']) {
        echo "Продлите хотя бы на один день";
      }else {

//Всё нормально, получаем новые значения
      $dateStart = strtotime($_POST['oldStart']);
      $dateEnd = strtotime($_POST['newEnd']);

// в $days вычисляем новое общее количество дней
      $days = ($dateEnd - $dateStart) / (60 * 60 * 24);
      $oldSum = $_POST['oldSum'];
      $cost = $_POST['cost'];

// в $newSum вычисляем новую общую стоимость за период проживания
      $newSum = $cost * $days;

// в $difference находим разницу между новой суммой и старой. Это доп плата за доп дни аренды
      $difference = $newSum - $oldSum;

/*
Обновляем вторую дату в таблице room_book с датами.
Обновляем сумму в таблице booking с операциями
*/ 
        $update = mysqli_query($connection, "
        UPDATE room_book
        LEFT JOIN booking on booking.id_room_book = room_book.id
        SET room_book.end = '{$_POST['newEnd']}', booking.summary = '$newSum'
        WHERE booking.id = '{$_POST['idE']}'");

      echo "Дата выезда и итоговая сумма обновлены, доплата: ". $difference.' рублей';
      }
      
    }

$sql = mysqli_query($connection, "SELECT booking.id as 'ID', room.number as 'number', summary, room_book.start as 'start', room_book.end as 'end', status.name as 'status', workers.name as 'workerN', workers.family as 'workerF', room.price as 'cost'
 FROM booking
 LEFT JOIN workers on booking.id_worker = workers.id
 LEFT JOIN room_book on room_book.id = booking.id_room_book
 LEFT JOIN status on booking.id_status = status.id
 LEFT JOIN user on booking.id_user = user.id
 LEFT JOIN room on room_book.id_room = room.id
 WHERE booking.id_user = '{$_SESSION['logged_user']->ID}'
 ORDER BY booking.id DESC");
 

echo "<section id='apartment-story'>
  <div class='container admin'>";

while ($result = mysqli_fetch_array($sql)) {

  echo "
  <form method='post' action='persstory.php'>
  <input type='hidden' value='{$result['ID']}' name='idE'>
  <input type='hidden' value='{$result['end']}' name='oldEnd'>
  <input type='hidden' value='{$result['start']}' name='oldStart'>
  <input type='hidden' value='{$result['summary']}' name='oldSum'>
  <input type='hidden' value='{$result['cost']}' name='cost'>
  <div class='row story'>
      <div class='col-md-2'>
        <h4>Номер комнаты</h4>
        <p>{$result['number']}</p>
      </div>
      <div class='col-md-2'>
        <h4>Дата въезда</h4>
        <p>{$result['start']}</p>
      </div>
      <div class='col-md-2'>
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
        <h4>Обслуживает</h4>
        <p>{$result['workerF']}</p>
        <p>{$result['workerN']}</p>
      </div>
 </div>";
 // условие внутри вывода данных
 /*
 Дату выезда в каждой операции сравниваем с текущей датой.
 Если дата выезда позже текущей, выводим кнопку для возможности продлить аренду.
 */ 
 if (date('Y-m-d') < $result['end']) {
   echo "
   
     <div class='row'>     
        <div class='col-md-2 offset-md-7'>
          <button name='extend' class='btn btn-info'>Продлить</button>
        </div>
      </div>
    ";
 }echo " </form><hr>";
}
echo "</div>
</section>";
 ?>
        
    </div>
 
    </section>


 <?php include("includes/footer.php"); ?>