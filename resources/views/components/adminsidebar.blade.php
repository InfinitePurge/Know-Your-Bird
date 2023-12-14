<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="{{ asset('manocss/adminsidebar.css') }}" rel="stylesheet">
    <script src="{{ asset('jasonas/adminpanel.js') }}"></script>
    
</head>

<body>
  <div class="sidebar close">
    <div class="logo-details">
      <i class='bx bx-shield-alt-2'></i>
      <span class="logo_name">Admin</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="/">
          <i class='bx bx-home' ></i>
          <span class="link_name">Home</span>
        </a>
      </li>
      <li>
        <a href="/adminpanel">
          <i class='bx bx-user' ></i>
          <span class="link_name">Manage Users</span>
        </a>
    </li>
      <li>
        <a href="/tagview">
          <i class='bx bx-purchase-tag' ></i>
          <span class="link_name">Manage Tags</span>
        </a>
    </li>
    <li>
        <a href="">
          <i class='bx bx-question-mark'></i>
          <span class="link_name">Manage Quiz</span>
        </a>
    </li>

    
  </li>
</ul>
  </div>
  <div class="home-content">
        <i class='bx bx-menu'></i>
    </div>
  <script>
  let arrow = document.querySelectorAll(".arrow");
  for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e)=>{
   let arrowParent = e.target.parentElement.parentElement;
   arrowParent.classList.toggle("showMenu");
    });
  }
  let sidebar = document.querySelector(".sidebar");
  let sidebarBtn = document.querySelector(".bx-menu");
  sidebarBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("close");
  });
  </script>
</body>
</html>
