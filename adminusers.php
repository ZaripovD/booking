<?php include('includes/session.php'); ?>

<div class="container text-center" id="adminNav">
	<nav>
		<ul class="list-inline">
			<form action="adminusers.php" method="post">			
			<li class="list-inline-item">				
					<input type="text" name="family" placeholder="Фамилия пользователя">
					<button class="btn btn-success" name="search">
						Найти
					</button>
					<a href="adminusers.php" class="btn btn-secondary">Сбросить</a>
			</li>
			</form>
		</ul>
	</nav>
</div>


<section id="admin">
	<div class="container">
		<?php 

		if (isset($_GET['del_id'])) { //проверяем, есть ли переменная    
  
		  $delu = mysqli_query($connection, "DELETE FROM `user` WHERE `id` = {$_GET['del_id']}");
		     
		    if ($delu) {
		      echo "Пользователь удален";
		    } else {
		      echo '<p>Произошла ошибка: ' . mysqli_error($connection) . '</p>';

		  }
		} 

		if (isset($_POST['search'])) {
			$sql = mysqli_query($connection, "
				SELECT id, name, family, father, phone 
				FROM user
				WHERE family = '{$_POST['family']}' ");
		} else {
			$sql = mysqli_query($connection, "
				SELECT id, name, family, father, phone 
				FROM user
				ORDER BY family DESC");
		}

		while ($result = mysqli_fetch_array($sql)) {
			echo "
				<div class='row roomList'>
					<div class='col-md-2'>
						<h5>Фамилия</h5>
						<p>{$result['family']}</p>
					</div>
					<div class='col-md-2'>
						<h5>Имя</h5>
						<p>{$result['name']}</p>
					</div>
					<div class='col-md-2'>
						<h5>Отчество</h5>
						<p>{$result['father']}</p>
					</div>
					<div class='col-md-2'>
						<h5>Телефон</h5>
						<p>{$result['phone']}</p>
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