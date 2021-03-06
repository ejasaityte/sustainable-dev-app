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
    <link href="/css/styles.css" rel="stylesheet" />
</head>
<?php session_start(); 
    include("dbconnect.php");?>

<body>
    <!-- Responsive navbar-->
    <?php include("navbar.php"); ?>
    <br>
    <div class="container-fluid text-center">
        <h1 class="display-5 fw-bold">Edit event</h1>
    </div>
    <br>

    <?php
            $updateReq = "SELECT name, description, postcode, goalID, website, contacts FROM events WHERE id=".$params['id'];
            
            $rows = array();
            $result = $db->query($updateReq);
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            foreach ($rows as $row)
            {
                ?>

    <div class="container-fluid" style="width:30%; min-width:200px;">
        <form action="" method="post">
            <div class="d-grid gap-2">
                <div class="input-group">
                    <input type="text" class="form-control" id="name" name="name" minlength="3"
                        value="<?php if (isset($row['name'])) echo $row['name'];?>" placeholder="Name" required>
                    <div class="invalid-tooltip"> Please enter the event name.</div>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" id="description" name="description" minlength="3"
                        value="<?php if (isset($row['description'])) echo $row['description'];?>"
                        placeholder="Description" required>
                    <div class="invalid-tooltip"> Please enter a description.</div>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" id="postcode" name="postcode"
                        value="<?php if (isset($row['postcode'])) echo $row['postcode'];?>" placeholder="Postcode">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" id="goalName" name="goalName" minlength="3"
                        value="<?php if (isset($row['goalID'])) echo $row['goalID'];?>" placeholder="Associated goal"
                        required>
                    <div class="invalid-tooltip"> Please enter an associated goal.</div>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" id="website" name="website"
                        value="<?php if (isset($row['website'])) echo $row['website'];?>" placeholder="Website">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" id="contacts" name="contacts"
                        value="<?php if (isset($row['contacts'])) echo $row['contacts'];?>" placeholder="Contacts">
                </div>
                <button type="submit" class="btn btn-primary">Edit Event</button>
            </div>

            <?php 
            break;
            }
        $name = $_POST['name'];
        $description = $_POST['description'];

        if("" == trim($_POST['postcode'])){
            $postcode = 'NULL';
        } 
        else {
            $postcode = "'".$_POST['postcode']."'";
        }   

        $goalID = $_POST['goalName'];

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

        $sql = "UPDATE events SET name='". $name ."', description='". $description . "', postcode=".$postcode.", goalID=".$goalID.", website=".$website.", contacts=".$contacts." WHERE id=". $params['id'] ."";
        $result = $db->query($sql);?>
        </form>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>