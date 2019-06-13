
<?php include('includes/session.php') ?>

<section id="roomsList">
	<div class="container roomHeader">
		<div class="row">
			<div class="col-md-12">
				<h2>Доступные номера</h2>
			</div>
			
		</div>
		<?php

// Юзер попадает на страницу только после того, как выбрал кол-во мест, тип номера и даты		

		if (isset($_POST['find'])) {

// Если юзер не зашел в аккаунт, говорим ему авторизоваться и запрещаем что-то арендовать

			if (!$_SESSION['logged_user']) {
				echo "Сперва необходимо авторизоваться
				<a href = 'login.php'>Войти</a>";
				die();
			}
// Если хоть одна из дат пустая, говорим выбрать нормально

			if ($_POST['income'] == '' || $_POST['outcome'] == '') {
				echo "Введите корректную дату
				<a href = 'index.php'>Назад</a>";
				die();
			}

/* Переводим даты в UNIX формат и сравниваем. 
Если разница между ними меньше одного дня, запрещаем что-то арендовать */

			$dateStart = strtotime($_POST['income']);
			$dateEnd = strtotime($_POST['outcome']);

			if ($dateEnd <= $dateStart) {
				echo "Номер можно снять минимум на один день
				<a href = 'rooms.php'>Назад</a>";
				die();
			}
// Если всё нормально, начинаем искать подходящие номера, свободные в эти даты

			echo "с {$_POST['income']} по {$_POST['outcome']}";

/*
Сначала ищем в таблице, куда заносятся все даты аренды с привязкой к номерам. 
Ищем те даты, где дата ВЫЕЗДА меньше ВВЕДЕННОЙ сейчас даты ВЪЕЗДА,
которые указаны для номеров с подходящими параметрами.

Считаем количество полученных значений.
*/ 
			$sql = mysqli_query($connection, 
				"SELECT DISTINCT room.id as 'id', room.number as 'number', room.roominess as 'roominess', room.price as 'price', type.name as 'type'
				 FROM room_book
				 LEFT JOIN room 
				 on room_book.id_room = room.id
				 LEFT JOIN type on room.id_type = type.id
				 WHERE room_book.end < '{$_POST['income']}' and room.roominess = '{$_POST['roominess']}' and room.id_type = '{$_POST['typez']}'");

			$row_cont = $sql->num_rows;


			if ($row_cont < 1) {
/*
Если в таблице с датами не нашлось подходящих свободных номеров,
начинаем искать в таблице, где содержится основная информация о номерах.
Ищем только те, которых НЕТ в таблице с датами.

Считаем количество полученных значений.
*/
					$sql = mysqli_query($connection, 
					"SELECT DISTINCT room.id as 'id', room.number as 'number', room.roominess as 'roominess', room.price as 'price', type.name as 'type'
					 FROM room
					 LEFT JOIN room_book on room.id = room_book.id_room
					 LEFT JOIN type on room.id_type = type.id
					 WHERE room_book.id_room IS NULL  and room.roominess = '{$_POST['roominess']}' and room.id_type = '{$_POST['typez']}'");

		    	$row_cnt = $sql->num_rows;

		    	if ($row_cnt < 1) {

// Ничего не нашлось

		    		echo ", удовлетворяющие вашим требованиям, отсутствуют";
		    	} else {

// Если что-то нашлось, выводим это

				    		$sql = mysqli_query($connection, 
						"SELECT DISTINCT room.id as 'id', room.number as 'number', room.roominess as 'roominess', room.price as 'price', type.name as 'type'
						 FROM room
						 LEFT JOIN room_book on room.id = room_book.id_room
						 LEFT JOIN type on room.id_type = type.id
						 WHERE room_book.id_room IS NULL  and room.roominess = '{$_POST['roominess']}' and room.id_type = '{$_POST['typez']}'");
		    	}

			} 
				while ($result = mysqli_fetch_array($sql)) {
				echo "<form action='booking.php' method='post'>
					<div class='row roomList'>
					<input name='id' value='{$result['id']}' type='hidden'>
						<div class='col-md-1'>
							<h5>Номер</h5>
							<p>{$result['number']}</p>
							<input name='number' value='{$result['number']}' type='hidden'>
						</div>
						<div class='col-md-1'>
							<h5>Места</h5>
							<p>{$result['roominess']}</p>
							<input name='roominess' value='{$result['roominess']}' type='hidden'>
						</div>
						<div class='col-md-2'>
							<h5>Стоимость</h5>
							<p>{$result['price']}</p>
							<input name='price' value='{$result['price']}' type='hidden'>
						</div>
						<div class='col-md-2'>
							<h5>Тип</h5>
							<p>{$result['type']}</p>
							<input name='type' value='{$result['type']}' type='hidden'>
						</div>
							<div class='col-md-2'>
							
							<input type='hidden' name='outcome' value='{$_POST['outcome']}'>
						</div>							
							<div class='col-md-2'>
							<h6><input type='hidden' name='income' value='{$_POST['income']}'> </h6>
							<button name='rent' class='btn btn-success'>Забронировать</button>
						</div>
					</div>
					</form><hr>";
						}
			}	
			
		

		?>
	</div>
</section>

<?php include('includes/footer.php') ?>