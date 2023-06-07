<!DOCTYPE html>
<html lang="nl"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BEFS</title>
    <link rel="stylesheet" href="./style.css">  
</head>
<body>
    <?php
    include_once "./includes/nav.php";
    ?>
    <main class="indexhome">
        <div class="indextext">
            <h1>Every purchase will be made with bread</h1>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Illo quas recusandae, quaerat amet ad error
                aliquid laboriosam porro nam officiis sequi suscipit explicabo soluta sit labore.</p>
            <div class="container">
                <input type="text" class="email-input" placeholder="What are you looking for?">
                <a href="./normal.php"><button type="submit" class="submit-button">Submit</button></a>
            </div>
        </div>
        <div id="slideshow">
            <img src="./images/bread01.jpg" class="active">
            <img src="./images/bread02.jpg">
            <img src="./images/bread03.jpg">
        </div>
    </main>
    <script>
        const slideshow = document.getElementById("slideshow");
        const images = slideshow.getElementsByTagName("img");
        let currentImageIndex = 0;

        function slide() {
            images[currentImageIndex].classList.remove("active");
            currentImageIndex = (currentImageIndex + 1) % images.length;
            images[currentImageIndex].classList.add("active");
        }

        setInterval(slide, 3000);
    </script>
</body>
</html>
	
