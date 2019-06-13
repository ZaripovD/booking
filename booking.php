<?php include('includes/session.php')?>

<section id="booking">
	<div class="container">
		<?php 

// Юзер попадает на страницу только после того, как выбрал одну из комнат

		if (isset($_POST['deal'])) {
			// этот скрипт срабатывает в последнюю очередь

/*
Когда пользователь нажимает на кнопку ОФОРМИТЬ,
сперва добавляем даты и внешний ИД номера в таблицу со всеми датами
*/ 
			$add1 = mysqli_query($connection, "
				INSERT INTO room_book
				(`id_room`, `start`, `end`)
				VALUES
				('{$_POST['id']}', '{$_POST['income']}', '{$_POST['outcome']}')");

// Потом узнаем ИД только что добавленной строки

			$add2 = mysqli_query($connection, "
				SELECT id 
				FROM room_book
				ORDER BY id DESC
				LIMIT 1");

// И в конце вносим полученный ИД, ИД юзера и итоговую сумму в главную таблицу с операциями
			while ($result = mysqli_fetch_array($add2)) {

			$add3 = mysqli_query($connection, "
				INSERT INTO booking
				(`id_room_book`, `id_user`, `summary`)
				VALUES 
				('{$result['id']}', '{$_SESSION['logged_user']->id}', '{$_POST['sum']}')");
			}

			
			if (!$add3 || !$add2 || !$add1) {
				echo mysqli_error($connection);
			}else {
				echo "Ваша заявка принята и рассматривается";
			}
		}

		if (isset($_POST['rent'])) {

// При открытии страницы сначала срабатывает этот скрипт



// Заносим обе даты в переменные, переводя их в UNIX формат.
			$dateStart = strtotime($_POST['income']);
			$dateEnd = strtotime($_POST['outcome']);

//Вычисляем общее количество дней = находим разницу между датами и преобразуем UNIX значение в сутки.
			$days = ($dateEnd - $dateStart) / (60 * 60 *24);
			$price = $_POST['price'];

// Вычисляем сумму = стоимость за сутки умножаем на общее кол-во дней
			$sum = $price * $days;

// Выводим все значения на форму и кнопку ОФОРМИТЬ
			echo "<form action='booking.php' method='post'>
					<div class='row roomList'>
					
						<div class='col-md-1'>
							<h5>Номер</h5>
							<p>{$_POST['number']}</p>
							<input name='id' value='{$_POST['id']}' type='hidden'>
						</div>
						<div class='col-md-1'>
							<h5>Места</h5>
							<p>{$_POST['roominess']}</p>
						</div>
						<div class='col-md-2'>
							<h5>Стоимость</h5>
							<p>{$_POST['price']}</p>
						</div>
						<div class='col-md-2'>
							<h5>Тип</h5>
							<p>{$_POST['type']}</p>
						</div>
						<div class='col-md-2'>
							<h5>Въезд</h5>
							<p>{$_POST['income']}</p>
							<input  name='income' value='{$_POST['income']}' type='hidden'>
						</div>
						<div class='col-md-2'>
							<h5>Выезд</h5>
							<p>{$_POST['outcome']}</p>
							<input name='outcome' value='{$_POST['outcome']}' type='hidden'>
						</div>
						<div class='col-md-2'>
							<h5>Сумма</h5>
							<p>{$sum}</p>
							<input name='sum' value='{$sum}' type='hidden'>
						</div>
						<div class='col-md-2'>
							<h6> </h6>
							<button name='deal' class='btn btn-success'>Оформить</button>
						</div>
					</div>
					</form>";

		

	}
		 ?>
	</div>
</section>

<?php include('includes/footer.php') ?>