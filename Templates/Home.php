
<!-- end .content -->

<h2>Версия 1.0</h2>
<ol>
    <li>Возможность создания учетных записей администратора, сотрудников склада и розничных магазинов.</li>
    <li>Функционал учетной записи сотрудников склада.<br>
        <ol>
            <li><u>Товаровед склада</u>. Функции: <br>
                <ol>
                    <li>Занесение в систему данных о наименовании и количестве имеющегося товара.<br>
                    </li>
                </ol>
            </li>
            <li><u>Логист склада</u>. Функции:<br>
                <ol>
                    <li>Управление движением поставок товара. Распределение товаров по розничным магазинам. Первое распределение - на основании формулы либо вручную. Последующие отгрузки - на основании данных, полученных от пользователей типа «Закупщик розничного магазина».<br>
                    </li>
                    <li>Подсчет проданного и нереализованного товара для всех магазинов и каждого магазина в отдельности на основании данных, полученных из учетных записей типа «Товаровед розничного магазина», составление статистики.<br>
                    </li>
                </ol>
            </li>
        </ol>
    </li>
    <li>Функционал учетной записи сотрудников магазинов розничной торговли.<br>
        <ol>
            <li><u>Продавец розничного магазина</u>. Функции:<br>
                <ol>
                    <li>Занесение в систему данных о количестве реализованного товара. Система автоматически осуществляет подсчет нереализованной продукции на основании данных об исходном количестве товара, внесенных пользователем «Логист склада».<br>
                    </li>
                </ol>
            </li>
            <li><u>Товаровед розничного магазина</u>. Функции:<br>
                <ol>
                    <li>На основании данных, полученных от пользователя «Продавец розничного магазина», проводится инвентаризация - подсчет утерянной продукции.<br>
                    </li>
                </ol>
            </li>
            <li><u>Закупщик розничного магазина</u>. Функции:<br>
                <ol>
                    <li>Анализ динамики продаж товаров каждого вида на основании данных, полученных от пользователей «Продавец розничного магазина» и «Товаровед розничного магазина». <br>
                    </li>
                    <li>Планирование закупок на основании проанализированных данных.<br>
                    </li>
                    <li>Формирование запроса на склад о количестве продукции каждого вида.<br>
                    </li>
                </ol>
            </li>
        </ol>
    </li>
    <li><u>Администратор</u>. Функции:<br>
        <ol>
            <li>Подтверждение при регистрации нового пользователя.<br>
            </li>
        </ol>
    </li>
    <li>Описание способа занесения данных в систему.<br>
        <ol>
            <li>Авторизация пользователя:<br>
                <ol>
                    <li>ФИО;<br>
                    </li>
                    <li>Место работы (склад либо номер магазина);<br>
                    </li>
                    <li>Должность (товаровед склада, логист склада, продавец розничного магазина, товаровед розничного магазина, закупщик розничного магазина).<br>
                    </li>
                </ol>
            </li>
            <li>Информация о товаре:<br>
                <ol>
                    <li>Наименование;<br>
                    </li>
                    <li>Количество данного вида товара (исходное количество, количество реализованного и нереализованного товара).</li>
                </ol>
            </li>
        </ol>
    </li>
</ol>
