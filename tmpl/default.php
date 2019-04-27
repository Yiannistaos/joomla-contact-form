<?php
defined('_JEXEC') or die;
$url = JURI::base(true) . '/modules/mod_djmitry_form/index.php';
$id = $module->id;
?>
<a href="#" class="d-show-djmitry-form" data-target="<?= $module->id ?>">Отправить заявку</a>
<div class="d-mod-djmitry-form<?= $params->get('moduleclass_sfx') ?> d-modal d-open1" data-id="<?= $module->id ?>">
    <div class="d-mod-djmitry-form__inner">
        <div class="d-mod-djmitry-form__header"><h2><?= $params->get('title') ?></h2></div>
        <div class="d-mod-djmitry-form__body">
            <div class="d-mod-djmitry-form__message"></div>
            <form action="<?= $url ?>" method="post" enctype="multipart/form-data" class="d-form">
                <input type="hidden" name="task" value="send">
                <input type="hidden" name="module_id" value="<?= $module->id ?>">
                <div class="d-row">
                    <div class="d-group">
                        <label for="<?= $id ?>-name" class="d-label">Имя</label>
                        <input type="text" name="data[name]" id="<?= $id ?>-name" placeholder="Имя" class="d-input" required>
                    </div>
                    <div class="d-group">
                        <label for="<?= $id ?>-email" class="d-label">E-mail</label>
                        <input type="text" name="data[email]" id="<?= $id ?>-email" placeholder="E-mail" class="d-input" required>
                    </div>
                    <div class="d-group">
                        <label for="<?= $id ?>-phone" class="d-label">Номер телефон</label>
                        <input type="text" name="data[phone]" id="<?= $id ?>-phone" placeholder="Номер телефон" class="d-input" required>
                    </div>
                    <div class="d-group">
                        <label for="<?= $id ?>-file" class="d-label">Файл</label>
                        <div class="d-file">
                            <input type="file" name="data[file]" id="<?= $id ?>-file">
                        </div>
                    </div>
                    <div class="d-group">
                        <label for="<?= $id ?>-message" class="d-label">Сообщение</label>
                        <textarea name="data[message]" id="<?= $id ?>-message" cols="30" rows="10" placeholder="Сообщение" class="d-textarea" required></textarea>
                    </div>
                    <div class="d-group">
                        <div class="d-checkbox">
                            <input type="checkbox" name="data[agree]" id="<?= $module->id ?>-data[agree]" value="1" class="d-checkbox__input" required>
                            <label for="<?= $module->id ?>-data[agree]" class="d-label d-checkbox__label">Я согласен</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="d-submit">Отправить</button>
            </form>
        </div>
    </div>
</div>