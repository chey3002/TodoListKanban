<?php
if (isset($_SESSION['user_type'])) {
      $user_type = $_SESSION['user_type'];
    if ($user_type == 1) {

  echo '
<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">TDL</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor01">
       <ul class="navbar-nav me-auto">
       <li class="nav-item">
          <a class="nav-link " href="crudUsuarios.php">Usuarios
            
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="crudTableros.php">Tableros</a>
        </li>
      </ul>
      <div  class="d-flex">
        <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <form action="../controlador/logout.php" method="POST">
          <button class="nav-link"  type="submit">LogOut</button>
          </form>
        </li>
        </ul>
    </div>
    </div>
  </div>
</nav>';}else{
  echo '
<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">TDL</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor01">
       <ul class="navbar-nav me-auto">
       
      </ul>
      <div  class="d-flex">
        <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <form action="../controlador/logout.php" method="POST">
          <button class="nav-link"  type="submit">LogOut</button>
          </form>
        </li>
        </ul>
    </div>
    </div>
  </div>
</nav>';
}
}else{
  echo '
<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">TDL</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor01">
       <ul class="navbar-nav me-auto">
      <!--  <li class="nav-item">
          <a class="nav-link active" href="#">Home
            <span class="visually-hidden">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Features</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Separated link</a>
          </div>
        </li> -->
      </ul>
      <div  class="d-flex">
        <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="/vista/login.html">Login
            <span class="visually-hidden"></span>
          </a>
        </li>
        </ul>
    </div>
    </div>
  </div>
</nav>';
}

?>