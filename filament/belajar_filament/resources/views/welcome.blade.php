<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/resources/css/app.css"> <!-- Ganti dengan path yang sesuai -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css"> <!-- Tambahkan link untuk Tailwind CSS -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <style>
    .menu-transition {
      transition-property: top, opacity;
      transition-duration: 0.5s;
      transition-timing-function: ease-in;
    }

    .school-coding {
      margin-top: 20vh; /* Sesuaikan sesuai kebutuhan */
    }
  </style>
</head>
<body>
  <div class="relative h-screen">
    <img src="https://cdn.pixabay.com/photo/2016/11/14/03/16/book-1822474_1280.jpg" alt="Background Image" class="absolute inset-0 w-full h-full object-cover">

    <div class="absolute inset-0 flex flex-col justify-center items-center text-center">
      <h1 class="text-5xl font-bold text-white school-coding">SCHOOL CODING</h1>
      <p class="text-lg text-gray-400 mt-2">
        Upgrade Skill
        <span class="underline hover:text-gray-200 cursor-pointer">Keep Learning</span>
      </p>
      <button class="mt-8 uppercase bg-slate-200 rounded-full text-gray-900 w-96 md:w-60 h-14 get-started-button">GET STARTED</button>
    </div>

    <div class='md:flex md:justify-between py-4 px-10'>
      <div class="md:ml-8 ml-0 flex justify-between items-center">
        <div class='text-2xl font-bold text-white py-2'>
          School
        </div>
        <span class="text-3xl cursor-pointer mx-2 md:hidden block" onclick="Menu(this)">
          <ion-icon name="menu"></ion-icon>
        </span>
      </div>

      <ul id="navbar" class='md:flex md:items-center z-10 absolute md:static w-full left-0 md:w-auto md:py-0 py-4 md:pl-0 md:opacity-100 opacity-0 top-[-400px] menu-transition bg-slate-200 md:bg-transparent md:text-white'>
        <li class="hover:bg-slate-400 w-26 py-2 px-2 mx-2 rounded-full duration-500">Home</li>
        <li class="hover:bg-slate-400 w-26 py-2 px-2 mx-2 rounded-full duration-500">About</li>
        <li class="hover:bg-slate-400 w-26 py-2 px-2 mx-2 rounded-full duration-500">
          <a href="#register">
            Register
          </a>
        </li>
      </ul>
    </div>
  </div>

  <div class="flex justify-center items-center mb-6 absolute bottom-0 inset-x-0">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 animate-bounce text-white">
      <path fill="currentColor" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
    </svg>
  </div>

  <div class="flex items-center justify-center h-screen bg-gray-300" id="register">
    <div class="bg-white p-8 rounded-lg shadow-lg w-1/2 mt-20">
      <h1 class="text-2xl font-semibold mb-4">Registration</h1>
      @livewire('home')
    </div>
  </div>

  <script>
    function Menu(e) {
      let list = document.querySelector('ul');
      e.querySelector('ion-icon').name === 'menu' ? (e.querySelector('ion-icon').name = "close", list.classList.add('top-[80px]'), list.classList.add('opacity-100')) : (e.querySelector('ion-icon').name = "menu", list.classList.remove('top-[80px]'), list.classList.remove('opacity-100'))
    }

    // register click
    const navbarLinks = document.querySelectorAll("#navbar li");
    navbarLinks.forEach((li) => {
      li.addEventListener("click", (e) => {
        e.preventDefault();

        const link = li.querySelector("a");
          const targetId = link.getAttribute("href").substring(1); Mengambil ID target
          console.log(targetId);
          const targetSection = document.getElementById(targetId);

          if (targetSection) {
            const yOffset = targetSection.getBoundingClientRect().top;
            window.scrollBy({
              top: yOffset,
              behavior: 'smooth' // Menambahkan efek animasi
            });
          }
      });
    })
  </script>
</body>
</html>
