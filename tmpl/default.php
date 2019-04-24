<?php
defined('_JEXEC') or die;
$url = JURI::base(true) . '/modules/mod_djmitry_form/index.php';
$id = $module->id;
?>
<div class="d-mod-djmitry-form<?= $params->get('moduleclass_sfx') ?>" data-id="<?= $module->id ?>">
    <div class="d-mod-djmitry-form__inner">
        <div class="d-mod-djmitry-form__message"></div>
        <form action="<?= $url ?>" method="post" enctype="multipart/form-data" class="d-form">
            <input type="hidden" name="task" value="send">
            <input type="hidden" name="module_id" value="<?= $module->id ?>">
            <div class="d-row">
                <div class="d-col">
                    <label for="<?= $id ?>-name">Имя</label>
                    <input type="text" name="data[name]" id="<?= $id ?>-name" placeholder="Имя" class="d-input" required>
                </div>
                <div class="d-col">
                    <label for="<?= $id ?>-email">E-mail</label>
                    <input type="text" name="data[email]" id="<?= $id ?>-email" placeholder="E-mail" class="d-input" required>
                </div>
                <div class="d-col">
                    <label for="<?= $id ?>-phone">Номер телефон</label>
                    <input type="text" name="data[phone]" id="<?= $id ?>-phone" placeholder="Номер телефон" class="d-input" required>
                </div>
                <div class="d-col">
                    <label for="<?= $id ?>-file">Файл</label>
                    <input type="file" name="data[file]" id="<?= $id ?>-file">
                </div>
                <div class="d-col">
                    <label for="<?= $id ?>-message">Сообщение</label>
                    <textarea name="data[message]" id="<?= $id ?>-message" cols="30" rows="10" placeholder="Сообщение" class="d-textarea" required></textarea>
                </div>
                <div class="d-col">
                    <input type="checkbox" name="data[agree]" id="<?= $module->id ?>-data[agree]" value="1" class="d-checkbox">
                        <label class="d-label" for="<?= $module->id ?>-data[agree]">Я согласен</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="d-submit">Отправить</button>
        </form>
    </div>
</div>