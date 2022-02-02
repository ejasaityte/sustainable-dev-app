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
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&family=Roboto&display=swap" rel="stylesheet">
        <link href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css" rel="stylesheet">
        <script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
        <style>
            body { margin: 0; padding: 0; }
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
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="/">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="/map/0">Explore</a></li>
                        <li class="nav-item"><a class="nav-link" href="/news">News</a></li>
                        <li class="nav-item"><a class="nav-link" href="/leaderboard">Leaderboard</a></li>
                        <?php
                            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                        ?>
                        <li class="nav-item"><a class="nav-link" href="/favouriteslist">Favourites</a></li>
                        <li class="nav-item"><a class="nav-link" href="/addfriend">Friends</a></li>
                        <?php 
                            if ($_SESSION['isadmin']==1) { 
                        ?>
                        <li class="nav-item"><a class="nav-link" href="/addevent">Add Event</a></li>
                        <?php } 
                            if ($_SESSION['username']=='admin') { 
                        ?>
                        <li class="nav-item"><a class="nav-link" href="/adduser">Add User</a></li>
                        <?php 
                                } 
                        ?>
                        <li class="nav-item"><a class="nav-link" href="/logout">Log out</a></li>
                        <?php 
                            }else{
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
        <section class="pt-4 bg-viridian">
            <div class="container px-lg-5">
                <!-- Page Features-->
                <h1 class="display-5 fw-bold">See our locations!</h1>
                <?php
                    echo "<div id='map'></div>
                    <div id="features">
                        <section id="baker" class="active">
                            <h3>221b Baker St.</h3>
                            <p>
                            November 1895. London is shrouded in fog and Sherlock Holmes and
                            Watson pass time restlessly awaiting a new case. "The London
                            criminal is certainly a dull fellow," Sherlock bemoans. "There have
                            been numerous petty thefts," Watson offers in response. Just then a
                            telegram arrives from Sherlock's brother Mycroft with a mysterious
                            case.
                            </p>
                        </section>
                        <section id="aldgate">
                            <h3>Aldgate Station</h3>
                            <p>
                            Arthur Cadogan West was found dead, head crushed in on train tracks
                            at Aldgate Station at 6AM Tuesday morning. West worked at Woolwich
                            Arsenal on the Bruce-Partington submarine, a secret military
                            project. Plans for the submarine had been stolen and seven of the
                            ten missing papers were found in West's possession. Mycroft implores
                            Sherlock to take the case and recover the three missing papers.
                            </p>
                        </section>
                        <section id="london-bridge">
                            <h3>London Bridge</h3>
                            <p>
                            Holmes and Watson's investigations take them across London. Sherlock
                            deduces that West was murdered elsewhere, then moved to Aldgate
                            Station to create the illusion that he was crushed on the tracks by
                            a train. On their way to Woolwich Sherlock dispatches a telegram to
                            Mycroft at London Bridge: "Send list of all foreign spies known to
                            be in England, with full address."
                            </p>
                        </section>
                        <section id="woolwich">
                            <h3>Woolwich Arsenal</h3>
                            <p>
                            While investigating at Woolwich Arsenal Sherlock learns that West
                            did not have the three keys&mdash;door, office, and
                            safe&mdash;necessary to steal the papers. The train station clerk
                            mentions seeing an agitated West boarding the 8:15 train to London
                            Bridge. Sherlock suspects West of following someone who had access
                            to the Woolwich chief's keyring with all three keys.
                            </p>
                        </section>
                        <section id="gloucester">
                            <h3>Gloucester Road</h3>
                            <p>
                            Mycroft responds to Sherlock's telegram and mentions several spies.
                            Hugo Oberstein of 13 Caulfield Gardens catches Sherlock's eye. He
                            heads to the nearby Gloucester Road station to investigate and
                            learns that the windows of Caulfield Gardens open over rail tracks
                            where trains stop frequently.
                            </p>
                        </section>
                        <section id="caulfield-gardens">
                        <h3>13 Caulfield Gardens</h3>
                            <p>
                            Holmes deduces that the murderer placed West atop a stopped train at
                            Caulfield Gardens. The train traveled to Aldgate Station before
                            West's body finally toppled off. Backtracking to the criminal's
                            apartment, Holmes finds a series of classified ads from
                            <em>The Daily Telegraph</em> stashed away. All are under the name
                            Pierrot: "Monday night after nine. Two taps. Only ourselves. Do not
                            be so suspicious. Payment in hard cash when goods delivered."
                            </p>
                        </section>
                        <section id="telegraph">
                        <h3>The Daily Telegraph</h3>
                            <p>
                            Holmes and Watson head to The Daily Telegraph and place an ad to
                            draw out the criminal. It reads: "To-night. Same hour. Same place.
                            Two taps. Most vitally important. Your own safety at stake.
                            Pierrot." The trap works and Holmes catches the criminal: Colonel
                            Valentine Walter, the brother of Woolwich Arsenal's chief. He
                            confesses to working for Hugo Oberstein to obtain the submarine
                            plans in order to pay off his debts.
                            </p>
                        </section>
                        <section id="charing-cross">
                        <h3>Charing Cross Hotel</h3>
                            <p>
                            Walter writes to Oberstein and convinces him to meet in the smoking
                            room of the Charing Cross Hotel where he promises additional plans
                            for the submarine in exchange for money. The plan works and Holmes
                            and Watson catch both criminals.
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
                            'baker': {
                            bearing: 27,
                            center: [-0.15591514, 51.51830379],
                            zoom: 15.5,
                            pitch: 20
                            },
                            'aldgate': {
                            duration: 6000,
                            center: [-0.07571203, 51.51424049],
                            bearing: 150,
                            zoom: 15,
                            pitch: 0
                            },
                            'london-bridge': {
                            bearing: 90,
                            center: [-0.08533793, 51.50438536],
                            zoom: 13,
                            speed: 0.6,
                            pitch: 40
                            },
                            'woolwich': {
                            bearing: 90,
                            center: [0.05991101, 51.48752939],
                            zoom: 12.3
                            },
                            'gloucester': {
                            bearing: 45,
                            center: [-0.18335806, 51.49439521],
                            zoom: 15.3,
                            pitch: 20,
                            speed: 0.5
                            },
                            'caulfield-gardens': {
                            bearing: 180,
                            center: [-0.19684993, 51.5033856],
                            zoom: 12.3
                            },
                            'telegraph': {
                            bearing: 90,
                            center: [-0.10669358, 51.51433123],
                            zoom: 17.3,
                            pitch: 40
                            },
                            'charing-cross': {
                            bearing: 90,
                            center: [-0.12416858, 51.50779757],
                            zoom: 14.3,
                            pitch: 20
                            }
                        };
                                
                        let activeChapterName = 'baker';
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
        </section>
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
