<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<div class="carousel w-full lg:h-[400px] bg-no-repeat bg-cover bg-left my-5"
      style="background-image: url(images/backdrop-green-leaves.jpg);">
      <!-- slide 01 -->
      <div id="slide1" class="carousel-item relative w-full">
        <div class="flex flex-col lg:flex-row gap-80 p-4 lg:py-6 px-24">
          <div class="space-y-7 flex-1 pl-20">
            <h2 class="text-2xl lg:text-6xl font-bold text-yellow-200	">
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
          <a href="#slide4" class="btn btn-circle">❮</a>
          <a href="#slide2" class="btn btn-circle">❯</a>
        </div>
      </div>
      <!-- slide 02 -->
      <div id="slide2" class="carousel-item relative w-full">
        <div class="flex flex-col lg:flex-row gap-80 p-4 lg:py-6 px-24">
          <div class="space-y-7 flex-1 pl-20">
            <h2 class="text-2xl lg:text-6xl font-bold text-yellow-200	">
              Croton Petra
              <br>
              "House Plant"
            </h2>
            <p class="text-white">Meet the Croton Petra: Bursting with vibrant colors, this tropical plant adds flair to
              any space. Easy to care for and air-purifying, it's the perfect statement piece for your home or office.
            </p>
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
            <h2 class="text-2xl lg:text-6xl font-bold text-yellow-200	">
              Haworthia
              <br>
              Cooperi
            </h2>
            <p class="text-white">Enjoy a 10% discount today and bring home this delightful beauty. With its charming
              rosette shape and translucent leaves, the Haworthia Cooperi adds a touch of elegance to any collection.

              Use code "GREEN10" at checkout to claim your discount. Don't miss out on this limited-time offer!</p>
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
      <!-- slide 04 -->
      <div id="slide4" class="carousel-item relative w-full">
        <div class="flex flex-col lg:flex-row gap-80 p-4 lg:py-6 px-24">
          <div class="space-y-7 flex-1 pl-20">
            <h2 class="text-2xl lg:text-5xl font-bold text-yellow-200	">
              Chrysanthemum
              <br>
              "Best Seller"
            </h2>
            <p class="text-white">These vibrant flowers symbolize joy and longevity, adding a burst of color to any
              space. Easy to care for and versatile, they thrive in sunlight and well-draining soil. Perfect for autumn
              bouquets or garden beds, Chrysanthemums bring seasonal charm wherever they bloom.</p>
            <button class="btn btn-outline btn-primary">Purchase</button>
          </div>
          <div class="flex-1">
            <img src="images/Chrysanthemum.png" class="h-[350px]" />
          </div>
        </div>
        <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
          <a href="#slide3" class="btn btn-circle">❮</a>
          <a href="#slide1" class="btn btn-circle">❯</a>
        </div>
      </div>
    </div>