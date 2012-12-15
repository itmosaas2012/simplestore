<?php
/**
 * File:        Menu.php
 * Created by:  Ikarius
 * Date:        11/17/12 at 1:53 PM
 * Last Edit:   11/19/12 at 6:53 PM by kokovtsev
 */
?>
    <nav class="header_menu">
        <ul>
            <li class="header_menu_item">
            <?php if($_SESSION['connected']){ ?>
                <li class="header_menu_item">
                <a href='/Settings'>Настройки</a></li>
				<li class="menuSeparator"></li>
            <?php } ?>

                <!--Administration-->
                <?php if($_SESSION['connected'] && $_SESSION['rank'] == 'Администратор') { ?>
                <li class="header_menu_item"><a href="#">
                    <a href="/Administration">Администрация</a>
                    <nav class="header_subMenu">
                        <ul>
                            <li class="menuSeparator"></li>
                            <li class="heder_subMenu_item"><a href="/Administration/Staff">Управления соотрудников</a></li>
                            <li class="menuSeparator"></li>
                            <li class="heder_subMenu_item"><a href="/Administration/WorkPlaces">Управления пунктами</a></li>
                            <li class="menuSeparator"></li>
                        </ul>
                    </nav></li>
                <li class="menuSeparator"></li>
                <?php } ?>

                    <li class="header_menu_item">
                        Рабочея место
                        <nav class="header_subMenu">
                            <ul>
                                <?php if(in_array('Товаровед склада', $ranks) || in_array('Администратор', $ranks)) { ?>
                                    <li class="menuSeparator"></li>
                                    <li class="heder_subMenu_item"><a href="/WorkPoint/WareHouseGoodsManager">Товаровед склада</a></li>

                                <?php } if(in_array('Логист склада', $ranks) || in_array('Администратор', $ranks)) { ?>
                                    <li class="menuSeparator"></li>
                                    <li class="heder_subMenu_item"><a href="/WorkPoint/WareHouseLogist">Логист склада</a></li>

                                <?php } ?>

                                    <li class="menuSeparator"></li>
                            </ul>
                        </nav></li>
                    <li class="menuSeparator"></li> 

                <!--Закупщик магазина-->
                <?php if($_SESSION['connected'] && $_SESSION['rank'] == 'Закупщик магазина') { ?>
                <li class="header_menu_item"><a href="#">
                    <a href="/Purchase">Закупщик магазина</a></li>
                <li class="menuSeparator"></li>
                <?php } ?>
				
                <!--Продавец магазина-->
                <?php if($_SESSION['connected'] && $_SESSION['rank'] == 'Продавец магазина') { ?>
                <li class="header_menu_item"><a href="#">
                    <a href="/Seller">Продавец магазина</a></li>
                <li class="menuSeparator"></li>
                <?php } ?>		

                <!--Товаровед магазина-->
                <?php if($_SESSION['connected'] && $_SESSION['rank'] == 'Товаровед магазина') { ?>
                <li class="header_menu_item"><a href="#">
                    <a href="/Expert">Товаровед магазина</a></li>
                <li class="menuSeparator"></li>
                <?php } ?>					
        </ul>
    </nav>


