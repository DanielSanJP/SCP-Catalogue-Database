<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCP Foundation Catalog</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/catalogue.css">
    <link rel="shortcut icon" href="./images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap">
</head>

<body>

    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ?>

    <div id="header"></div>

    <div class="main">

        <div class="intro">
            <h1>Welcome to the SCP Foundation Catalog</h1>
            <p>Your source for secure, contain, protect information. The Foundation is an international secret
                society, consisting of a scientific research institution with a paramilitary intelligence agency to
                support their goals. Despite its secretive premise, the Foundation is entrusted by governments
                around the world to capture and contain various unexplained phenomena that defy the known laws of
                nature (referred to as "anomalies", "SCP objects", "SCPs", or colloquially "skips"). They include
                living beings and creatures, artifacts and objects, locations and places, abstract concepts, and
                incomprehensible entities which display supernatural abilities or other extremely unusual
                properties. If left uncontained, many of the more dangerous anomalies will pose a serious threat to
                humans or even all life on Earth. Their existence is hidden and withheld from the general public in
                order to prevent mass hysteria, and allow human civilization to continue functioning normally.</p>
        </div>

        <div class="scp-catalog" id="#catalog">
            <?php
            include 'connection.php'; // Ensure the database connection

            $query = "SELECT id, item, name, containment, summary, image FROM scp_catalogue";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <!-- Dynamic SCP Card -->
                    <a href="scp-page.php?id=<?php echo $row['id']; ?>" class="scp-card">
                        <div class="cardTitle">
                            <h1><?php echo htmlspecialchars($row['item']); ?></h1>
                            <div class="cardContainment">
                                <img class="cLevel" src="./images/<?php echo htmlspecialchars($row['containment']); ?>.png" alt="">
                            </div>
                        </div>
                        <div class="cardImg">
                            <img src="data:image/webp;base64,<?php echo base64_encode($row['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($row['name']); ?>">
                            <div class="cardName">
                                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                            </div>
                        </div>
                        <div class="cardDesc">
                            <p><?php echo htmlspecialchars($row['summary']); ?></p>
                            <div class="cardStats">
                                <div class="StatColumn"><?php echo htmlspecialchars($row['item']); ?></div>
                                <div class="StatColumn"><?php echo htmlspecialchars($row['containment']); ?></div>
                            </div>
                        </div>
                    </a>
            <?php
                }
            } else {
                echo "<p>No SCP items found in the database.</p>";
            }

            $conn->close(); // Close the connection
            ?>
        </div>
    </div>

    <script type="module">
        import { headerTemplate } from './scripts/header.js';
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('header').innerHTML = headerTemplate;
            const burger = document.querySelector('.burger');
            const navLinks = document.querySelector('.nav-links');

            burger.addEventListener('click', () => {
                navLinks.classList.toggle('active');
                burger.classList.toggle('toggle');
            });
        });
    </script>

    <script type="module">
        import { footerTemplate } from './scripts/footer.js';
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('footer').innerHTML = footerTemplate;
        });
    </script>

    <footer id="footer"></footer>

</body>
</html>
