
<?$buffer->set('title', 'Задачи');?>

<header>
    <h1 class='text-center mt-5 mb-5'>ToDo application</h1>
</header>

<section class="container">

    <div class="d-flex justify-content-end">
        <form action='' method="POST" class="form-inline mb-5">
            <input class="form-control mr-sm-2" type="search" placeholder="" aria-label="">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Найти</button>
        </form>
    </div>
    
    <div >
        <form action='' method="POST" class="needs-validation mb-5" novalidate>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="name">Ваше имя<abbr>*</abbr></label>
                    <input type="text" class="form-control" name='name' id="name" required>
                    <div class="invalid-feedback">
                        Введите имя!
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Email<abbr>*</abbr></label>
                    <input type="email" class="form-control" name='email' id="email" required>
                    <div class="invalid-feedback">
                        Введите email!
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="text">Текст</label>
                <textarea class="form-control" name='text' id="text" rows="3" required></textarea>
                <div class="invalid-feedback">
                   Не должно быть пустым!
                </div>
            </div>
            <button class="btn btn-success my-2 mr-2 my-sm-0" type="submit">Отправить</button>
            <button class="btn btn-outline-danger my-2 my-sm-0" type="reset">Сбросить</button>
        </form>
    </div>

    <?foreach($data['items'] as $key => $dataItem):?>
        <div id='card<?=$key?>' class="card todo <?if (($dataItem['state'] == 2) || ($dataItem['state'] == 3)):?>todo--edited<?endif;?> <?if (($dataItem['state'] == 1)):?>todo--done<?endif;?> mb-5" >
            <div class="card-body">
                <h5 class="card-title"><?=$dataItem['name']?></h5>
                <a href='mailto:<?=$dataItem['email']?>' class="card-subtitle text-muted d-block mb-2 text-decoration-none"><?=$dataItem['email']?></a>
                <p class="card-text"><?=$dataItem['text']?></p>
                <span class="todo__state todo__state--not-done text-success">В работе!</span>
                <span class="todo__state todo__state--done">Сделано!</span>
                <span class="todo__state todo__state--edited text-muted">Отредактированно</span>
                <a href="#" class="todo__tools text-dark" data-action='addClass' data-class='todo--edit' data-target='#card1'>Редактировать</a>
                <a href="#" class="todo__tools text-dark">Удалить</a>
            </div>
        </div>
    <?endforeach;?>
    <nav aria-label="Page navigation example" class='d-flex justify-content-center'>
      <ul class="pagination">
        <li class="page-item disabled"><a class="page-link" href="#">Пред</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item active"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">След</a></li>
      </ul>
    </nav>
</section>