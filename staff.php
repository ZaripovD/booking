<?php include('includes/session.php');?>

<section id="staffList">
<div class="container">
	<h2 class="text-center">Персонал гостиницы</h2>
	<?php 


// первый ИД в таблице имеет ФИО "НЕ НАЗНАЧЕНО", поэтому выводим всех, кроме него

			$sql = mysqli_query($connection, "
				SELECT id, name, family, father, phone 
				FROM workers
				WHERE id <> 1
				ORDER BY family DESC");

		while ($result = mysqli_fetch_array($sql)) {
			echo "
				<div class='row roomList'>
					<div class='col-md-3 offset-md-1'>
						<h5>Фамилия</h5>
						<p>{$result['family']}</p>
					</div>
					<div class='col-md-3'>
						<h5>Имя</h5>
						<p>{$result['name']}</p>
					</div>
					<div class='col-md-3'>
						<h5>Отчество</h5>
						<p>{$result['father']}</p>
					</div>					
				</div><hr>
				";
		}

		 ?>
	</div>

	 
</div>
</section>

<?php include('includes/footer.php') ?> 
