<!--Credit to Matt Huntington for creating the skeleton and notes for this lesson-->

# CRUD With PHP

## Lesson Objectives

1. Route URLs to php files
2. Connect to MySQL

## Route URLs to php files

Routing can be accomplished with a .htaccess file placed in your root directory for the app.  It will look like this:

```
RewriteEngine On
RewriteRule ^users/[0-9]+$ server.php
```

It uses regular expressions to map urls to files

## Connect to MySQL

Simple database connection and querying looks like this:

```php
$servername = "127.0.0.1";
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
