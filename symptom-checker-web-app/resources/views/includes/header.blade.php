<script>
  const base_path = "http://127.0.0.1:8000";
</script>

<!-- As a heading -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container py-2">
    <a class="navbar-brand fw-bold" href="#">Symptom Checker</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
      <div></div>
      <ul class="navbar-nav">

        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/about">About</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/symptom-checker">Symptom Checker</a>
        </li>
      </ul>

      <div class="gx-2 ">
        @auth
        <form action="{{ route('auth.logout') }}" method="post">
          @if(auth()->user()->role == "patient")
            <a type="button" class="btn primary-button" href="{{ route('patient.dashboard') }}">My Account</a>
          @elseif(auth()->user()->role == "facility")
            <a type="button" class="btn primary-button" href="{{ route('healthcare-facility.dashboard') }}">My Account</a>
          @endif
          
          @csrf
          <button type="submit" class="btn danger-button">Logout</button>
        </form>
        @endauth

        @guest
          <a type="button" class="btn primary-outline-button" href="/login">Login</a>
          <a type="button" class="btn primary-button" href="/register">Register</a>
        @endguest
      </div>
    </div>
  </div>
</nav>