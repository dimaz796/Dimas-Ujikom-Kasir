<div class="md:px-5">
  <nav class="flex items-center justify-between py-2">
    <div class="flex w-full justify-between px-4 md:px-20">

      <a href="#" class="flex items-center text-blue-700 hover:text-neutral-900 no-underline font-semibold">
        Samquik
      </a>

      <!-- Hamburger Icon for small screens -->
      <div class="block md:hidden">
        <button id="hamburger" class="text-black/60 hover:text-black/80">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>

      <!-- Navigation Links -->
      <ul id="navLinks" class="flex space-x-6 ml-auto mt-3 hidden md:flex">
        <li><a href="{{ route('home') }}" class="text-black/60 hover:text-black/80 font-semibold no-underline">Beranda</a></li>
        <li><a href="{{ route('produk') }}" class="text-black/60 hover:text-black/80 font-semibold no-underline">Data Produk</a></li>
        @auth
          @if (auth()->user()->role === "petugas")
            <li><a href="{{ route('riwayat_transaksi') }}" class="text-black/60 hover:text-black/80 font-semibold no-underline">Riwayat Transaksi</a></li>
          @endif
        @endauth
        @auth
          @if (auth()->user()->role === "admin")
            <li><a href="{{ route('user') }}" class="text-black/60 hover:text-black/80 font-semibold no-underline">Data user</a></li>
            <li><a href="{{ route('transaksi') }}" class="text-black/60 hover:text-black/80 font-semibold no-underline">Data Transaksi</a></li>
          @endif
        @endauth
        <li><a href="{{ route('logout') }}" class="text-black/60 hover:text-black/80 font-semibold no-underline">Logout</a></li>
      </ul>
    </div>
  </nav>

  <!-- Dropdown menu for mobile view -->
  <div id="mobileMenu" class="absolute top-16 left-0 w-full bg-white shadow-lg md:hidden hidden">
    <ul class="space-y-4 p-4">
      <li><a href="{{ route('home') }}" class="block text-black/60 hover:text-black/80 font-semibold">Beranda</a></li>
      <li><a href="{{ route('produk') }}" class="block text-black/60 hover:text-black/80 font-semibold">Data Produk</a></li>
      @auth
        @if (auth()->user()->role === "petugas")
          <li><a href="{{ route('riwayat_transaksi') }}" class="block text-black/60 hover:text-black/80 font-semibold">Riwayat Transaksi</a></li>
        @endif
      @endauth
      @auth
        @if (auth()->user()->role === "admin")
          <li><a href="{{ route('user') }}" class="block text-black/60 hover:text-black/80 font-semibold">Data user</a></li>
          <li><a href="{{ route('transaksi') }}" class="block text-black/60 hover:text-black/80 font-semibold">Data Transaksi</a></li>
        @endif
      @endauth
      <li><a href="{{ route('logout') }}" class="block text-black/60 hover:text-black/80 font-semibold">Logout</a></li>
    </ul>
  </div>

</div>


  <!-- JavaScript for toggling the menu -->
  <script>
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');

    hamburger.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  </script>
