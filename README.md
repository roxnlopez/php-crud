<!--Credit to Matt Huntington for creating the skeleton and notes for this lesson-->

<!--I think we started this at like 2:05...not sure.  I split the class into "team independence" and "team together", and the together team worked through a little more slowly, with some pointers from me.-->

# CRUD With PHP

## Lesson Objectives
*By the end of this lesson, developers will be able to:*

1. **Route** URLs to php files
2. **Connect** to MySQL
3. **Build** CRUD functionality with PHP

## Route URLs to php files

Routing can be accomplished with a .htaccess file placed in your root directory for the app.  

<details><summary>(It will look like this)</summary>
```
RewriteEngine On
RewriteRule ^users/[0-9]+$ server.php
```
</details>
It uses regular expressions to map urls to files.

Before we can use our `.htaccess` file, we will need to change a security setting.  Go into your `httpd.conf` file in `/Applications/MAMP/conf/apache` and change the following

```
<FilesMatch "^\.ht">
    Order allow,deny
    Deny from all
    Satisfy All
</FilesMatch>
```

to `Allow` your `.htaccess` file.

```
<FilesMatch "^\.ht">
    Order allow,deny
    Allow from all
    Satisfy All
</FilesMatch>
```

Once this change is made, you will need to `Stop Servers` and `Start Servers` in your MAMP console if it was already running.

## Connect to MySQL

Simple database connection and querying looks like this:

```php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "phpexample";

// Create connection
 $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
 if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM cars";
$this->results = $conn->query($sql);
$conn->close();
```

Looping through the results would go like this:

```php
<?php while($row = $this->cars->fetch_object()): ?>
 <!-- print_r($row); -->
 <li>
  <?= $row->brand ?>:
  <?= $row->num_wheels ?>
 </li>
<?php endwhile; ?>
```

## The Task

We need an app to keep track of all the cool cars we have.  How are we going to do this?  With a CRUD app!  If we were building this in Javascript, this would be old hat.  Since PHP is new to us, though, we'll go a little slower.

### Setup

1. Create a new directory inside your MAMP Web Server root called `php_cars`.

