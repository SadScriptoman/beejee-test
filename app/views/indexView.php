
<?$buffer->set('title', 'Задачи');?>

<header>
    <h1 class='text-center mt-5 mb-5'>ToDo application</h1>
</header>

<section class="container">
    <div class="d-flex justify-content-end">
        <form action='' method="POST" class="form-inline mb-5">
            <input class="form-control mr-sm-2" type="search" value="<?=$data['search']?>" name='search' aria-label="">
            <button class="btn btn-outline-success my-2 mr-2 my-sm-0" type="submit">Найти</button>
            
        </form>
        <?if($data['search']):?>
            <form action='' method="POST" class="form-inline mb-5">
                <input type="hidden" name="search">
                <button class="btn btn-outline-danger my-2 mr-2 my-sm-0" type="submit">Сбросить</button>
            </form>
        <?endif;?>
    </div>
    <div id='main-form'>
        <form action='' method="POST" class="needs-validation mb-5" novalidate>
            <input type="hidden" id='id' name="id" value='0'>
            <input type="hidden" id="action" name='action' value='add/edit'>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="name">Ваше имя<abbr>*</abbr></label>
                    <input type="text" class="form-control" value='' name='name' id="name" required>
                    <div class="invalid-feedback">
                        Введите имя!
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Email<abbr>*</abbr></label>
                    <input type="email" class="form-control" name='email' value='' id="email" required>
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
        </form>
    </div>

    
    <?
    $countItems = count($data['items']);
    if((count($data['items'])>0)):
        foreach($data['items'] as $key => $dataItem):?>
            <div id='card<?=$key?>' class="card todo <?if ($dataItem['dateEdited']):?>todo--edited<?endif;?> <?if (($dataItem['completed'] == 1)):?>todo--done<?endif;?> mb-5" >
                <div class="card-body">
                    <h5 class="card-title d-block mb-0"><?=$dataItem['name']?></h5>
                    <a href='mailto:<?=$dataItem['email']?>' class="card-subtitle text-muted mb-2 d-inline-block text-decoration-none"><?=$dataItem['email']?></a>
                    <p class="card-text"><?=$dataItem['text']?></p>
                    <span class="todo__state todo__state--not-done text-success">В работе!</span>
                    <span class="todo__state todo__state--done">Сделано!</span>
                    <span class="todo__state todo__state--edited text-muted">Отредактированно</span>
                    <?if($logged):?>
                        <button type="button" class="todo__tool" data-toggle="modal" data-target="#switchModal" data-id="<?=$dataItem['id']?>" data-name='<?=$dataItem['name']?>'>Сменить состояние</button>
                        <button type="button" class="todo__tool edit-button" data-target="#main-form" data-id="<?=$dataItem['id']?>" data-name='<?=$dataItem['name']?>' data-email='<?=$dataItem['email']?>' data-text='<?=$dataItem['text']?>'>Редактировать</button>
                        <button type="button" class="todo__tool" data-toggle="modal" data-target="#deleteModal" data-id="<?=$dataItem['id']?>" data-name='<?=$dataItem['name']?>'>Удалить</button>
                    <?endif;?>
                </div>
            </div>
        <?endforeach;?>
        <?if (($data['pages'] > 1 && $data['search'] == '') || ($data['search'] && $data['pages'] > 1)):?>
            <nav aria-label="Page navigation" class='d-flex justify-content-center'>
                <ul class="pagination">
                    <?
                    $pageStart = 1;
                    $pageLast = 3;
                    $showArrows = false;
                    if($data['pages']>3){
                        $showArrows = true;
                        $showRightDots = true;
                        if($data['page']>1){
                            if(($data['page']+1) <= $data['pages']){
                                $pageStart = $data['page']-1;
                                $pageLast = $data['page']+1;
                            }else{
                                $pageStart = $data['page']-2;
                                $pageLast = $data['page'];
                            }
                        }
                    }?>
                    <?if($showArrows):?>
                        <li class="page-item <?if(($data['page']) == 1):?>disabled<?endif;?>"><a class="page-link" href="index?page=1">«</a></li>
                    <?endif;?>
                    <?for ($page = $pageStart; $page <= $pageLast; $page++):?>
                        <li class="page-item <?if($data['page'] == $page):?>active<?endif;?>"><a class="page-link" href="index?page=<?=$page?>"><?=$page?></a></li>
                    <?endfor;?>
                    <?if($showArrows):?>
                        <li class="page-item <?if($data['page'] == $data['pages']):?>disabled<?endif;?>"><a class="page-link" href="index?page=<?=$data['pages']?>">»</a></li>
                    <?endif;?>
                </ul>
            </nav>
            <p class='text-center text-muted'>
                всего <?=$data['count']?> эл. на <?=$data['pages']?> стр.
            </p>
        <?endif;
    elseif ($data['search']):?>
        <h3 class='text-center'>
            По запросу '<?=$data['search']?>' не найдено ни одного элемента!
        </h3>
        <form action='' method="POST" class="d-flex justify-content-center mt-3">
            <input type="hidden" name="search">
            <button class="todo__tool" type="submit">Сбросить</button>
        </form>
    <?endif;?>
</section>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" >Подтверждение удаления</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action='' method='POST' novalidate>
            <div class="modal-body">
                <input type="hidden" id="id" name='id' value='0'>
                <input type="hidden" id="action" name='action' value='delete'>
                <p>Вы действительно хотите удалить элемент с именем <span id='name'></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-primary">Подтвердить</button>
            </div>
        </form>
    </div>
  </div>
</div>

<div class="modal fade" id="switchModal" tabindex="-1" role="dialog" aria-labelledby="switchModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" >Подтвердите смену состояния</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action='' method='POST' novalidate>
            <div class="modal-body">
                <input type="hidden" id="id" name='id' value='0'>
                <input type="hidden" id="action" name='action' value='switchStates'>
                <p>Вы действительно хотите сменить состояние элемента с именем <span id='name'></span>?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
              <button type="submit" class="btn btn-primary">Подтвердить</button>
            </div>
        </form>
    </div>
  </div>
</div>
