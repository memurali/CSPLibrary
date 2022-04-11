<!doctype html>
<?php
  echo $this->Html->css("app.css");
  echo $this->Html->css("foundation.css");
  echo $this->Html->script('jquery');
  echo $this->Html->script('what-input');
  echo $this->Html->script('foundation');
  echo $this->Html->script('app');
  
 
  ?>
<html class="no-js" lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSP Library</title>
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/app.css">
  </head>
  <body class="dashboard">
    <div class="grid-container">
      <div class="grid-x">
        <div class="medium-3 cell callout logo-container">
          <h1>CSP Digital Library</h1>
        </div>
        <div class="medium-9 cell nav">
          <div class="grid-x">
            <div class="large-12 cell">
              <div class="title-bar" data-responsive-toggle="responsive-menu" data-hide-for="medium">
                <button class="menu-icon" type="button" data-toggle="responsive-menu"></button>
                <div class="title-bar-title">Menu</div>
              </div>
              <div class="top-bar" id="responsive-menu">
                <div class="top-bar-left">
                  <ul class="dropdown menu" data-dropdown-menu>
                    <li>
                      <a href="/CSPLibrary/users/molecular">Molecular Lab</a>
                     <!-- <ul class="menu">
                        <li><a href="#">Item 1A</a></li>
                        
                      </ul>-->
                    </li>
                    <li>
                      <a href="/CSPLibrary/users/genotype">Genotyping Lab</a>
                      <!--<ul class="menu">
                        <li><a href="#">Item 1A</a></li>
                         ... 
                      </ul>-->
                    </li>
                   <!-- <li><a href="#">Item 2</a></li>
                    <li><a href="#">Item 3</a></li>
                    <li><a href="#">Item 4</a></li>-->
                  </ul>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="grid-x">
        <div class="large-9 cell">
          
        </div>
      </div>
    </div>

    <script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/vendor/foundation.js"></script>
    <script src="js/app.js"></script>

    <script>
      function uncheckAll() {
        $("input[type='checkbox']:checked").prop("checked", false)
      }
      $('.reset').on('click', uncheckAll)
    </script>

  </body>
</html>
