<?php include('includes/session.php');
include('includes/adminlistSIDE.php'); ?>




<section id="admin">
	<div class="container">
		<?php 

			$sql = mysqli_query($connection, 
				"SELECT room.id as 'id', room.number as 'number', room.roominess as 'roominess', room.price as 'price', type.name as 'type'
				 FROM room
				 LEFT JOIN type on room.id_type = type.id
				 ORDER BY room.number ASC");

			while ($result = mysqli_fetch_array($sql)) {
				echo "<form action='adminlistEDIT.php' method='post'>
					<div class='row roomList'>
						<div class='col-md-2'>
							<h5>Номер</h5>
							<input type='hidden' value='{$result['id']}' name='id'>
							<p>{$result['number']}</p>
						</div>
						<div class='col-md-2'>
							<h5>Места</h5>
							<p>{$result['roominess']}</p>
							<input type='hidden' value='{$result['roominess']}' name='places'>
						</div>
						<div class='col-md-2'>
							<h5>Стоимость</h5>
							<input name='priceChange' value='{$result['price']}'>
						</div>
						<div class='col-md-2'>
							<h5>Тип</h5>
							<p>{$result['type']}</p>
							<input type='hidden' value='{$result['type']}' name='typez'>
						</div>
						<div class='col-md-2'>
							<h5></h5>
							<button class='btn btn-success' name='changing' >Изменить</button>
						</div>
					</div></form><hr>
				";
			}
	//тот же обработчик событий, что на странице добавления
		
			if (isset($_POST['changing'])) {
				$errors = array();

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
			if (empty($errors)){
				$ch = mysqli_query($connection, "
					UPDATE room SET price = '{$_POST['priceChange']}' WHERE id = '{$_POST['id']}' ");
			} else {
				echo '<div class="row text-center" id="errors">' .array_shift($errors). '</div>';
			}
				
				if (!$ch) {
					echo 'zhopa'. mysqli_error($connection);
				}else {
					echo "Информация обновлена";
				}

				
			}	 

		?>
	</div>
</section>



<?php include('includes/footer.php') ?> 
