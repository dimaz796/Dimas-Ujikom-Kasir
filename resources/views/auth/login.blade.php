@vite('resources/css/app.css')

@if(session('message'))
    <script>
        alert("{{ session('message') }}");
    </script>
@endif
<!-- component -->
<!-- Container -->
<div class="flex flex-wrap min-h-screen w-full content-center justify-center bg-blue-50 py-10">
  
  <!-- Login component -->
  <div class="flex shadow-md">
    <!-- Login form -->
    <div class="flex flex-wrap content-center justify-center rounded-l-md bg-white" style="width: 24rem; height: 32rem;">
      <div class="w-72">
        <!-- Heading -->
        <h1 class="text-xl font-semibold">Samquik</h1>
        <small class="text-gray-400">Silahkan Login</small>

        @if (session('error'))
        <div class="bg-red-600 text-white text-sm font-semibold p-2 rounded-lg shadow-md mb-4">
            <p>{{ session('error') }}</p>
        </div>
        @endif
        <!-- Form -->
        <form class="mt-4" method="POST" action="{{ route('cekLogin') }}">
            @csrf
          <div class="mb-3">
            <label class="mb-2 block text-xs font-semibold">Email</label>
            <input type="email" placeholder="Masukan Email Anda" name="email" required class="block w-full rounded-md border border-gray-300 focus:border-blue-700 focus:outline-none focus:ring-1 focus:ring-blue-700 py-1 px-1.5 text-gray-500" />
          </div>

          <div class="mb-3">
            <label class="mb-2 block text-xs font-semibold">Password</label>
            <input type="password" placeholder="*****" name="password" required class="block w-full rounded-md border border-gray-300 focus:border-blue-700 focus:outline-none focus:ring-1 focus:ring-blue-700 py-1 px-1.5 text-gray-500" />
          </div>

          <div class="mb-3">
            <button type="submit" class="mb-1.5 block w-full text-center text-white bg-blue-700  hover:bg-blue-900 px-2 py-1.5 rounded-md"><p class="font-semibold">Sign in</p></button>
          </div>
        </form>
      </div>
    </div>

    <!-- Login banner -->
    <div class="flex flex-wrap content-center justify-center rounded-r-md" style="width: 24rem; height: 32rem;">
      <img class="w-full h-full bg-center bg-no-repeat bg-cover rounded-r-md" src="{{ asset('storage/component/login2.jpg') }}">
    </div>

  </div>
</div>