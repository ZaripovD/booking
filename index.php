<!DOCTYPE html>
<?php include('includes/session.php'); ?>

<div class="container text-center">
	<h1>Гостиница "Friendly Hotel"</h1>	
</div>

<section id="main">
	<div class="container">
		<nav class="navbar navbar-expand-lg navbar-light bg-light" id="searchRoom">
		<h5>Подобрать номер</h5>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSEARCH" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarSEARCH">
		    <ul class="navbar-nav mr-auto"></ul>

		    <form class="form-inline" action="rooms.php" method="post">
		    		Мест: <select name="roominess">
		    		<option>1              </option>
		    		<option>2              </option>
		    	</select>
		    		Тип: <select name="typez">
		    		 <?php 
		    		 
		    // выводим типы номеров в выпадающем списке через цикл
		    		 $type = mysqli_query($connection, "SELECT * FROM type");
		    		if($type)          
              {
                $typerows = mysqli_num_rows($type); // количество полученных строк     

               for ($i = 0 ; $i < $typerows ; ++$i)
                {
                  $typerow = mysqli_fetch_row($type);
                  echo " <option>$typerow[0] $typerow[1] </option>";
                }
              } ?>
		    	</select>

		      Въезд: <input class="form-control mr-sm-2" type="date" name="income">
		      Выезд: <input class="form-control " type="date" name="outcome">
		      <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="find">
		      	Найти
		      </button>
		    </form>

		  </div>
		</nav>
		<br>
		<div class="row about">
			<div class="col-md-2">
				<img src="img/main.jpg" alt="Главное фото" >
			</div>
			<div class="col-md-8 offset-md-2">
				<h3 class="text-center">Комфортный отдых</h3>
				<span>Пытаясь найти временное жилье, люди часто прибегают к услугам хостелов и общежитий. Лишают себя удобств и переплачивают за это. <br>
				Наша гостиница предлагает вам большое количество разнообразных номеров, стоимость и удобства которых устроят любого. А близкое расположение к центру позволит не тратить свободное время на транспорт, добираясь до главных торговых центров и зданий культуры. </span>
			</div>
		</div>

	</div>
</section>

<section id="services">
	<div class="container">
		<div class="row">
			
		</div>
	</div>
</section>


<div class="container text-center">
	<h1>Виды номеров</h1>	
</div>

<section id="info">		
	<div class="container infos">
		<div class="row">
			<div class="col-md-4">
				<h2>Стандарт</h2>
				<img src="img/types/standart.jpg" alt="Стандарт" class="img-fluid rounded-circle">
			</div>
			<div class="col-md-4">
				<h2>Полулюкс</h2>
				<img src="img/types/halfluxe.jpg" alt="Полулюкс" class="img-fluid rounded-circle">
			</div>
			<div class="col-md-4">
				<h2>Люкс</h2>
				<img src="img/types/luxe.jpg" alt="Люкс" class="img-fluid rounded-circle">
			</div>
		</div>
	</div>
</section>

<?php include('includes/footer.php'); ?>