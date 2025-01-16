<nav class="flex items-center justify-between py-2 ">
  <div class="flex w-full justify-between px-20">

  <a href="#" class="flex items-center text-blue-700 hover:text-neutral-900 no-underline font-semibold">
    Samquik
    </a>

    <ul class="flex space-x-6 ml-auto mt-3">
      <li><a href="" class="text-black/60 hover:text-black/80 font-semibold no-underline">Beranda</a></li>
      <li><a href="{{ route('produk') }}" class="text-black/60 hover:text-black/80 font-semibold no-underline">Data Produk</a></li>
      <li><a href="{{ route('user') }}" class="text-black/60 hover:text-black/80 font-semibold no-underline">Data user</a></li>
      <li><a href="{{ route('logout') }}" class="text-black/60 hover:text-black/80 font-semibold no-underline">Logout</a></li>
     
      <!-- <li class="relative group">
        <a href="#" class="flex items-center rounded-full border-blue-100">
          <img src="{{ asset('storage/component/profil.jpg') }}" alt="User Avatar" class="rounded-full w-8 h-8" />
        </a>

        <ul class="absolute right-0 mt-2 w-48 bg-white text-neutral-700 rounded-lg shadow-lg hidden group-hover:block dark:bg-surface-dark">
          <li><a href="{{ route('logout') }}" class="block px-4 py-2 text-sm no-underline text-black">Log Out</a></li>
        </ul>
      </li> -->
 
        
      </li>
    </ul>


  </div>
</nav>
