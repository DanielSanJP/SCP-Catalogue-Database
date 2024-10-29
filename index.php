<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCP Foundation Catalog</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="shortcut icon" href="./images/favicon.png" type="image/x-icon">
</head>

<body>
<?php include "connection.php"; ?>


    <!-- HEADER LOCATION -->
    <div id="header"></div>

    <div class="background"></div>

    <div class="container">

        <div class="titlePage">
            <div class="titlePage-text">
                <h1>SCP Foundation Catalogue</h1>
                <p></p>
            </div>
        </div>


            <div class="mainButton"><a class="mainBtn" href="catalogue.php">Enter the Catalogue</a></div>

    </div>

    <!-- FOOTER LOCATION -->
    <div id="footer"></div>

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

</body>

</html>
