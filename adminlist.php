<?php include('includes/session.php');
include('includes/adminlistSIDE.php'); ?>


<section id="admin">
	<div class="container">
		<?php 
			
//В каждой строке выводится кнопка, которая принимает значение ИД и дает запрос на удаление по ИД
		if (isset($_GET['del_id'])) { //проверяем, есть ли переменная    
  
		  $delu = mysqli_query($connection, "DELETE FROM `room` WHERE `id` = {$_GET['del_id']}");
		     
		    if ($delu) {
		      echo "Номер удален";
		    } else {
		      echo '<p>Произошла ошибка: ' . mysqli_error($connection) . '</p>';

		  }
		} 

	//выводится список номеров, сортировка по номеру по возрастанию.

		$sql = mysqli_query($connection, 
				"SELECT room.id as 'id', room.number as 'number', room.roominess as 'roominess', room.price as 'price', type.name as 'type'
				 FROM room
				 LEFT JOIN type on room.id_type = type.id
				 ORDER BY room.number ASC");

			while ($result = mysqli_fetch_array($sql)) {
				echo "
					<div class='row roomList'>
						<div class='col-md-2'>
							<h5>Номер</h5>
							<p>{$result['number']}</p>
						</div>
						<div class='col-md-2'>
							<h5>Места</h5>
							<p>{$result['roominess']}</p>
						</div>
						<div class='col-md-2'>
							<h5>Стоимость</h5>
							<p>{$result['price']}</p>
						</div>
						<div class='col-md-2'>
							<h5>Тип</h5>
							<p>{$result['type']}</p>
						</div>
						<div class='col-md-2'>
							<h5></h5>
							<a href='?del_id={$result['id']}' class='btn btn-danger'>Удалить</a>
						</div>
					</div><hr>
				";
			}

		?>
	</div>
</section>



<?php include('includes/footer.php') ?> 
