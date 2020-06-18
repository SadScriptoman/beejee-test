<?$buffer->set('title', 'Вход');?>

<?if(!$logged):?>
  <section class="sign-in">
    <form action='' method='POST' class="sign-in__form">
      <h1 class="h3 mb-3 font-weight-normal">Войдите</h1>

      <label for="login" class="sr-only">Логин</label>
      <input type="login" id="login" name="login" class="form-control" placeholder="" required="" autofocus="">
      <label for="password" class="sr-only">Пароль</label>
      <input type="password" id="password" name="password" class="form-control" placeholder="" required="">
      <button class="btn btn-lg btn-primary btn-block mt-3" type="submit">Войти</button>
      <?if(isset($data['errorMessage'])):?>
        <p class="mt-3 mb-3 text-danger text-center">
          <?=$data['errorMessage']?>
        </p>
      <?endif;?>
    </form>
  </section>
<?elseif(!isset($_GET['logout'])):
  header('Location: error404');
endif;?>