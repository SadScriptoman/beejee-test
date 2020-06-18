<?$buffer = new Buffer();
$application = $this->application;
$user = $application->getUser();
$logged = $application->logged();
?>
<!doctype html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/bootstrap.min.css" >
    <link rel="stylesheet" href="css/custom.css" >

    <title><?$buffer->show('title');?></title>
  </head>
  <body>
    <div class="nav-scroller bg-white shadow-sm">
      <nav class="nav nav-underline">
        <a class="nav-link" href="/">Задачи</a>
        <?if(!$logged):?>
          <a class="nav-link" href="user">Войти</a>
        <?else:?>
          <a class="nav-link" href="user?logout=1">Выйти</a>
        <?endif;?>
      </nav>
    </div>

    <?include 'app/views/'.$contentView;?>

    <script src="js/jquery-3.5.1.min.js" ></script>
    <script src="js/bootstrap.bundle.min.js" ></script>
    <script src="js/custom.js" ></script>
  </body>
</html>