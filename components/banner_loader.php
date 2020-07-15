<?php
    // $dirname = "Banners/";
    // $images = glob($dirname."*");
    // foreach($images as $image) {
    //     echo '
    //     <div class="slideshow-container">
    //         <div style="width:100%;background-color:#eee;text-align:center;" class="mySlides">
    //             <img src="'.$image.'" style="object-align:center;object-fit:cover;width:1200px;height:350px;">
    //         </div>
    //     </div>';
    // }
?>
<!-- <br> -->
<!-- <div style="text-align:center"> -->
    <?php
        // $dirname = "Banners/";
        // $images = glob($dirname."*");
        // foreach($images as $image) {
        //     echo '<span class="dot"></span> ';
        // }
    ?>

    <!-- <script>
        var slideIndex = 0;
        showSlides();

        function showSlides() {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";  
            }
            slideIndex++;
            if (slideIndex > slides.length) {slideIndex = 1}    
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";  
            dots[slideIndex-1].className += " active";
            setTimeout(showSlides, 5000); // Change image every 2 seconds
        }
    </script> -->
<!-- </div> -->

<?php
    $dirname = "Banners/";
    $images = glob($dirname."*");
?>

<div id="carousel" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
      <?php
        for($i = 0; $i < count($images); $i++) {
            if ($i == 0) {
               echo '<li data-target="#carousel" data-slide-to="0" class="active"></li>';
            } else {
                echo '<li data-target="#carousel" data-slide-to="'.$i.'"></li>';
            }
        }
      ?>
  </ol>
  <div class="carousel-inner">

    <?php
      for($i = 0; $i < count($images); $i++) {
          if ($i == 0) {
            echo '  <div class="carousel-item active">
                        <img style="height:350px;" class="d-block w-100" src="'.$images[$i].'" alt="First slide">
                    </div>';
          } else {
            echo '  <div class="carousel-item">
                        <img style="height:350px;" class="d-block w-100" src="'.$images[$i].'" alt="Second slide">
                    </div>';
          }
      }
    ?>
  </div>
  <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>