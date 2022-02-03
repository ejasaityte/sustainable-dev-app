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
        <h1 class="display-5 fw-bold">Edit event location</h1>
    </div>
    <br>

    <?php 
            $updateReq = "SELECT postcode FROM events WHERE id=".$params['id'];
            
            $rows = array();
            $result = $db->query($updateReq);
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            foreach ($rows as $row)
            {
                $coordReq = "SELECT * FROM coord WHERE postcode='".$row['postcode']."'";
            
                $rowsL = array();
                $resultL = $db->query($coordReq);
                while ($rowL = $resultL->fetch_assoc()) {
                    $rowsL[] = $rowL;
                }
                $empty = True;
                foreach ($rowsL as $rowLt)
                {
                    $empty = False;
                    $rowL = $rowLt;
                }
                ?>
    <div class="container-fluid" style="width:30%; min-width:200px;">
        <form action="" method="post">
            <div class="d-grid gap-2">
                <div class="input-group">
                    <input type="text" class="form-control" id="postcode" name="postcode"
                        value="<?php if (isset($row['postcode'])) echo $row['postcode'];?>" placeholder="Postcode">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" id="address" name="address"
                        value="<?php if (isset($rowL['address'])) echo $rowL['address'];?>" placeholder="Address">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" id="lat" name="lat"
                        value="<?php if (isset($rowL['lat'])) echo $rowL['lat'];?>" placeholder="Latitude">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" id="lon" name="lon"
                        value="<?php if (isset($rowL['lon'])) echo $rowL['lon'];?>" placeholder="Longitude">
                </div>
                <button type="submit" class="btn btn-primary">Edit Event Location</button>
            </div>

            <?php 
        if("" == trim($_POST['postcode'])){
            if(!isset($row['postcode'])) $postcode = 'NULL';
            else $postode = "'".$row['postcode']."'";
        } 
        else {
            $postcode = "'".$_POST['postcode']."'";
        }   


        if("" == trim($_POST['address'])){
            if(!isset($row['address'])) $address = 'NULL';
            else $address = $row['address'];
        } 
        else {
            $address = "'".$_POST['address']."'";
        } 

        if("" == trim($_POST['lat'])){
            if(!isset($row['lat'])) $lat = 'NULL';
            else $lat = $row['lat'];
        } 
        else {
            $lat = $_POST['lat'];
        } 

        if("" == trim($_POST['lon'])){
            if(!isset($row['lon'])) $lon = 'NULL';
            else $lon = $row['lon'];
        } 
        else {
            $lon = $_POST['lon'];
        } 

        if ($_POST['postcode'] != $row['postcode'])
        {
            $sql = "UPDATE events SET postcode=".$postcode." WHERE id=".$params['id'];
            $result = $db->query($sql);
        }
        if($empty==False)
            {
                $sql = "UPDATE coord SET postcode=". $postcode .", address=". $address . ", lat='".$lat."', lon='".$lon."' WHERE postcode='". $row['postcode'] ."'";
            }
        else {
            $sql = "INSERT INTO coord (postcode, address, lat, lon) VALUES (". $postcode .", ". $address . ",'".$lat."','".$lon."')";
        }
        $result = $db->query($sql);

        break;
    }
?>
        </form>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>