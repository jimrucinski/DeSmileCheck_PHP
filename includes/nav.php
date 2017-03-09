<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/">Smile Check Delaware</a>
    </div>
    <ul class="nav navbar-nav">
      <?php
    foreach($navItems as $item){
        echo "<li><a href=\"$item[0]\">$item[1]</a></li>";
    }
?>
    </ul>
  </div>
</nav>
