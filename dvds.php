<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body style="background-color:pink;">

<center>
  <h1 style="margin-top:50px;">Results</h1>
  <br>
  <div style="text-align:left; width:300px;">
<?php
//if theres no title go back to index page
if(empty($_REQUEST['title'])) {
    header('Location: index.php');
}
//db info
$host = 'itp460.usc.edu';
$database_name = 'dvd';
$username = 'student';
$password = 'ttrojan';
//connect to db
$pdo = new PDO("mysql:host=$host;dbname=$database_name", $username, $password);

//sql select from dvds and join tables where the title is equal to search
$sql = "SELECT  genre_name, format_name, title, rating_name
FROM dvds
INNER JOIN ratings ON dvds.rating_id = ratings.id
INNER JOIN formats ON dvds.format_id = formats.id
INNER JOIN genres ON dvds.genre_id = genres.id
WHERE title LIKE ?";

$statement = $pdo->prepare($sql);
$like = '%' . $_GET['title'] . '%';
$statement->bindParam(1, $like);
$statement->execute();
$dvds = $statement->fetchAll(PDO::FETCH_OBJ);

//if theres no results give error msg
if (empty($dvds)) {
    echo "<h2>Sorry, nothing was found. <a href='/'>Search again!</a></h2>";
}
?>

<ul>
    <?php foreach($dvds as $dvd) : ?>
        <h2><?= $dvd->title ?></h2>
        <p>Genre: <?= $dvd->genre_name ?></p>
        <p>Format: <?= $dvd->format_name ?></p>
        <p>Rating: <?= $dvd->rating_name ?></p>
        <p><a href="ratings.php?rating=<?= $dvd->rating_name ?>">View other <?= $dvd->rating_name ?> rated movies</a></p>
        <br>
    <?php endforeach; ?>
</ul>
</div>
</center>
</body>
</html>
