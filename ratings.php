<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body style="background-color:pink;">

<center>
<div style="text-align:left; width:300px;">

<?php
//connect to db
$host = 'itp460.usc.edu';
$database_name = 'dvd';
$username = 'student';
$password = 'ttrojan';

$pdo = new PDO("mysql:host=$host;dbname=$database_name", $username, $password);
//assign rating to variable
$rating = $_REQUEST['rating'];

//get the ratings that are equal to the clicked rating
$sql = "SELECT title, genre_name, format_name, rating_name
FROM dvds
INNER JOIN genres ON dvds.genre_id = genres.id
INNER JOIN formats ON dvds.format_id = formats.id
INNER JOIN ratings ON dvds.rating_id = ratings.id
WHERE ratings.rating_name = ?";

$statement = $pdo->prepare($sql);
$statement->bindParam(1, $rating);
$statement->execute();
$dvds = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<h1 style="margin-top:50px;">Display results for all <?= $rating ?> rated movies</h1>
<ul>
    <?php foreach($dvds as $dvd) : ?>
        <h2><?= $dvd->title ?></h2>
        <p>Genre: <?= $dvd->genre_name ?></p>
        <p>Format: <?= $dvd->format_name ?></p>
        <br>
    <?php endforeach; ?>
</ul>
</div>
</center>
</body>
</html>
