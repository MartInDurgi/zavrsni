<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "blog";

try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Vivify Blog</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="styles/blog.css" rel="stylesheet">
    <link href="styles/styles.css" rel="stylesheet">


</head>

<body>
    <?php include('header.php'); ?>


    <main role="main" class="container">

        <div class="row">
            <div class="col-sm-8 blog-main">


                <?php
                if (isset($_GET['post_id'])) {

                    $postId = $_GET['post_id'];

                    // pripremamo upit
                    $sql = "SELECT posts.id, title, posts.created_at, body, author FROM posts WHERE posts.id = {$postId}";
                    $sql1 = "SELECT * FROM comments WHERE post_id = {$postId}";
                    $statement = $connection->prepare($sql);
                    $statement1 = $connection->prepare($sql1);
                    //izvrsavamo upit
                    $statement->execute();
                    $statement1->execute();
                    // zelimo da se rezultat vrati kao asocijativni niz.
                    // ukoliko izostavimo ovu liniju, vratice nam se obican, numerisan niz
                    $statement->setFetchMode(PDO::FETCH_ASSOC);
                    $statement1->setFetchMode(PDO::FETCH_ASSOC);

                    // punimo promenjivu sa rezultatom upita
                    $singlePost = $statement->fetch();
                    $comments = $statement1->fetchAll();
                    // koristite var_dump kada god treba da proverite sadrzaj neke promenjive
                    echo '<pre>';
                    //var_dump($comments);
                    echo '</pre>';

                    // iteriramo kroz niz post-ova
                    //var_dump($_GET)
                ?>


                    <div class="blog-post">
                        <h2 class="blog-post-title"><?php echo ($singlePost['title']) ?></h2>
                        <p class=" blog-post-meta"><?php echo $singlePost["created_at"] ?> by <?php echo $singlePost["author"]  ?></p>
                        <?php echo $singlePost["body"] ?>

                    </div><!-- /.blog-post -->
                    <div class="comments">
                        <?php foreach ($comments as $comment) { ?>
                            <ul class="comment"> - <?php echo $comment["author"] . ": ";
                                                    echo $comment['text'] ?></ul>
                            <hr> <?php } ?>
                    </div>
                <?php
                } else {
                    echo ('post_id parameter was not sent through $_GET.');
                }
                ?>




            </div><!-- /.blog-main -->
            <?php include('sidebar.php'); ?>
        </div><!-- /.row -->

    </main><!-- /.container -->

    <?php include('footer.php'); ?>
</body>

</html>