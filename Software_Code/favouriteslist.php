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
    <?php include("navbar.php"); ?>
    <script>
        var element = document.getElementById('favouriteslist');
        element.classList.add("active");
    </script>
    <br>
    <div class="container-fluid text-center">
        <h1 class="display-5 fw-bold">Favourited items</h1>
    </div>
    <br>
    <?php
        if (!empty($_SESSION['favouriteslist']))
        {
            ?>

    <div class="container-responsive">
        <div class="row justify-content-center" style="margin-right:0px; margin-left:0px;">
            <div class="col-sm-8 col-sm-offset-2 pb-5">
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
                                    $sqlQ1 = "SELECT id, name, description, goalID, postcode, website, contacts FROM events WHERE events.id IN (".implode(',',$_SESSION['favouriteslist']).")";
                                    $rows = array();
                                    $result = $db->query($sqlQ1);

                                    while ($row = $result->fetch_assoc()) {
                                        $rows[] = $row;
                                    }
                                    foreach ($rows as $row){
                                            ?>
                            <tr>
                                <td>
                                    <a href="/deleteitem/<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"></a>
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
                <a href="/clearfavourites" class="btn btn-primary btn-sm mt-auto">Clear list</a>
                <a href="javascript:void(0);" class="btn btn-primary btn-sm mt-auto" onclick="printPage();">Print</a>
            </div>
        </div>
    </div>
    <?php
        }
        ?>
    <!-- Footer-->
    <script type="text/javascript">
        function printPage() {
            console.log(tableData);
            console.log(document.getElementsByTagName('table table-bordered table-striped'));
            var tableData = '<table border="1">' + document.getElementsByTagName('table')[0].innerHTML + '</table>';
            var data = '<button onclick="window.print()">Print this page</button>' + tableData;
            myWindow = window.open('', '', 'width=800,height=600');
            myWindow.innerWidth = screen.width;
            myWindow.innerHeight = screen.height;
            myWindow.screenX = 0;
            myWindow.screenY = 0;
            myWindow.document.write(data);
            myWindow.focus();
        };
    </script>


    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <script lang='javascript'>
        < /body> <
        /html>