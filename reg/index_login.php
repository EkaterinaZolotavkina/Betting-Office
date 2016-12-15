<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    
    <link rel="stylesheet" href="reg/css/normalize.css">
    <link rel="stylesheet" href="reg/css/style.css">   
  </head>

  <body>

    <div class="form">
      
      <div class="tab-content">
        <div id="signup">   
          <h1>Авторизация</h1>
          
          <form action="login.php" method="post">
      
          <div class="field-wrap">
            <input type="text" name="uname" required autocomplete="off" placeholder="Логин"/>
          </div>

          <div class="field-wrap">
            <input type="password" name="pass" required autocomplete="off" placeholder="Пароль"/>
          </div>
          
          <button type="submit" name="btn-login" class="button button-block"/>Войти</button>
          
          </form>

        </div>
        <div id="login">  
        </div>
        
      </div><!-- tab-content -->
      
</div> <!-- /form -->
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

        <script src="http://postgres/reg/js/index.js"></script>
  </body>
</html>