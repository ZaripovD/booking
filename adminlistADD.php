<?php include('includes/session.php');
include('includes/adminlistSIDE.php'); ?>

<section id="admin">
	<div class="container">

	<?php 
		if (isset($_POST['adding'])) {

//В МАССИВ вводим возможные ошибки ввода, если есть такие

			$errors = array();
			if ($_POST['num'] < 1 || $_POST['num'] > 200 ) {
				$errors[] = 'Введите номер комнаты от 1 до 200';
			}

			if ( R::count('room', "number = ?", array($_POST['num'])) > 0)
    		{
    		  $errors[] = 'Номер уже зарегистрирован в системе';
    		}

    		if ($_POST['places'] < 1 || $_POST['places'] > 2 ) {
				$errors[] = 'Комната может быть только одноместной или двухместной';
			}			

			//Проверяем корректность цен для разных одноместных номеров
			if ($_POST['places'] == 1) {
				switch ($_POST['typez']) {
					case 1:
						if ( $_POST['cost'] < 80 || $_POST['cost'] > 120) {
							$errors[] = 'Одноместный стандартный номер стоит от 80 до 120 рублей';
						}
						break;
					
					case 2:
						if ($_POST['cost'] < 180 || $_POST['cost'] > 250) {
							$errors[] = 'Одноместный полулюкс стоит от 180 до 250 рублей';
						}
						break;
					case 3:
						if ($_POST['cost'] < 330 || $_POST['cost'] > 550) {
							$errors[] = 'Одноместный люкс стоит от 330 до 550 рублей';
						}
						break;
				}
			} else

			//Проверяем корректность цен для разных двухместных номеров
			if ($_POST['places'] == 2) {
				switch ($_POST['typez']) {
					case 1:
						if ( $_POST['cost'] < 180 || $_POST['cost'] > 250) {
							$errors[] = 'Двухместный стандартный номер стоит от 180 до 250 рублей';
						}
						break;
					
					case 2:
						if ($_POST['cost'] < 340 || $_POST['cost'] > 560 ) {
							$errors[] = 'Двухместный полулюкс стоит от 340 до 560 рублей';
						}
						break;
					case 3:
						if ($_POST['cost'] <  670 || $_POST['cost'] >  800) {
							$errors[] = 'Двухместный люкс стоит от 670 до 800 рублей';
						}
						break;
				}
			}
			//ЕСЛИ ОШИБОК нет, загружаем данные в базу

			if (empty($errors)) {

				$sql = mysqli_query($connection, 
				"INSERT INTO room (`number`,`roominess`,`id_type`,`price`)
				 VALUES ('{$_POST['num']}','{$_POST['places']}','{$_POST['typez']}','{$_POST['cost']}')");

			if (!$sql) {
				echo 'error'. mysqli_error($connection);
			}else {
				echo '<div class="row text-center" id="errors">Информация о номере внесена в базу</div><hr>';
			}
			}else {
				echo '<div class="row text-center" id="errors">' .array_shift($errors). '</div><hr>';
			}
		}
	?>
		<form action='adminlistadd.php' method='post' id='addForm'>
		<div class='row roomList'>
			
				<div class='col-md-5 offset-md-4'>
					<h5>Номер</h5>
					<input name='num'>
				</div>
				<div class='col-md-5 offset-md-4'>
					<h5>Места</h5>
					<input name='places'>
				</div>
				<div class='col-md-5 offset-md-4'>
					<h5>Тип</h5>							
					<select name='typez'>
						<?php

//СЕЛЕКТ из таблицы ТИПЫ, вывод в выпадающую строку через цикл

						 $type = mysqli_query($connection, "SELECT * FROM type");
						if($type) {

							$typerows = mysqli_num_rows($type); // количество полученных строк     
								for ($i = 0 ; $i < $typerows ; ++$i) {

								$typerow = mysqli_fetch_row($type);
							echo " <option>$typerow[0] $typerow[1] </option>";
								}
						} ?>						
    				</select>							
				</div>
				<div class='col-md-5 offset-md-4'>
					<h5>Стоимость</h5>
					<input name='cost'>
				</div>
				<div class='col-md-5 offset-md-4'>
					<h5></h5>
					<button class='btn btn-success' name='adding'>Добавить</button>
				</div>	
		</div>
			</form>
		<hr>
		<div class="row d-none d-sm-block">
			<div class="col-md-12">
				<h5>Памятка</h5>
				<p>Максимум два места, номер комнаты от 1 до 200.<br>
				Одноместные номера: стандарт - от 80р до 120р, полулюкс - от 180р до 250р, люкс - от 330р до 550р.<br>
				Двухместные номера: стандарт - от 180р до 250р, полулюкс - от 340р до 560р, люкс - от 670р до 800р.</p>
			</div>
		</div>
	</div>
</section>



<?php include('includes/footer.php') ?> 