1. Before we build our CRUD app, go into your `Sequel Pro` program, open the `Query` tab, and create the `phpcrud` database (You'll need to create a socket connection - directions can be found [here](https://github.com/den-materials/php-wordpress#set-up)).  We will use this database for all our data manipulation.

1. Once this is done, we need to create a table for all the cars we are going to add.  Run the following query in `Sequel Pro`:

	```sql
	CREATE TABLE cars (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		car VARCHAR(50) NOT NULL,
		owner VARCHAR(50) NOT NULL
	);
	```

1. `INSERT` a car into your table with a `car` and `owner` field.

1. Make sure your car is in the table before moving on.

<!--2:23 before moving on to next step -->

### Hello PHP

1. Create a `views` directory inside your `php_cars` directory.

1. Create a `cars` directory inside your `views` directory.

1. Create an `index.php` file inside your `cars` directory.  Give it an HTML boilerplate, and an `<h1>` tag that says "Cars Index Page".

1. Go to `http://localhost:8888/php_cars/views/cars/`, and see your beautiful work!

### Getting our car from the DB

<!--Actually 2:28 before starting this step -->

Hard-coded text is great and all, but as with any CRUD route, we need to do two more things before we are really "full-stack": we need routes, and we need to talk to the DB.  That's where our notes from earlier come in.  We need to create an `.htaccess` file, and we need to connect to MySQL.  Here we go...

1. Create an `.htaccess` file at the root of `php_cars`.  Put the following lines inside:

	```
	RewriteEngine On
	RewriteRule ^cars/$ controllers/cars.php?action=index
	```
	
1. You can probably guess what's coming next.  That controller folder and file we just referenced in `.htaccess`?  We need to create that. (Do that now.)

1. Since this is a PHP file, we need to create a `<?php` tag.  Also, notice that we have a **V**iew and a **C**ontroller.  Are we missing something?  Yes we are.  And we'll get there soon enough.  For now, start your `cars.php` file this way:

	```php
	<?php

	require('../models/car.php');

	?>
	```
	
1. We'll get to the model file in just a bit.  For now, though, we need build out that `action=index` we put in query params earlier. Place it inside your `php` tag in `cars.php`.

	```php
	if($_GET['action'] == 'index') {
		$new_car_controller->indexPage();
	}
	```

1. Wait, `$new_car_controller`?  We never created one of those.  Hold your horses, we're getting there:

	```php
	Class CarController {

		public function indexPage(){
			$cars = Car::find();
			require('../views/cars/index.php');
		}
	}
	```

1. Alright, there's our `indexPage()`, but what about the `$new_car_controller`?  Well, take a look at that first word and think for a second what we want to do...think back to our OOP classes, and you'll get:

	```php
	$new_car_controller = new CarController();
	```

1. Noice!  Make sure all of this code is in the proper order (PHP, like JS, reads top-down, so you can't use any variables above where they are created), then our controller is good to go.

<details><summary> . . . hint hint . . .</summary>

```php
	<?php
		require('../models/car.php');

		Class CarController {

			public function indexPage(){
				$cars = Car::find();
				require('../views/cars/index.php');
			}
		}

		$new_car_controller = new CarController();

		if($_GET['action'] == 'index') {
			$new_car_controller->indexPage();
		}
	?>
```

</details>

1. Now it's time for our (America's Next Top) model.  

![<3](https://media.giphy.com/media/26FKX7B7L6cfHPVIY/giphy.gif)

Create a `models` folder and put a `car.php` file inside it.

1. Start out the model with another class:

	```php
	<?php
		Class Car {

		}
	?>
	```
	
1. Now we need to give it that `Car::find()` function we are using in the controller.  Put this inside the Class:

	```php
	static public function find() {
		$servername = 'localhost';
		$username = 'root';
		$password = 'root';
		$dbname = 'phpcrud';
	}
	```
	
1. Make sure the above matches your DB name and login parameters for MySQL, then add in the meat of the function DIRECTLY AFTER the setup variables:

	```php
	$mysql_connection = new mysqli($servername, $username, $password, $dbname);
	```

1. Since we want to escalate any issues we see, we need to make sure this connection actually worked - that means we need a conditional. We have a MySQL connection, much like our earlier Mongo and PostgreSQL connections. But just like with those tools, the connection is only the first step - we also need to get our data.

	```php
	if($mysql_connection->connect_error){
		$mysql_connection->close();
		die('Connection Failed: ' . $mysql_connection->connect_error);
	} else {
		$sql = "SELECT * FROM cars;";
		$results = $mysql_connection->query($sql);
		return $results;
	}
	```

<details><summary>(Psst . . . That `car.php` file is tricky - it should look like this)</summary>

	<?php
	Class Car {
		static public function find() {
			$servername = 'localhost';
			$username = 'root';
			$password = 'root';
			$dbname = 'phpcrud';
			$mysql_connection = new mysqli($servername, $username, $password, $dbname);

		if($mysql_connection->connect_error){
			$mysql_connection->close();
			die('Connection Failed: ' . $mysql_connection->connect_error);
		} else {
			$sql = "SELECT * FROM cars;";
			$results = $mysql_connection->query($sql);
			return $results;
		}
		}
	}
	?>

</details>

1. Last piece. Our `index.php` for cars is still a blank template.  Let's get some cars in there.  Add this to the file below your `h1`:

	```php
	  <section>
	      <ul>
		  <?php while($row = $cars->fetch_object()): ?>
		      <li>
			  Here is a <?php echo $row->car ?> for <?php echo $row->owner?>
		      </li>
		  <?php endwhile; ?>
	      </ul>
	  </section>	
	  ```

1. If you restart your MAMP server, and go to `http://localhost:8888/php_cars/cars/`, you should see the car you created during setup!

![](images/powPowPowerWheels.gif)

<!--First folks "finished" around 3:25-3:30, rest of folks took till 4...I may have set the bar too high on this one. Though everyone is literally sick and tired now, so...-->

### The "C" in CRUD

OK, so now we can *see* our cars.  Now we need to be able to *save* new ones.  For this, we will have to make a *create* and *new* route.  We'll start the same place we did last time, in `.htaccess`.

1. Add these two lines to your `.htaccess` file:

	```php
	RewriteRule ^cars/new$ controllers/cars.php?action=new
	RewriteRule ^cars/create$ controllers/cars.php?action=create
	```
	
1. Now we need to create those two actions in `cars.php`.  Use the pattern we used for `index` to make two more conditionals for `new` and `create`.

	<details><summary>Try writing out a skeleton before checking here</summary>
	
	```php
	if($_GET['action'] == 'index') {
		$new_car_controller->indexPage();
	} else if($_GET['action']=='new') {
		$new_car_controller->newPage();
	} else if($_GET['action']=='create') {
		$new_car_controller->createAction();
	}
	```
	
	</details>

1. And we need to create those two functions.  Try creating `newPage()` on your own (it's very similar to `index()`).

	<details><summary>Try writing out a skeleton for `createAction()` before checking here</summary>
	
	```php
	public function newPage(){
		require('../views/cars/new.php');
	}

	public function createAction() {
		Car::create($_POST['car'], $_POST['owner']);
		header('Location: ./');
	}
	```
	
	</details>
	
1. Now we need to head over to `models/car.php` to make the `Car::create()` method.  This is almost identical to the `Car::find()` method except for two crucial details: your SQL query will be different, and you need to pass in parameters.  Those lines will look like this, respectively:

	```php
	} else {
		$sql = "INSERT INTO cars (car, owner) VALUES ('".$car."','".$owner."');";
		$mysql_connection->query($sql);
	}
	```
	
	```php
	static public function create($car, $owner) {
	```

1. Once you've combined the lines above with your `find()` method to make a full `create()` method, we're ready to circle back to our views.  Create a new view in `views/cars` called `new.php`.  All you need on this page is some HTML boilerplate, a heading, and a form.  The form will have two `<input>`s, one with a `name` of "car", and the other with a `name` of "owner".  What should the `submit` `action` and `method` be?

<details><summary>Example solution</summary>

```html
	<!DOCTYPE html>
	<html>
	    <head>
	    </head>
	    <body>
			<h1>Add a New Car To The List</h1>
			<form action="create" method="POST">
			    <input type="text" name="car" placeholder="Maserati"/><br/>
			    <input type="text" name="owner" placeholder="How May I Butcher Your Anme?"/><br/>
			    <input type="submit" value="Submit"/>
			</form>
	    </body>
	</html>
```
</details>

1. Add a link to your `index.php` that takes you to your `new.php`.  (What should it route to, based on your `.htaccess` file?)

1. Now go back to `http://localhost:8888/php_cars/cars/`, and add a new car.  Yee haw!

### Challenge Yourself

OK, now we can Read and Create cars.  Wouldn't it be cool if we could Update and Delete them?  Think about a few things and then Google your way to a solution.

- What would the SQL query look like for Delete or Update?
- What would the route look like in `.htaccess`?
- How can you re-use the code we already have?

If you get stuck, remember to:

- Check all the logs in `/Applications/MAMP/logs`
- Ask your neighbors

### Another challenge

Connecting to MySQL with every DB request?  That's silly, and it's not DRY.  Create a `connection.php` file and `require` it wherever you need it, rather than repeating the connection all over the place.
