<div class="navbar navbar-inverse">
        <h3>Banner Here</h3>
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
            <ul class="nav navbar-nav">
               <?php
                  foreach($navItems as $item){
                      echo "<li><a href=\"$item[0]\">$item[1]</a></li>";
                  }
              ?>
                <!--
                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                    <li class="divider"></li>
                    <li><a href="#">One more separated link</a></li>
                </ul>
                </li>
                -->
            </ul>
             
            <!--
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Link</a></li>
            </ul>
            -->
            </div>
        </div> 
        <?php
            if($errorMsg!='')
                echo"<div id='ErrorBox'><strong>{$errorMsg}</strong></div>";
        ?>
    </div>



