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
                <?php
                    if($_SESSION['connected']){
                        $rank = array();
                        foreach($_SESSION['post'] as $post) $ranks[] = $post['rank'];
                        if(in_array('Администратор', $ranks)) { ?>

                            <li class="header_menu_item">
                                Администрация
                                <nav class="header_subMenu">
                                    <ul>
                                        <li class="menuSeparator"></li>
                                        <li class="heder_subMenu_item"><a href="/Administration/Staff">Управления сотрудников</a></li>
                                        <li class="menuSeparator"></li>
                                        <li class="heder_subMenu_item"><a href="/Administration/WorkPlaces">Управления пунктами</a></li>
                                        <li class="menuSeparator"></li>
                                        <li class="heder_subMenu_item"><a href="/Administration/Log">Логи</a></li>
                                        <li class="menuSeparator"></li>
                                    </ul>
                                </nav></li>
                            <li class="menuSeparator"></li>

                    <?php } ?>

                    <li class="header_menu_item">
                        Рабочее место
                        <nav class="header_subMenu">
                            <ul>
                                <?php if(in_array('Товаровед склада', $ranks) || in_array('Администратор', $ranks)) { ?>
                                    <li class="menuSeparator"></li>
                                    <li class="heder_subMenu_item"><a href="/WorkPoint/WareHouseGoodsManager">Товаровед склада</a></li>

                                <?php } if(in_array('Логист склада', $ranks) || in_array('Администратор', $ranks)) { ?>
                                    <li class="menuSeparator"></li>
                                    <li class="heder_subMenu_item"><a href="/WorkPoint/WareHouseLogist">Логист склада</a></li>


                                <?php } if(in_array('Закупщик магазина', $ranks) || in_array('Администратор', $ranks)) { ?>
                                    <li class="menuSeparator"></li>
                                    <li class="heder_subMenu_item"><a href="/Purchase">Закупщик магазина</a></li>


                                <?php } if(in_array('Продавец магазина', $ranks) || in_array('Администратор', $ranks)) { ?>
                                    <li class="menuSeparator"></li>
                                    <li class="heder_subMenu_item"><a href="/Seller">Продавец магазина</a></li>


                                <?php } if(in_array('Товароввед магазина', $ranks) || in_array('Администратор', $ranks)) { ?>
                                    <li class="menuSeparator"></li>
                                    <li class="heder_subMenu_item"><a href="/Expert">Товаровед магазина</a></li>
                                <?php } ?>

                             </ul>
                        </nav></li>
                    <li class="menuSeparator"></li>
                <?php } /*?>

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
                <?php if($_SESSION['connected'] && $_SESSION['rank'] == 'Товароввед магазина') { ?>
                <li class="header_menu_item"><a href="#">
                    <a href="/Expert">Товаровед магазина</a></li>
                <li class="menuSeparator"></li>
                <?php } */?>
        </ul>
    </nav>


