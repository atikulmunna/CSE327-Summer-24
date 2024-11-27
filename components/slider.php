<?php
if (isset($message)) {
  foreach ($message as $message) {
    echo '
         <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
  }
}
?>
<style>
  .carousel-item {
    display: none;
  }

  .carousel-item.active {
    display: block;
  }
</style>

<div id="carousel" class="carousel relative w-full" style="background-image: url(images/backdrop-green-leaves.jpg);">
  <!--Slide 01  -->
  <div id="slide1" class="carousel-item relative w-full active">
    <div class="flex flex-col lg:flex-row gap-80 p-4 lg:py-6 px-24">
      <div class="space-y-7 flex-1 pl-20">
        <h2 class="text-2xl lg:text-6xl font-bold text-yellow-200">
          Snake Plant
          <br>
          “Laurentii”
        </h2>
        <p class="text-white">Enjoy a 10% discount on our stunning Snake Plant "Laurentii"! Elevate your space with
              its elegant variegated leaves and air-purifying benefits. Use code "GREEN10" at checkout. Don't miss out,
              offer valid for a limited time only!</p>
        <button class="btn btn-outline btn-primary">Purchase</button>
      </div>
      <div class="flex-1">
      <img src="images/Snake Plant “Laurentii”.png" class="h-[350px]" />
      </div>
    </div>
    <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
      <a href="#slide1" class="btn btn-circle">❮</a>
      <a href="#slide3" class="btn btn-circle">❯</a>
    </div>
  </div>
  <!-- slide 02 -->
  <div id="slide2" class="carousel-item relative w-full active">
    <div class="flex flex-col lg:flex-row gap-80 p-4 lg:py-6 px-24">
      <div class="space-y-7 flex-1 pl-20">
        <h2 class="text-2xl lg:text-6xl font-bold text-yellow-200">
          Croton Petra
          <br>
          "House Plant"
        </h2>
        <p class="text-white">Meet the Croton Petra: Bursting with vibrant colors, this tropical plant adds flair to any
          space. Easy to care for and air-purifying, it's the perfect statement piece for your home or office.</p>
        <button class="btn btn-outline btn-primary">Purchase</button>
      </div>
      <div class="flex-1">
        <img src="images/Croton Petra.png" class="h-[350px]" />
      </div>
    </div>
    <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
      <a href="#slide1" class="btn btn-circle">❮</a>
      <a href="#slide3" class="btn btn-circle">❯</a>
    </div>
  </div>
  <!-- slide 03 -->
  <div id="slide3" class="carousel-item relative w-full">
    <div class="flex flex-col lg:flex-row gap-80 p-4 lg:py-6 px-24">
      <div class="space-y-7 flex-1 pl-20">
        <h2 class="text-2xl lg:text-6xl font-bold text-yellow-200">
          Haworthia
          <br>
        </h2>
        <p class="text-white">Haworthia is a delightful succulent that makes a very attractive small houseplant. It is
          easy to care for and can thrive in a variety of indoor conditions.</p>
        <button class="btn btn-outline btn-primary">Purchase</button>
      </div>
      <div class="flex-1">
      <img src="images/Haworthia-cooperi.png" class="h-[350px]" />
      </div>
    </div>
    <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
      <a href="#slide2" class="btn btn-circle">❮</a>
      <a href="#slide4" class="btn btn-circle">❯</a>
    </div>
  </div>
  <!-- Add more slides as needed -->
</div>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.getElementById('carousel');
    const slides = carousel.getElementsByClassName('carousel-item');
    let currentIndex = 0;

    function showSlide(index) {
      for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove('active');
      }
      slides[index].classList.add('active');
    }

    function nextSlide() {
      currentIndex = (currentIndex + 1) % slides.length;
      showSlide(currentIndex);
    }

    setInterval(nextSlide, 5000); // Change slide every 3 seconds
  });
</script>