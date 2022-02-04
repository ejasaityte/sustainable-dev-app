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
        body {
            margin: 0;
            padding: 0;
        }

        #map {
            top: 0;
            bottom: 0;
            width: 50%;
            height: 400px;
            float: left;
        }
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
        #features {
            width: 50%;
            max-height: 400px;
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
    <?php include("navbar.php"); ?>
    <script>
        var element = document.getElementById('tours');
        element.classList.add("active");
    </script>
    <!-- Page Content-->
    <div class="container-fluid text-center">
        <h1 class="display-5 fw-bold">Tours Available</h1>
    </div>
    <div class="container px-lg-5">
        <div style="" class="map-container">
            <!-- Page Features-->
            <?php
                    echo "<div id='map'></div>
                    <div id='features'>
                        <section id='tour1' class='active'>
                            <h3>Shelter</h3>
                            <p>
                            Charity shops are awesome for those times when you leave home and realise you're really quite chilly and need a new hat or a nice cosy jumper. And our lovely Dundee shop will deliver in spades, make sure you pop in to say hi!
                            </p>
                        </section>
                        <section id='tour2'>
                            <h3>Red Cross</h3>
                            <p>
                            Our shops across the UK are now open. Through our shops, we sell pre-loved fashion, furniture, books, and more to help fund our life-changing work in the UK and abroad.
                            </p>
                        </section>
                        <section id='tour3'>
                            <h3>Barnardo's</h3>
                            <p>
                            The scale of what we do may be big and complex, but our aim is simple - to provide the best outcome for every child, no matter who they are or what they have been through.
                            </p>
                        </section>
                        <section id='tour4'>
                            <h3>British Heart Foundation</h3>
                            <p>
                            We fund around £100 million of research each year into all heart and circulatory diseases and the things that cause them. Heart diseases. Stroke. Vascular dementia. Diabetes. They're all connected, and they're all under our microscope.
                            </p>
                        </section>
                        <section id='tour5'>
                            <h3>Central Library</h3>
                            <p>
                            Leisure & Culture Dundee Libraries. Read, Relax, Rediscover. 
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
                            center: [-2.97471769630174, 56.4609700297359],
                            zoom: 15.5,
                            pitch: 20
                            },
                            'tour2': {
                            duration: 6000,
                            center: [-2.9708298272469, 56.4608004085128],
                            bearing: 150,
                            zoom: 15,
                            pitch: 0
                            },
                            'tour3': {
                            bearing: 90,
                            center: [-2.97139839444701, 56.4619002567239],
                            zoom: 13,
                            speed: 0.6,
                            pitch: 40
                            },
                            'tour4': {
                            bearing: 90,
                            center: [-2.96944658862882, 56.4639343262982],
                            zoom: 12.3
                            },
                            'tour5': {
                            bearing: 45,
                            center: [-2.96930793466534, 56.4647174282653],
                            zoom: 15.3,
                            pitch: 20,
                            speed: 0.5
                            }
                        };

                        map.on('load', function () {
                            map.resize();
                        });
                                
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
                            return bounds.top < document.getElementById('features').clientHeight && bounds.bottom > 150;
                        }
                                
                        // On every scroll event, check which element is on screen
                        document.getElementById('features').onscroll = () => {
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
        <div>
            <p>Go on our Quality Education tour! Visit Dundee's four famous charity shops, and end the tour at the grand Central Library.</p>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>