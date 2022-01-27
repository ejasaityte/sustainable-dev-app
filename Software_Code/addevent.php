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
                <li class="nav-item"><a class="nav-link" href="/favouriteslist">Favourites</a></li>
                <li class="nav-item"><a class="nav-link active" href="/addevent">Add Event</a></li>
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
            <h1 class="display-5 fw-bold">Add new event</h1>
        </div>
        <br>
        <div class="container-fluid" style="width:30%; min-width:200px;">
        <form action="" method="post">
            <div class="d-grid gap-2">
                <div class="input-group">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                    <div class="invalid-tooltip"> Please enter the event name.</div>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" id="description" name="description" placeholder="Description" required>
                    <div class="invalid-tooltip"> Please enter a description.</div>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Postcode">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" id="goalName" name="goalName" placeholder="Associated goal" required>
                    <div class="invalid-tooltip"> Please enter an associated goal.</div>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" id="website" name="website" placeholder="Website">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" id="contacts" name="contacts" placeholder="Contacts">
                </div>
                <button type="submit" class="btn btn-primary">Add Event</button>
            </div>
        <?php
        $name = $_POST['name'];
        $description = $_POST['description'];

        if("" == trim($_POST['postcode'])){
            $postcode = 'NULL';
        } 
        else {
            $postcode = "'".$_POST['postcode']."'";
        }   

        $goalName = $_POST['goalName'];

        if("" == trim($_POST['website'])){
            $website = 'NULL';
        } 
        else {
            $website = "'".$_POST['website']."'";
        } 

        if("" == trim($_POST['contacts'])){
            $contacts ='NULL';
        } 
        else {
            $contacts = "'".$_POST['contacts']."'";
        } 

        $sql = "SELECT goalID FROM sustainablegoals WHERE goalName='". $goalName ."'";
        $rows = array();
        $result = $db->query($sql);
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        $output = '';
        foreach($rows as $item) {
            $output .= implode("\n" , $item);
        }

        if(!empty($rows)&&$_SESSION['username']=='admin'){
            $updateReq = "INSERT INTO events (id, name, description, postcode, goalID, website, contacts) 
            VALUES (NULL,'".$name."','".$description."',".$postcode.",".$output.",". $website .",".$contacts.")";
            $updateRes =$db->query($updateReq);
            ?><div class="alert alert-warning" role="alert">
            Success!
            </div> <?php
            }
        elseif(!empty($rows))
        {
            $updateReq = "INSERT INTO eventsholding (id, name, description, postcode, goalID, website, contacts) 
            VALUES (NULL,'".$name."','".$description."',".$postcode.",".$output.",". $website .",".$contacts.")";
            $updateRes =$db->query($updateReq);
            ?><div class="alert alert-warning" role="alert">
            Event placed in holding!
            </div> <?php
            }
        if($_SESSION['username']=='admin')
        {
            ?>
            </div>
            </div>
            <div class="container-fluid text-center">
            <h1 class="display-5 fw-bold" style="padding-top:50px;">Event holding list</h1>
        </div>
            <div class="container-responsive pb-5">
                <div class="row justify-content-center">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Goal</th>
                                    <th>Postcode</th>
                                    <th>Website</th>
                                    <th>Contacts</th>
                                </thead>
                                <tbody>
                                <?php                            
                                        $sqlQ1 = "SELECT id, name, description, goalID, postcode, website, contacts FROM eventsholding";
                                        $rows = array();
                                        $result = $db->query($sqlQ1);

                                        while ($row = $result->fetch_assoc()) {
                                            $rows[] = $row;
                                        }
                                        foreach ($rows as $row){
                                                ?>
                                                <tr>
                                                    <td>
                                                        <a href="/addeventtodatabase/<?php echo $row['id']; ?>"class="btn btn-success btn-sm"></a>
                                                        <a href="/deleteeventfromholding/<?php echo $row['id']; ?>"class="btn btn-danger btn-sm"></a>
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
                                                    <td><?php echo $row['contacts']; ?></td>
                                                </tr>
                                                <?php
                                            }
                
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <a href="/clearholdinglist" class="btn btn-primary btn-sm mt-auto">Clear list</a>
                    </div>
                </div>
        </div>
            
            
            
            <?php
        }
        else {
            ?> </div>
            </div> <?php
        }
    ?>
        <!-- Footer-->
        <footer class="py-5 bg-dark" style="bottom:0">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Sustainable Dundee 2021</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
