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
        <link href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css" rel="stylesheet">
        <script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
        <style>
            #map { position: absolute; top: 0; bottom: 0; width: 100%; }
        </style>
    </head>
    <?php session_start(); 
    if (!isset($_SESSION['favouriteslist']))
    {
        $_SESSION['favouriteslist'] = array();
    }
    ?>
    <body>
        <style>
            #map {
                position: fixed;
                width: 50%;
            }
            #features {
                width: 50%;
                margin-left: 50%;
                font-family: sans-serif;
                overflow-y: scroll;
                background-color: #fafafa;
            }
            section {
                padding: 25px 50px;
                line-height: 25px;
                border-bottom: 1px solid #ddd;
                opacity: 0.25;
                font-size: 13px;
            }
            section.active {
                opacity: 1;
            }
            section:last-child {
                border-bottom: none;
                margin-bottom: 200px;
            }
        </style>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-lg-5">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" href="/">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="/map/0">Explore</a></li>
                        <li class="nav-item"><a class="nav-link" href="/news">News</a></li>
                        <li class="nav-item"><a class="nav-link" href="/leaderboard">Leaderboard</a></li>
<?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
?>
                        <li class="nav-item"><a class="nav-link" href="/favouriteslist">Favourites</a></li>
<?php
        $sql = "SELECT friends.userID FROM `friends` INNER JOIN `users` ON friends.userID = users.userID WHERE friends.friendID = ".$_SESSION['userID']." AND friends.accepted = 0";
        $rows = array();
        $result = $db->query($sql);
        while ($row = $result->fetch_assoc()) $rows[] = $row;
        if (empty($rows)) {
?>
                        <li class="nav-item"><a class="nav-link " href="/addfriend">Friends</a></li>
<?php
        } else {
?>
                        <li class="nav-item"><a class="nav-link viridian" href="/addfriend">Friends</a></li>
<?php
        }
        if ($_SESSION['isadmin']==1) { 
?>
                        <li class="nav-item"><a class="nav-link" href="/addevent">Add Event</a></li>
<?php 
        } 
        if ($_SESSION['username']=='admin') { 
?>
                        <li class="nav-item"><a class="nav-link" href="/adduser">Add User</a></li>
<?php 
        } 

?>
                        <li class="nav-item"><a class="nav-link" href="/logout">Log out</a></li>
<?php 
    } 
    else{
?>
                        <li class="nav-item"><a class="nav-link" href="/login"><span class="glyphicon glyphicon-log-in"></span>Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
<?php 
    } 
?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page Content-->
        <div class="container px-lg-5">
            <!-- Page Features-->
            <?php
                echo "<div id='map'></div>
                <div id='features'>
                    <section id='tour1' class='active'>
                        <h3>Tour Destination 1</h3>
                        <p>
                        Test
                        </p>
                    </section>
                    <section id='tour2'>
                        <h3>Tour Destination 2</h3>
                        <p>
                        Test
                        </p>
                    </section>
                    <section id='tour3'>
                        <h3>Tour Destination 3</h3>
                        <p>
                        Test
                        </p>
                    </section>
                    <section id='tour4'>
                        <h3>Tour Destination 4</h3>
                        <p>
                        Test
                        </p>
                    </section>
                    <section id='tour5'>
                        <h3>Tour Destination 5</h3>
                        <p>
                        Test
                        </p>
                    </section>
                </div>
                <script>
                    mapboxgl.accessToken = 'pk.eyJ1IjoiZXVhbmRvY2tpbmciLCJhIjoiY2t5dmt1aTZvMXpqMTJxcHR2eTF2Z21zOCJ9.yZNbnAG0QP59OzGsTYFX1A';
                    const map = new mapboxgl.Map({
                        container: 'map',
                        style: 'mapbox://styles/mapbox/streets-v11',
                        center: [-2.9707, 56.4620],
                        pitchWithRotate: false,
                        trackResize: true,
                        zoom: 13
                    });
                        
                    const chapters = {
                        'tour1': {
                        bearing: 27,
                        center: [-0.15591514, 51.51830379],
                        zoom: 15.5,
                        pitch: 20
                        },
                        'tour2': {
                        duration: 6000,
                        center: [-0.07571203, 51.51424049],
                        bearing: 150,
                        zoom: 15,
                        pitch: 0
                        },
                        'tour3': {
                        bearing: 90,
                        center: [-0.08533793, 51.50438536],
                        zoom: 13,
                        speed: 0.6,
                        pitch: 40
                        },
                        'tour4': {
                        bearing: 90,
                        center: [0.05991101, 51.48752939],
                        zoom: 12.3
                        },
                        'tour5': {
                        bearing: 45,
                        center: [-0.18335806, 51.49439521],
                        zoom: 15.3,
                        pitch: 20,
                        speed: 0.5
                        }
                    };
                            
                    let activeChapterName = 'tour1';
                    function setActiveChapter(chapterName) {
                        if (chapterName === activeChapterName) return;
                            
                        map.flyTo(chapters[chapterName]);
                            
                        document.getElementById(chapterName).classList.add('active');
                        document.getElementById(activeChapterName).classList.remove('active');
                            
                        activeChapterName = chapterName;
                    }
                            
                    function isElementOnScreen(id) {
                        const element = document.getElementById(id);
                        const bounds = element.getBoundingClientRect();
                        return bounds.top < window.innerHeight && bounds.bottom > 0;
                    }
                            
                    // On every scroll event, check which element is on screen
                    window.onscroll = () => {
                        for (const chapterName in chapters) {
                            if (isElementOnScreen(chapterName)) {
                                setActiveChapter(chapterName);
                                break;
                            }
                        }
                    };
                        
                </script>";
            php?>
        </div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Sustainable Dundee 2021</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
