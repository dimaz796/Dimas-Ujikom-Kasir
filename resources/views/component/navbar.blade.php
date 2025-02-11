<nav class="flex items-center justify-between py-2 ">
  <div class="flex w-full justify-between px-20">

  <a href="#" class="flex items-center text-blue-700 hover:text-neutral-900 no-underline fw-semibold">
    Samquik
    </a>

    <ul class="flex space-x-6 ml-auto mt-3">
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


      </li>
    </ul>


  </div>
</nav>
