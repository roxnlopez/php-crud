<?php

require('../models/car.php');

	Class CarController {
		public function indexPage() {
			$cars = Car::find();
			require('../views/cars/index.php');
		}
	}

	$new_car_controller = new CarController();
	
	if($_GET['action'] === 'index') {
		$new_car_controller->indexPage();
	}


?>