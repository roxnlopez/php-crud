<?php

require('../models/car.php');

Class CarController {

	public function indexPage(){
		$cars = Car::find();
		require('../views/cars/index.php');
	}

	public function newPage(){
		require('../views/cars/new.php');
	}

	public function createAction() {
		Car::create($_POST['car'], $_POST['owner']);
		header('Location: ./');
	}	

	public function deleteAction() {
		Car::delete($_POST['id']);
		header('Location: ./');
	}		
}

$new_car_controller = new CarController();

if($_GET['action'] == 'index') {
	$new_car_controller->indexPage();
} else if($_GET['action']=='new') {
	$new_car_controller->newPage();
} else if($_GET['action']=='create') {
	$new_car_controller->createAction();
} else if($_GET['action']=='delete') {
	$new_car_controller->deleteAction();
}

?>