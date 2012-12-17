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

<form method="post" action="/Administration/AddWorkPlace">

    <h2>Ввести новый пункт:</h2>

    <div class="form-div">
        <label class="form-label" for="address"> Адрес: </label>
        <input class="form-input" type="text" name="address" id="address" autofocus />
    </div>

    <div class="form-div">
        <label class="form-label" for="workPlace"> Тип пункта: </label>
        <select class="form-input" name="workPlace" id="workPlace">
            <?php foreach ($view['wpTypes'] as $wpType){
                $trans = ($wpType['description']=='wh')?'Склад':'Магазин';
                echo '<option value="'.$wpType['id'].'">'.$trans.'</option>';

                }
            ?>
        </select>
    </div>

    <div class="form-div">
        <label class="form-label" for="capacity"> Ёмкость: </label>
        <input class="form-input" type="number" min="0"  name="capacity" id="capacity" autofocus />
    </div>

    <div class="form-div">
        <label class="form-label" for="responsible"> Ответсвенный: </label>
        <select class="form-input" name="responsible" id="responsible">
            <?php foreach ($view['users'] as $user)
                        echo '<option value="'.$user['id'].'">'.$user['login'].'</option>';
            ?>
        </select>
    </div>

    <div class="form-btn">
        <button type="submit" class="btn btn-primary btn-small"> Продолжить </button>
    </div>

</form>