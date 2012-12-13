<?php
/**
 * File:        WorkPlaces.php
 * Created by:  Ikarius
 * Date:        11/29/12 at 12:12 AM
 * Last Edit:   11/29/12 at 12:12 AM
 */

    if(isset($view['error']) && $view['error'] != '')
    echo '<div class="message error">'.$view['error'].'</div>';

    if(isset($view['success']) && $view['success'] != '')
    echo '<div class="message success">'.$view['success'].'</div>';?>

<script type="text/javascript">SS.newStaff.init();</script>
<form method="post" action="/Administration/AddUser" class="new-user-form">

    <h2>Ввести новых пользователей:</h2>

    <div class="form-div">
        <label class="form-label" for="surname"> Фамилия: </label>
        <input class="form-input" type="text" name="surname" id="surname" autofocus />
    </div>

    <div class="form-div">
        <label class="form-label" for="name"> Имя: </label>
        <input class="form-input" type="text" name="name" id="name" />
    </div>

    <div class="form-div">
        <label class="form-label" for="patronymic"> Отчество: </label>
        <input class="form-input" type="text" name="patronymic" id="patronymic" />
    </div>

    <div class="form-div">
        <label class="form-label" for="gender"> Пол: </label>
        <div class="brd">
            <input type = 'radio' name ="gender" id="gender" value= 'male'>
            <label class="form-label3" for="male"> М </label>
            <br/>
            <input type = 'radio' name ="gender" id="gender" value= 'female'>
            <label class="form-label3" for="female"> Ж </label>
        </div>
    </div>

    <div class="form-div">
        <label class="form-label" for="workPlace1"> Место работы: </label>
        <select name="workPlace1" id="workPlace1">
            <?php foreach ($view['workPlaces'] as $workPlace)
                echo '<option value="'.$workPlace['id'].'">'.$workPlace['address'].'</option>';
            ?>
        </select>
    </div>

    <div class="form-div">
        <label class="form-label" for="role1"> Должность: </label>
        <select name="role1" id="role1">
            <?php foreach ($view['roles'] as $role)
                echo '<option value="'.$role['id'].'">'.$role['name'].'</option>';
            ?>
        </select>
    </div>

    <div class="form-div">
        <label class="form-label" for="phone"> Номер телефона: </label>
        <input class="form-input" type="text" name="phone" id="phone" />
    </div>

    <div class="form-div">
        <label class="form-label" for="email"> Электронная почта: </label>
        <input class="form-input" type="email" name="email" id="email" />
    </div>
    <div class="form-div">
        <label class="form-label" for="passeportSerie"> Паспортные данные: </label>
        <div class="brd">
            <label class="form-label2" for="passeportSerie"> Серия: </label>
            <input class="form-input2" type="text" name="passeportSerie" id="passeportSerie" />
            <br/>
            <label class="form-label2" for="passeportNumber"> Номер: </label>
            <input class="form-input2" type="text" name="passeportNumber" id="passeportNumber" />
        </div>
    </div>

    <div class="form-div">
        <label class="form-label" for="login">Логин: </label>
        <input class="form-input" type="text" name="login" id="login" />
    </div>
    <div class="form-div">
        <label class="form-label" for="password"> Пароль: </label>
        <input class="form-input" type="password" name="password" id="password" />
    </div>

    <div class="form-btn">
        <button type="submit" class="btn btn-primary btn-small"> Продолжить </button>
    </div>


</form>