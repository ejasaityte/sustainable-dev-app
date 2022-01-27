<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sustainable Dundee</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <?php session_start(); 
    include("dbconnect.php");?>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-lg-5">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="/map">Explore</a></li>
                        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
          ?>
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="/favouriteslist">Favourites</a></li>
                <li class="nav-item"><a class="nav-link" href="/addevent">Add Event</a></li>
                <?php 
                if ($_SESSION['username']=='admin') { ?>
                <li class="nav-item"><a class="nav-link" href="/adduser">Add User</a></li>
                <?php } ?>
                <li class="nav-item"><a class="nav-link" href="/logout">Log out</a></li>
                <?php } 
                else{
                ?>
                <li class="nav-item"><a class="nav-link" href="/login"><span class="glyphicon glyphicon-log-in"></span>Login</a></li>
        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
        <br>
        <div class="container-fluid text-center">
            <h1 class="display-5 fw-bold">Favourited items</h1>
        </div>
        <br>
        <?php
        if (!empty($_SESSION['favouriteslist']))
        {
            ?>

        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <form method="POST" action="save_cart.php">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th></th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Goal</th>
                                <th>Postcode</th>
                                <th>Website</th>
                            </thead>
                            <tbody>
                            <?php                            
                                    $sqlQ1 = "SELECT id, name, description, goalID, postcode, website FROM events WHERE events.id IN (".implode(',',$_SESSION['favouriteslist']).")";

                                    $rows = array();
                                    $result = $db->query($sqlQ1);

                                    while ($row = $result->fetch_assoc()) {
                                        $rows[] = $row;
                                    }
                                    foreach ($rows as $row){
                                            ?>
                                            <tr>
                                                <td>
                                                    <a href="deleteitem.php?id=<?php echo $row['id']; ?>&index=<?php echo $index; ?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></a>
                                                </td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['description']; ?></td>
                                                <td>
                                                <?php
                                                $sqlQ2 = "SELECT goalName FROM sustainablegoals WHERE sustainablegoals.goalID =". $row['goalID'];      
                                                $rowsg = array();
                                                $result = $db->query($sqlQ2);

                                                while ($rowg = $result->fetch_assoc()) {
                                                    $rowsg[] = $rowg;
                                                }
                                                foreach ($rowsg as $rowg){
                                                    echo $rowg['goalName'];
                                                }
                                                ?>
                                                </td>
                                                <td><?php echo $row['postcode']; ?></td>
                                                <td><?php echo $row['website']; ?></td>
                                            </tr>
                                            <?php
                                        }
            
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="/clearfavourites" class="btn btn-danger">Clear list</a>
                    </form>
                </div>
            </div>
        </div>
<?php
        }
        ?>
        <!-- Footer-->
        <footer class="py-5 bg-dark" style="bottom:0;">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Sustainable Dundee 2021</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
