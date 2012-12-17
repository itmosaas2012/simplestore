
<?php if (@$view['message_error']): ?></a><div class="message error"><?=$view['message_error']?></div><?php endif; ?>
<?php if (@$view['message_success']): ?></a><div class="message success"><?=$view['message_success']?></div><?php endif; ?>

<?php if ($view['items']): ?>
<form action="/SettingsTest" method="post">
    <input type="hidden" name="form" value="request_items">
	
	<h2>Настройки аккаунта:</h2>
	
    <div class="form-div">
        <label class="form-label" for="familyName"> Логин: </label>
        <input class="form-input" type="text" name="familyName" id="familyName" disabled="true" value="<?php echo $_SESSION['login']?>"/>
    </div>

    <div class="form-div">
        <label class="form-label" for="familyName"> Фамилия: </label>
        <input class="form-input" type="text" name="familyName" id="familyName" value="<?=$item->surname?>"/>
    </div>

    <div class="form-div">
        <label class="form-label" for="givenName"> Имя: </label>
        <input class="form-input" type="text" name="givenName" id="givenName" value="<?=$item->name?>"/>
    </div>

    <div class="form-div">
        <label class="form-label" for="phone"> Номер телефона: </label>
        <input class="form-input" type="text" name="phone" id="phone" value="<?=$item->tell?>"/>
    </div>

    <div class="form-div">
        <label class="form-label" for="email"> Электронная почта: </label>
        <input class="form-input" type="email" name="email" id="email" value="<?=$item->email?>"/>
    </div>


    <div class="form-div">
        <label class="form-label" for="password"> Пароль: </label>
        <input class="form-input" type="password" name="password" id="password" value="<?=$item->password?>"/>
    </div>
	
    <div class="form-div">
        <label class="form-label" for="password2"> Пароль: </label>
        <input class="form-input" type="password" name="password2" id="password2" value="<?=$item->password?>"/>
    </div>
	
    <div class="form-btn">
        <button class="btn btn-primary btn-small" type="submit">Сохранить изменения</button>
    </div>
</form>
<?php endif; ?>