<?php
/**
* Template Name: Index 1
 */

get_header();
?>

<!--Табы Кнопки-->
<section class="f fac gap8 f_f tab_buttons">
    <button id="tab_1_button" class="btn_tab pad8t pad8b" onclick="showTab('tab_1', this)">
        <span class="tab_chapter">
            Оформлення
        </span>
        <img class="tab_img" src="<?php echo get_template_directory_uri(); ?>/img/tab1.png" alt="">
    </button>
    <button id="tab_2_button" class="btn_tab pad8t pad8b" onclick="showTab('tab_2', this)">
            <span class="tab_chapter">
                Піч
            </span>
        <img class="tab_img" src="<?php echo get_template_directory_uri(); ?>/img/tab2.png" alt="">
    </button>
    <button id="tab_3_button" class="btn_tab pad8t pad8b" onclick="showTab('tab_3', this)">
            <span class="tab_chapter">
                Напівфабрикат
            </span>
        <img class="tab_img" src="<?php echo get_template_directory_uri(); ?>/img/tab3.png" alt="">
    </button>
    <button id="tab_4_button" class="btn_tab pad8t pad8b" onclick="showTab('tab_4', this)">
            <span class="tab_chapter">
                Поклейка
            </span>
        <img class="tab_img" src="<?php echo get_template_directory_uri(); ?>/img/tab4.png" alt="">
    </button>
    <button id="tab_5_button" class="btn_tab pad8t pad8b" onclick="showTab('tab_5', this)">
            <span class="tab_chapter">
                Готове
            </span>
        <img class="tab_img" src="<?php echo get_template_directory_uri(); ?>/img/tab5.png" alt="">
    </button>
    <button id="tab_6_button" class="btn_tab pad8t pad8b" onclick="showTab('tab_6', this)">
            <span class="tab_chapter">
                Звіт
            </span>
        <img class="tab_img" src="<?php echo get_template_directory_uri(); ?>/img/tab6.png" alt="">
    </button>
    <button id="tab_7_button" class="btn_tab pad8t pad8b" onclick="showTab('tab_7', this)">
            <span class="tab_chapter">
                Редагування
            </span>
        <img class="tab_img" src="<?php echo get_template_directory_uri(); ?>/img/tab7.png" alt="">
    </button>
</section>
<!--Время-->
<section class="f gap8 fac">
    <span id="currentDateTime">

    </span>
</section>
<!--Таб 1 (ОФОРМЛЕНИЕ)-->
<section id="tab_1" class="tabs__block f fc gap60">
    <form action="<?php echo admin_url('admin-ajax.php'); ?>" id="tab_1_form" class="f fw w gap8 f_f" method="post">
        <!--Стекло-->
        <div class="f fc gap8 f_200">
            <div class="w BIG">
                Скло
            </div>
            <div class="w f fc">
                <input type="text" autocomplete="off" name="tab_1_glass" list="tab_1_glass" id="tab_1_glass_selected" placeholder="Оберіть скло" class="shadow pad8" required/>
                <datalist id="tab_1_glass" class="shadow">
                    <?php
                    $glass_list = CFS()->get('glass_list');

                    // Функция для сортировки массива по значению glass_count
                    usort($glass_list, function($a, $b) {
                    return $a['glass_count'] - $b['glass_count'];
                    });

                    foreach ($glass_list as $index => $glass_item) {
                    ?>
                    <option
                            data-name="<?php echo $glass_item['glass_name']; ?>"
                            data-id="<?php echo $index + 1; ?>"
                            data-count="<?php echo $glass_item['glass_count']; ?>"
                            value="<?php echo $glass_item['glass_name']; ?>">
                        <?php echo $glass_item['glass_count']; ?>
                    </option>
                    <?php
                    }
                    ?>
                </datalist>
            </div>
        </div>
        <!--К-сть-->
        <div class="f fc gap8 f_100">
            <div class="BIG">
                К-сть
            </div>
            <div class="shadow  h_50m f gap20 fac _br8 list_open">
                <input type="number" name="tab_1_count" id="tab_1_count" max="" required/>
            </div>
        </div>
        <!--Виемка-->
        <div class="f fc gap8 f_300">
            <div class="BIG">
                Виїмка
            </div>
            <div class="w f fc">
                <input autocomplete="off" type="text" name="tab_1_insert" list="tab_1_insert" id="tab_1_insert_selected" placeholder="Оберіть виїмку" class="shadow pad8"/>
                <datalist id="tab_1_insert" class="shadow">
                    <?php
                    $insert_list = CFS()->get('insert_list');

                    // Функция для сравнения строк по алфавиту с учетом кириллицы и английского
                    function compare_inserts($a, $b) {
                    $a_name = $a['insert_name'];
                    $b_name = $b['insert_name'];

                    // Сначала проверяем сортировку по кириллице
                    $result = strcoll($a_name, $b_name);

                    // Если строки равны по кириллице, используем сортировку по английскому
                    if ($result === 0) {
                    return strcmp($a_name, $b_name);
                    }

                    return $result;
                    }

                    // Сортируем массив в соответствии с пользовательской функцией сравнения
                    usort($insert_list, 'compare_inserts');

                    foreach ($insert_list as $index => $insert_item) {
                    ?>
                    <option data-name="<?php echo $insert_item['insert_name']; ?>" data-id="<?php echo $index + 1; ?>" value="<?php echo $insert_item['insert_name']; ?>"></option>
                    <?php
                    }
                    ?>
                </datalist>
            </div>
        </div>
        <!--Специалист-->
        <div class="f fc gap8 f_200">
            <div class="w BIG">
                Працівник
            </div>
            <div class="w f fc">
                <input autocomplete="off" type="text" name="tab_1_master" list="tab_1_master" id="tab_1_master_selected" placeholder="Оберіть фахівця" class="shadow pad8" required/>
                <datalist id="tab_1_master" class="shadow">
                    <?php
                        $master_list_tab_1 = CFS()->get('master_list');

                    // Функция сравнения для блока tab_1_master
                    function compare_masters_tab_1($a, $b) {
                    $a_name = $a['master_name'];
                    $b_name = $b['master_name'];

                    // Сначала проверяем сортировку по кириллице
                    $result = strcoll($a_name, $b_name);

                    // Если строки равны по кириллице, используем сортировку по английскому
                    if ($result === 0) {
                    return strcmp($a_name, $b_name);
                    }

                    return $result;
                    }

                    // Сортировка массива для блока tab_1_master
                    usort($master_list_tab_1, 'compare_masters_tab_1');

                    foreach ($master_list_tab_1 as $index => $master_item) {
                    ?>
                    <option data-name="<?php echo $master_item['master_name']; ?>" data-id="<?php echo $index + 1; ?>" value="<?php echo $master_item['master_name']; ?>"></option>
                    <?php
                        }
                        ?>
                </datalist>
            </div>
        </div>
        <!--Скрытый-->
        <input type="hidden" name="action" value="tab_1_form">
        <!--Действие-->
        <div class="f fc gap8 f_250_10">
            <div class="w BIG">
                Дія
            </div>
            <div class="shadow f gap8 h_50m tab_1_buttons">
                <button class="btn btn_blue f_auto" name="У піч" type="submit">У піч</button>
                <button class="btn btn_red f_auto" name="Брак" type="submit">Брак</button>
            </div>
        </div>
        <!--Скрытый-->
        <input type="hidden" name="tab_1_action" id="tab_1_action">
    </form>
    <!--скрипт-->
    <script>
        jQuery(function($) {
            $('.tab_1_buttons button').click(function(e) {
                var action = $(this).attr('name'); // Получаем значение атрибута name нажатой кнопки
                $('#tab_1_action').val(action); // Устанавливаем значение в скрытое поле


                var enteredGlass = $('input[name="tab_1_glass"]').val().trim(); // Получаем значение введенного стекла

                var isGlassExists = false;
                var enteredGlassLower = enteredGlass.toLowerCase(); // Приводим введенное значение стекла к нижнему регистру
                $('datalist#tab_1_glass option').each(function() {
                    var currentGlassName = $(this).val().trim().toLowerCase(); // Приводим текущее значение стекла к нижнему регистру
                    if (currentGlassName === enteredGlassLower) {
                        isGlassExists = true;
                        return false; // Прерываем цикл, так как совпадение найдено
                    }
                });

                if (!isGlassExists) {
                    alert('Оберіть скло зі списку.');
                    return false; // Завершаем обработчик
                }

                var enterCount = $('input[name="tab_1_count"]').val().trim();

                // Проверяем, введено ли число и является ли оно больше либо равным единице
                if (!enterCount || parseInt(enterCount) < 1 || isNaN(parseInt(enterCount))) {
                    alert('Введіть число більше або рівне одиниці');
                    return false;
                }


                var enteredInsert = $('input[name="tab_1_insert"]').val().trim(); // Получаем значение введенной выемки
                if (enteredInsert !== '') {
                    var isInsertExists = false;
                    var enteredInsertLower = enteredInsert.toLowerCase(); // Приводим введенное значение выемки к нижнему регистру
                    $('#tab_1_insert option').each(function() {
                        var currentInsertName = $(this).val().trim().toLowerCase(); // Приводим текущее значение выемки к нижнему регистру
                        if (currentInsertName === enteredInsertLower) {
                            isInsertExists = true;
                            return false; // Прерываем цикл, так как совпадение найдено
                        }
                    });

                    if (!isInsertExists) {
                        alert('Оберіть виїмку зі списку.');
                        return false; // Завершаем обработчик
                    }
                }


                var enteredMaster = $('input[name="tab_1_master"]').val().trim(); // Получаем значение выбранного специалиста

                var isMasterExists = false;
                $('datalist#tab_1_master option').each(function() {
                    var currentMaster = $(this).val().trim();
                    if (currentMaster === enteredMaster) {
                        isMasterExists = true;
                        return false; // Прерываем цикл, так как совпадение найдено
                    }
                });

                if (!isMasterExists) {
                    alert('Оберіть фахівця зі списку.');
                    return false; // Завершаем обработчик
                }


                // Если все проверки успешно пройдены, отправляем данные формы
                var formData = $('#tab_1_form').serialize();

            });
        });
    </script>
    <!--списки склада-->
    <div class="f w fw gap20 list_stock">
        <div class="f fc gap8 shadow pad8 _br8 f_300 h300M">
            <h3>
                Скло
            </h3>
            <input type="text" autocomplete="off" name="" placeholder="Пошук скла" id="search_list_glass" oninput="liveSearch('list_glass', this.value)">
            <ul id="list_glass" class="f fc gap8 h300M scroll">
                <?php
                $glass_list = CFS()->get('glass_list');

                if (!empty($glass_list)) {
                usort($glass_list, function($a, $b) {
                return $a['glass_count'] - $b['glass_count'];
                });

                foreach ($glass_list as $index => $glass_item) {
                ?>
                <li class="f fac gap8 list_item" data-name="<?php echo $glass_item['glass_name']; ?>"
                    data-id="<?php echo $index + 1; ?>" data-count="<?php echo $glass_item['glass_count']; ?>">
                            <span>
                                <?php echo $glass_item['glass_count']; ?>
                            </span>
                    <span class="c4">
                                <?php echo $glass_item['glass_name']; ?>
                            </span>
                </li>
                <?php
                    }
                } else {
                    // Если список стекла пуст, выводим "Скла немає"
                    ?>
                <li class="f fac gap8 list_item">
                    <span>Скла немає</span>
                </li>
                <?php
                }
                ?>
            </ul>
        </div>
        <div class="f fc gap8 shadow pad8 _br8 f_300 h300M">
            <h3>
                Виїмка
            </h3>
            <input type="text" autocomplete="off" name="" placeholder="Пошук виїмки" id="search_list_insert" oninput="liveSearch('list_insert', this.value)">
            <ul id="list_insert" class="f fc gap8 h300M scroll">
                <?php
                $insert_list = CFS()->get('insert_list');

                // Проверяем, есть ли информация о вставках
                if (!empty($insert_list)) {
                // Определение пользовательской функции сравнения
                function cmp($a, $b) {
                // Проверяем, принадлежат ли оба значения кириллическому алфавиту
                $isCyrillicA = preg_match('/\p{Cyrillic}/u', $a);
                $isCyrillicB = preg_match('/\p{Cyrillic}/u', $b);

                // Если оба значения кириллические, сравниваем их лексикографически
                if ($isCyrillicA && $isCyrillicB) {
                return strcoll($a, $b);
                }

                // Если только одно значение кириллическое, то кириллическое значение должно быть первым
                if ($isCyrillicA) {
                return -1;
                }
                if ($isCyrillicB) {
                return 1;
                }

                // Если оба значения не кириллические, сравниваем их лексикографически
                return strcoll($a, $b);
                }

                // Создаем массив для хранения только значений 'insert_name'
                $names = array();
                foreach ($insert_list as $index => $insert_item) {
                $names[$index] = $insert_item['insert_name'];
                }

                // Сортируем массив с помощью пользовательской функции сравнения
                usort($names, 'cmp');

                // Выводим элементы списка в соответствии с отсортированным массивом
                foreach ($names as $index => $name) {
                ?>
                <li class="f fac gap8 list_item c9" data-name="<?php echo $name; ?>" data-id="<?php echo $index + 1; ?>">
                    <?php echo $name; ?>
                </li>
                <?php
                    }
                } else {
                    // Если информация о вставках отсутствует, вы можете вывести сообщение об отсутствии данных
                    ?>
                <li class="f fac gap8 list_item c9">
                    Виїмок немає
                </li>
                <?php
                }
                ?>
            </ul>
        </div>
        <div class="f fc gap8 shadow pad8 _br8 f_300 h300M">
            <h3>
                Вставка
            </h3>
            <input type="text" autocomplete="off" name="" placeholder="Пошук вставки" id="search_list_stick" oninput="liveSearch('list_stick', this.value)">
            <ul id="list_stick" class="f fc gap8 h300M scroll">
                <?php
                $stick_list = CFS()->get('stick_list');

                // Проверяем наличие вставок в списке
                if (!empty($stick_list)) {
                // Сортируем список по количеству вставок
                usort($stick_list, function ($a, $b) {
                return $a['stick_count'] - $b['stick_count'];
                });
                // Выводим список вставок
                foreach ($stick_list as $index => $stick_item) {
                ?>
                <li class="f fac gap8 list_item" data-name="<?php echo $stick_item['stick_name']; ?>"
                    data-id="<?php echo $index + 1; ?>" data-count="<?php echo $stick_item['stick_count']; ?>">
                        <span>
                            <?php echo $stick_item['stick_count']; ?>
                        </span>
                    <span class="c10">
                            <?php echo $stick_item['stick_name']; ?>
                        </span>
                </li>
                <?php
                    }
                } else {
                ?>
                <li class="f fac gap8 list_item">Вставок немає</li>
                <?php
                }
                ?>
            </ul>


        </div>
    </div>
</section>
<!--ТАБ 2 (ПЕЧЬ)-->
<section id="tab_2" class="tabs__block f fc gap60">
    <form action="<?php echo admin_url('admin-ajax.php'); ?>" id="tab_2_form" class="f fw w gap8 f_f" method="post">
        <!--Стекло-->
        <div class="f fc gap8 f_200">
            <div class="w BIG">
                Скло
            </div>
            <div class="w f fc">
                <input type="text" autocomplete="off" name="tab_2_glass" list="tab_2_glass" id="tab_2_glass_selected" placeholder="Оберіть скло" class="shadow pad8" required/>
                <datalist id="tab_2_glass" class="shadow">
                    <?php
                    $tab_2_list = CFS()->get('tab_2_list');

                    usort($tab_2_list, function($a, $b) {
                    return $a['tab_2_count'] - $b['tab_2_count'];
                    });

                    foreach ($tab_2_list as $index => $tab_2_item) {
                    ?>
                    <option data-name="<?php echo $tab_2_item['tab_2_glass']; ?> <?php echo $tab_2_item['tab_2_insert']; ?>"
                            data-id="<?php echo $index + 1; ?>"
                            data-count="<?php echo $tab_2_item['tab_2_count']; ?>"
                            value="<?php echo $tab_2_item['tab_2_glass'] . ($tab_2_item['tab_2_insert'] ? ' ( ' . $tab_2_item['tab_2_insert'] . ' )' : ''); ?>">
                        <?php echo $tab_2_item['tab_2_count']; ?>
                    </option>
                    <?php
                    }
                    ?>
                </datalist>
            </div>
        </div>
        <!--К-сть-->
        <div class="f fc gap8 f_100">
            <div class="BIG">
                К-сть
            </div>
            <div class="shadow  h_50m f gap20 fac _br8 list_open">
                <input type="number" name="tab_2_count" id="tab_2_count" required/>
            </div>
        </div>
        <!--Специалист-->
        <div class="f fc gap8 f_200">
            <div class="w BIG">
                Працівник
            </div>
            <div class="w f fc">
                <input type="text" autocomplete="off" name="tab_2_master" list="tab_2_master" id="tab_2_master_selected" placeholder="Оберіть фахівця" class="shadow pad8" required/>
                <datalist id="tab_2_master" class="shadow">
                    <?php
                        $master_list_tab_2 = CFS()->get('master_list');

                    // Функция сравнения для блока tab_1_master
                    function compare_masters_tab_2($a, $b) {
                    $a_name = $a['master_name'];
                    $b_name = $b['master_name'];

                    // Сначала проверяем сортировку по кириллице
                    $result = strcoll($a_name, $b_name);

                    // Если строки равны по кириллице, используем сортировку по английскому
                    if ($result === 0) {
                    return strcmp($a_name, $b_name);
                    }

                    return $result;
                    }

                    // Сортировка массива для блока tab_1_master
                    usort($master_list_tab_2, 'compare_masters_tab_2');

                    foreach ($master_list_tab_2 as $index => $master_item) {
                    ?>
                    <option data-name="<?php echo $master_item['master_name']; ?>"
                            data-id="<?php echo $index + 1; ?>"
                            value="<?php echo $master_item['master_name']; ?>"></option>
                    <?php
                        }
                        ?>
                </datalist>
            </div>
        </div>
        <!--Скрытый-->
        <input type="hidden" name="action" value="tab_2_form">
        <!--Действие-->
        <div class="f fc gap8 f_250_10">
            <div class="w BIG">
                Дія
            </div>
            <div class="shadow f gap8 h_50m tab_2_buttons">
                <button class="btn btn_blue f_auto" name="Напівфабрикат" type="submit">Напівфабрикат</button>
                <button class="btn btn_red f_auto" name="Брак" type="submit"> Брак </button>
                <button class="btn btn_black f_auto" name="Повернути" type="submit"> Повернути </button>
            </div>
        </div>
        <!--Скрытый-->
        <input type="hidden" name="tab_2_action" id="tab_2_action">
    </form>
    <script>
        jQuery(function($) {
            $('.tab_2_buttons button').click(function(e) {
                var action = $(this).attr('name'); // Получаем значение атрибута name нажатой кнопки
                $('#tab_2_action').val(action); // Устанавливаем значение в скрытое поле


                var enteredGlass = $('input[name="tab_2_glass"]').val().trim().toLowerCase(); // Получаем значение введенного стекла

                var isGlassExists = false;
                // Проверяем каждый элемент в datalist
                $('datalist#tab_2_glass option').each(function() {
                    var currentGlassName = $(this).val().trim().toLowerCase();
                    if (currentGlassName === enteredGlass) {
                        // Проверяем наличие атрибута data-count
                        if ($(this).data('count') > 0) {
                            isGlassExists = true;
                            return false; // Прерываем цикл
                        }
                    }
                });

                // Если стекло не найдено или не имеет data-count, выводим сообщение
                if (!isGlassExists) {
                    alert('Виберіть скло зі списку.');
                    return false; // Прерываем цикл
                }

                var enterCount = $('input[name="tab_2_count"]').val().trim();

                if(!enterCount) {
                    alert('Оберіть кількість');
                    return false;
                }

                var enteredMaster = $('input[name="tab_2_master"]').val().trim(); // Получаем значение выбранного специалиста

                var isMasterExists = false;
                $('datalist#tab_2_master option').each(function() {
                    var currentMaster = $(this).val().trim();
                    if (currentMaster === enteredMaster) {
                        isMasterExists = true;
                        return false; // Прерываем цикл, так как совпадение найдено
                    }
                });

                if (!isMasterExists) {
                    alert('Оберіть фахівця зі списку.');
                    return false; // Завершаем обработчик
                }


                // Если все проверки успешно пройдены, отправляем данные формы
                var formData = $('#tab_2_form').serialize();

            });
        });
    </script>
    <div class="f w fw gap20 list_stock">
        <div class="f fc gap8 shadow pad8 _br8 f_300 h300M">
            <h3>
                В печі
            </h3>
            <input type="text" autocomplete="off" name="" placeholder="Пошук скла" id="tab_2_list_search" oninput="liveSearch('tab_2_list', this.value)">
            <ul id="tab_2_list" class="f fc gap8 h300M scroll">
                <?php
                $tab_2_list = CFS()->get('tab_2_list');

                // Проверяем наличие данных в списке
                if (!empty($tab_2_list)) {
                usort($tab_2_list, function($a, $b) {
                return $a['tab_2_count'] - $b['tab_2_count'];
                });

                foreach ($tab_2_list as $index => $tab_2_item) {
                ?>
                <li class="f fac gap8 list_item"
                    data-name="<?php echo $tab_2_item['tab_2_glass'] . ' ' . $tab_2_item['tab_2_insert']; ?>"
                    data-id="<?php echo $index + 1; ?>"
                    data-count="<?php echo $tab_2_item['tab_2_count']; ?>">
                            <span>
                                <?php echo $tab_2_item['tab_2_count']; ?>
                            </span>
                    <span class="c4">
                                <?php echo $tab_2_item['tab_2_glass']; ?>
                            </span>
                    <span class="c9">
                                <?php if (isset($tab_2_item['tab_2_insert'])) {
                                    echo $tab_2_item['tab_2_insert'];
                                } ?>
                            </span>
                </li>
                <?php
                    }
                } else {
                    // Если список пуст, выводим соответствующее сообщение
                    ?>
                <li class="f fac gap8 list_item">
                    <span>Пусто</span>
                </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</section>
<!--ТАБ 3 (ПОЛУФАБРИКАТ)-->
<section id="tab_3" class="tabs__block f fc gap60">
    <form action="<?php echo admin_url('admin-ajax.php'); ?>" id="tab_3_form" class="f fw w gap8 f_f" method="post">
        <!--Посуда-->
        <div class="f fc gap8 f_200">
            <div class="w BIG">
                Посуд
            </div>
            <div class="w f fc">
                <input type="text" autocomplete="off" name="tab_3_glass" list="tab_3_glass" id="tab_3_glass_selected" placeholder="Оберіть посуд" class="shadow pad8" required/>
                <datalist id="tab_3_glass" class="shadow">
                    <?php
                    $tab_3_list = CFS()->get('tab_3_list');

                    usort($tab_3_list, function($a, $b) {
                    return $a['tab_3_count'] - $b['tab_3_count'];
                    });

                    foreach ($tab_3_list as $index => $tab_3_item) {
                    ?>
                    <option data-glass="<?php echo $tab_3_item['tab_3_glass']; ?>"
                            data-insert="<?php echo $tab_3_item['tab_3_insert']; ?>"
                            data-id="<?php echo $index + 1; ?>"
                            data-count="<?php echo $tab_3_item['tab_3_count']; ?>"
                            value="<?php echo $tab_3_item['tab_3_count'] . ' ' . $tab_3_item['tab_3_glass'] . ($tab_3_item['tab_3_insert'] ? ' ( ' . $tab_3_item['tab_3_insert'] . ' )' : ''); ?>">
                    </option>
                    <?php
                    }
                    ?>
                </datalist>
            </div>
        </div>
        <!--К-сть-->
        <div class="f fc gap8 f_100">
            <div class="BIG">
                К-сть
            </div>
            <div class="shadow  h_50m f gap20 fac _br8 list_open">
                <input type="number" name="tab_3_count" id="tab_3_count" required/>
            </div>
        </div>
        <!--Специалист-->
        <div class="f fc gap8 f_200">
            <div class="w BIG">
                Працівник
            </div>
            <div class="w f fc">
                <input type="text" autocomplete="off" name="tab_3_master" list="tab_3_master" id="tab_3_master_selected" placeholder="Оберіть фахівця" class="shadow pad8" required/>
                <datalist id="tab_3_master" class="shadow">
                    <?php
                        $master_list_tab_3 = CFS()->get('master_list');

                    // Функция сравнения для блока tab_1_master
                    function compare_masters_tab_3($a, $b) {
                    $a_name = $a['master_name'];
                    $b_name = $b['master_name'];

                    // Сначала проверяем сортировку по кириллице
                    $result = strcoll($a_name, $b_name);

                    // Если строки равны по кириллице, используем сортировку по английскому
                    if ($result === 0) {
                    return strcmp($a_name, $b_name);
                    }

                    return $result;
                    }

                    // Сортировка массива для блока tab_1_master
                    usort($master_list_tab_3, 'compare_masters_tab_3');

                    foreach ($master_list_tab_3 as $index => $master_item) {
                    ?>
                    <option data-name="<?php echo $master_item['master_name']; ?>" data-id="<?php echo $index + 1; ?>" value="<?php echo $master_item['master_name']; ?>"></option>
                    <?php
                        }
                        ?>
                </datalist>
            </div>
        </div>
        <!--Вставки-->
        <div class="f fw w gap20 f_f w">
            <div class="f fw gap20 f_f f_512">
                <div class="f gap8 fac shadow pad4 _br8 f_250">
                    <!--Вставка 1-->
                    <div class="f fc gap8 f_200">
                        <div class="BIG">
                            Вставка 1
                        </div>
                        <div class="w f fc">
                            <input type="text" autocomplete="off" name="tab_3_stick_1" list="tab_3_stick_1" id="tab_3_stick_1_selected" placeholder="Оберіть вставку" class="shadow pad8"/>
                            <datalist id="tab_3_stick_1" class="shadow">
                                <?php
                                    $stick_list = CFS()->get('stick_list');
                                usort($stick_list, function($a, $b) {
                                return $a['stick_count'] - $b['stick_count'];
                                });

                                foreach ($stick_list as $index => $stick_item) {
                                ?>
                                <option
                                        data-id="<?php echo $index + 1; ?>"
                                        data-stick="<?php echo $stick_item['stick_name']; ?>"
                                        data-count="<?php echo $stick_item['stick_count']; ?>"
                                        value="<?php echo $stick_item['stick_name']; ?>">
                                    <?php echo $stick_item['stick_count']; ?>
                                </option>
                                <?php
                                }
                                ?>
                            </datalist>
                        </div>
                    </div>
                    <!--К-сть-->
                    <div class="f fc gap8 f_100">
                        <div class="BIG">
                            К-сть
                        </div>
                        <div class="shadow  h_50m f gap20 fac _br8 list_open">
                            <input type="number" name="tab_3_stick_1_count" id="tab_3_stick_1_count" max="7"/>
                        </div>
                    </div>
                </div>
                <div class="f gap8 fac shadow pad4 _br8 f_250">
                    <!--Вставка 2-->
                    <div class="f fc gap8 f_200">
                        <div class="BIG">
                            Вставка 2
                        </div>
                        <div class="w f fc">
                            <input type="text" autocomplete="off" name="tab_3_stick_2" list="tab_3_stick_2" id="tab_3_stick_2_selected" placeholder="Оберіть виїмку" class="shadow pad8"/>
                            <datalist id="tab_3_stick_2" class="shadow">
                                <?php
                            $stick_list = CFS()->get('stick_list');
                                usort($stick_list, function($a, $b) {
                                return $a['stick_count'] - $b['stick_count'];
                                });

                                foreach ($stick_list as $index => $stick_item) {
                                ?>
                                <option
                                        data-id="<?php echo $index + 1; ?>"
                                        data-stick="<?php echo $stick_item['stick_name']; ?>"
                                        data-count="<?php echo $stick_item['stick_count']; ?>"
                                        value="<?php echo $stick_item['stick_name']; ?>">
                                    <?php echo $stick_item['stick_count']; ?>
                                </option>
                                <?php
                            }
                            ?>
                            </datalist>
                        </div>
                    </div>
                    <!--К-сть-->
                    <div class="f fc gap8 f_100">
                        <div class="BIG">
                            К-сть
                        </div>
                        <div class="shadow  h_50m f gap20 fac _br8 list_open">
                            <input type="number" name="tab_3_stick_2_count" id="tab_3_stick_2_count" max="7"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="f fw gap20 f_f f_512">
                <div class="f gap8 fac shadow pad4 _br8 f_250">
                    <!--Вставка 3-->
                    <div class="f fc gap8 f_200">
                        <div class="BIG">
                            Вставка 3
                        </div>
                        <div class="w f fc">
                            <input type="text" autocomplete="off" name="tab_3_stick_3" list="tab_3_stick_3" id="tab_3_stick_3_selected" placeholder="Оберіть виїмку" class="shadow pad8"/>
                            <datalist id="tab_3_stick_3" class="shadow">
                                <?php
                            $stick_list = CFS()->get('stick_list');
                                usort($stick_list, function($a, $b) {
                                return $a['stick_count'] - $b['stick_count'];
                                });
                                foreach ($stick_list as $index => $stick_item) {
                                ?>
                                <option
                                        data-id="<?php echo $index + 1; ?>"
                                        data-stick="<?php echo $stick_item['stick_name']; ?>"
                                        data-count="<?php echo $stick_item['stick_count']; ?>"
                                        value="<?php echo $stick_item['stick_name']; ?>">
                                    <?php echo $stick_item['stick_count']; ?>
                                </option>
                                <?php
                            }
                            ?>
                            </datalist>
                        </div>
                    </div>
                    <!--К-сть-->
                    <div class="f fc gap8 f_100">
                        <div class="BIG">
                            К-сть
                        </div>
                        <div class="shadow  h_50m f gap20 fac _br8 list_open">
                            <input type="number" name="tab_3_stick_3_count" id="tab_3_stick_3_count" max="7"/>
                        </div>
                    </div>
                </div>
                <div class="f gap8 fac shadow pad4 _br8 f_250">
                    <!--Вставка індівідуальна-->
                    <div class="f fc gap8 f_200">
                        <div class="BIG">
                            Вставка індівідуальна
                        </div>
                        <div class="w f fc">
                            <input type="text" autocomplete="off" name="tab_3_stick_4" id="tab_3_stick_4_selected" placeholder="індівідуальна" class="shadow pad8" oninput="addNumber('tab_3_stick_4','tab_3_stick_4_count')"/>
                        </div>
                    </div>
                    <!--К-сть-->
                    <div class="f fc gap8 f_100">
                        <div class="BIG">
                            К-сть
                        </div>
                        <div class="shadow  h_50m f gap20 fac _br8 list_open">
                            <input type="number" name="tab_3_stick_4_count" id="tab_3_stick_4_count"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Действие-->
        <div class="f fc gap8 f_250_10">
            <div class="w BIG">
                Дія
            </div>
            <div class="shadow f gap8 h_50m tab_3_buttons">
                <button class="btn btn_blue f_auto" name="Поклейка" type="submit">Поклейка</button>
                <button class="btn btn_red f_auto" name="Брак" type="submit">Брак</button>
                <button class="btn btn_black f_auto" name="Повернути" type="submit">Повернути</button>
            </div>
        </div>
        <!--Скрытый-->
        <input type="hidden" name="tab_3_glass_hidden" id="tab_3_glass_hidden">
        <input type="hidden" name="tab_3_count_hidden" id="tab_3_count_hidden">
        <input type="hidden" name="tab_3_insert_hidden" id="tab_3_insert_hidden">
        <input type="hidden" name="tab_3_stick_1_hidden_count" id="tab_3_stick_1_hidden_count">
        <input type="hidden" name="tab_3_stick_2_hidden_count" id="tab_3_stick_2_hidden_count">
        <input type="hidden" name="tab_3_stick_3_hidden_count" id="tab_3_stick_3_hidden_count">
        <input type="hidden" name="tab_3_stick_4_hidden_count" id="tab_3_stick_4_hidden_count">
        <input type="hidden" name="action" value="tab_3_form">
        <input type="hidden" name="tab_3_action" id="tab_3_action">
    </form>
    <script>
        jQuery(function($) {
            $('.tab_3_buttons button').click(function(e) {
                var action = $(this).attr('name');
                $('#tab_3_action').val(action);

                var enteredValue = $('input[name="tab_3_glass"]').val().trim();
                var selectedOption = $('datalist#tab_3_glass option[value="' + enteredValue + '"]');

                if (selectedOption.length > 0) {
                    var glass = selectedOption.attr('data-glass');
                    var count = selectedOption.attr('data-count');
                    var insert = selectedOption.attr('data-insert');

                    $('#tab_3_glass_hidden').val(glass);
                    $('#tab_3_count_hidden').val(count);
                    $('#tab_3_insert_hidden').val(insert);
                } else {
                    $('#tab_3_glass_hidden').val('');
                    $('#tab_3_count_hidden').val('');
                    $('#tab_3_insert_hidden').val('');
                }

                var enteredGlass = $('input[name="tab_3_glass"]').val().trim().toLowerCase();
                var isGlassExists = false;

                // Проверяем каждый элемент в datalist
                $('datalist#tab_3_glass option').each(function() {
                    var currentGlassName = $(this).val().trim().toLowerCase();
                    if (currentGlassName === enteredGlass) {
                        // Проверяем наличие атрибута data-count
                        if ($(this).data('count') > 0) {
                            isGlassExists = true;
                            return false; // Прерываем цикл
                        }
                    }
                });

                if (!isGlassExists) {
                    alert('Виберіть посуд зі спіку');
                    return false; // Возвращаем false
                }


                var enterCount = $('input[name="tab_3_count"]').val().trim();
                if (!enterCount) {
                    alert('Оберіть кількість');
                    return false;
                }

                var enteredMaster = $('input[name="tab_3_master"]').val().trim().toLowerCase();
                var isMasterExists = $('datalist#tab_3_master option').filter(function() {
                    return $(this).val().trim().toLowerCase() === enteredMaster;
                }).length > 0;

                if (!isMasterExists) {
                    alert('Оберіть фахівця зі списку.');
                    return false;
                }

                // вставки
                var stick1 = $('input[name="tab_3_stick_1"]').val().trim().toLowerCase();
                var stick1_list = $('datalist#tab_3_stick_1 option').filter(function() {
                    return $(this).val().trim().toLowerCase() === stick1;
                }).length > 0;

                // Добавляем дополнительное условие: проверяем наличие значения stick1 в списке только если stick1 не пустое
                if (stick1 !== "") {
                    if (!stick1_list) {
                        alert('Оберіть вставу №1 зі списку.');
                        return false;
                    }
                }

                var stick2 = $('input[name="tab_3_stick_2"]').val().trim().toLowerCase();
                var stick2_list = $('datalist#tab_3_stick_2 option').filter(function() {
                    return $(this).val().trim().toLowerCase() === stick2;
                }).length > 0;

                // Добавляем дополнительное условие: проверяем наличие значения stick2 в списке только если stick2 не пустое
                if (stick2 !== "") {
                    if (!stick2_list) {
                        alert('Оберіть вставу №2 зі списку.');
                        return false;
                    }
                }

                var stick3 = $('input[name="tab_3_stick_3"]').val().trim().toLowerCase();
                var stick3_list = $('datalist#tab_3_stick_3 option').filter(function() {
                    return $(this).val().trim().toLowerCase() === stick3;
                }).length > 0;

                // Добавляем дополнительное условие: проверяем наличие значения stick3 в списке только если stick3 не пустое
                if (stick3 !== "") {
                    if (!stick3_list) {
                        alert('Оберіть вставу №3 зі списку.');
                        return false;
                    }
                }

                var stick4 = $('input[name="tab_3_stick_4"]').val().trim().toLowerCase();


                var stickCount1 = parseInt($('input[name="tab_3_stick_1_count"]').val().trim());
                var stickCount2 = parseInt($('input[name="tab_3_stick_2_count"]').val().trim());
                var stickCount3 = parseInt($('input[name="tab_3_stick_3_count"]').val().trim());
                var stickCount4 = parseInt($('input[name="tab_3_stick_4_count"]').val().trim());

                function checkStick(stick, stickCount, stickNumber) {
                    if (stick) {
                        if (!stickCount || stickCount < 1 || stickCount > 7) {
                            alert('Введіть кількість в діапазоні від 1 до 7 для вставки ' + stickNumber + '.');
                            return false;
                        }
                    }
                    return true;
                }

                // Использование функции для каждой вставки
                var isValidStick1 = checkStick(stick1, stickCount1, 1);
                var isValidStick2 = checkStick(stick2, stickCount2, 2);
                var isValidStick3 = checkStick(stick3, stickCount3, 3);
                var isValidStick4 = checkStick(stick4, stickCount4, 4);

                // Проверка всех вставок
                if (!isValidStick1 || !isValidStick2 || !isValidStick3 || !isValidStick4) {
                    return false;
                }


                function updateHiddenCounts(inputName, hiddenCountId) {
                    var enteredValue = $('input[name="' + inputName + '"]').val().trim(); // Получаем введенное значение
                    var selectedOption = $('datalist#' + inputName + ' option[value="' + enteredValue + '"]');

                    if (selectedOption.length > 0) {
                        var count = selectedOption.attr('data-count');
                        $('#' + hiddenCountId).val(count);
                    } else {
                        $('#' + hiddenCountId).val('');
                    }
                }

                // Слушатель события изменения значения в поле ввода
                $('input[name="tab_3_stick_1"]').on('input', function() {
                    updateHiddenCounts('tab_3_stick_1', 'tab_3_stick_1_hidden_count');
                });

                $('input[name="tab_3_stick_2"]').on('input', function() {
                    updateHiddenCounts('tab_3_stick_2', 'tab_3_stick_2_hidden_count');
                });

                $('input[name="tab_3_stick_3"]').on('input', function() {
                    updateHiddenCounts('tab_3_stick_3', 'tab_3_stick_3_hidden_count');
                });

                $('input[name="tab_3_stick_4"]').on('input', function() {
                    updateHiddenCounts('tab_3_stick_4', 'tab_3_stick_4_hidden_count');
                });

                updateHiddenCounts('tab_3_stick_1', 'tab_3_stick_1_hidden_count');
                updateHiddenCounts('tab_3_stick_2', 'tab_3_stick_2_hidden_count');
                updateHiddenCounts('tab_3_stick_3', 'tab_3_stick_3_hidden_count');
                updateHiddenCounts('tab_3_stick_4', 'tab_3_stick_4_hidden_count');

                var hiddenCount1 = parseInt($('#tab_3_stick_1_hidden_count').val().trim());
                var hiddenCount2 = parseInt($('#tab_3_stick_2_hidden_count').val().trim());
                var hiddenCount3 = parseInt($('#tab_3_stick_3_hidden_count').val().trim());
                var hiddenCount4 = parseInt($('#tab_3_stick_4_hidden_count').val().trim());

                if ((stickCount1 * enterCount) > hiddenCount1 || (stickCount2 * enterCount) > hiddenCount2 || (stickCount3 * enterCount) > hiddenCount3) {
                    // Определяем, какие вставки мало
                    var lackingSticks = [];
                    if ((stickCount1 * enterCount) > hiddenCount1) {
                        lackingSticks.push(stick1);
                    }
                    if ((stickCount2 * enterCount) > hiddenCount2) {
                        lackingSticks.push(stick2);
                    }
                    if ((stickCount3 * enterCount) > hiddenCount3) {
                        lackingSticks.push(stick3);
                    }

                    // Формируем сообщение о малом количестве вставок
                    var message = "Малое количество вставок: " + lackingSticks.join(", ");
                    alert(message);
                    return false;
                }

                var formData = $('#tab_3_form').serialize();

            });
        });
    </script>
    <div class="f w fw gap20 list_stock">
        <div class="f fc gap8 shadow pad8 _br8 f_300 h300M">
            <h3>
                Напівфабрикат
            </h3>
            <input type="text" autocomplete="off" name="" placeholder="Пошук посуду" id="tab_3_list_search" oninput="liveSearch('tab_3_list', this.value)">
            <ul id="tab_3_list" class="f fc gap8 h300M scroll">
                <?php
            $tab_3_list = CFS()->get('tab_3_list');

                // Проверяем наличие данных в списке
                if (!empty($tab_3_list)) {
                usort($tab_3_list, function($a, $b) {
                return $a['tab_3_count'] - $b['tab_3_count'];
                });

                foreach ($tab_3_list as $index => $tab_3_item) {
                ?>
                <li class="f fac gap8 list_item"
                    data-name="<?php echo $tab_3_item['tab_3_glass'] . ' ' . $tab_3_item['tab_3_insert']; ?>"
                    data-id="<?php echo $index + 1; ?>"
                    data-count="<?php echo $tab_3_item['tab_3_count']; ?>">
                        <span>
                            <?php echo $tab_3_item['tab_3_count']; ?>
                        </span>
                    <span class="c4">
                            <?php echo $tab_3_item['tab_3_glass']; ?>
                        </span>
                    <span class="c9">
                            <?php echo $tab_3_item['tab_3_insert']; ?>
                        </span>
                </li>
                <?php
                }
            } else {
                // Если список пуст, выводим соответствующее сообщение
                ?>
                <li class="f fac gap8 list_item">
                    <span>Пусто</span>
                </li>
                <?php
            }
            ?>
            </ul>
        </div>
        <div class="f fc gap8 shadow pad8 _br8 f_300 h300M">
            <h3>
                Вставка
            </h3>
            <input type="text" autocomplete="off" name="" placeholder="Пошук вставки" id="tab_3_search_list_stick" oninput="liveSearch('tab_3_list_stick', this.value)">
            <ul id="tab_3_list_stick" class="f fc gap8 h300M scroll">
                <?php
                $stick_list = CFS()->get('stick_list');

                if (!empty($stick_list)) {
                usort($stick_list, function($a, $b) {
                return $a['stick_count'] - $b['stick_count'];
                });

                foreach ($stick_list as $index => $stick_item) {
                ?>
                <li class="f fac gap8 list_item" data-name="<?php echo $stick_item['stick_name']; ?>" data-id="<?php echo $index + 1; ?>" data-count="<?php echo $stick_item['stick_count']; ?>">
                            <span>
                                <?php echo $stick_item['stick_count']; ?>
                            </span>
                    <span class="c10">
                                <?php echo $stick_item['stick_name']; ?>
                            </span>
                </li>
                <?php
                    }
                } else {
                ?>
                <li class="f fac gap8 list_item">Вставок немає</li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</section>
<!--ТАБ 4 (ПОКЛЕЙКА)-->
<section id="tab_4" class="tabs__block f fc gap60">
    <form action="<?php echo admin_url('admin-ajax.php'); ?>" id="tab_4_form" class="f fw w gap8 f_f" method="post">
        <!--Стекло-->
        <div class="f fc gap8 f_200">
            <div class="w BIG">
                Посуд
            </div>
            <div class="w f fc">
                <input type="text" autocomplete="off" name="tab_4_product" list="tab_4_product" id="tab_4_product_selected" placeholder="Оберіть посуд" class="shadow pad8" required/>
                <datalist id="tab_4_product" class="shadow">
                    <?php
                    $tab_4_list = CFS()->get('tab_4_list');

                    usort($tab_4_list, function($a, $b) {
                    return $a['tab_4_count'] - $b['tab_4_count'];
                    });

                    foreach ($tab_4_list as $index => $tab_4_item) {
                    ?>
                    <option data-id="<?php echo $index + 1; ?>"
                            data-count="<?php echo $tab_4_item['tab_4_count']; ?>"
                            data-glass="<?php echo $tab_4_item['tab_4_glass']; ?>"
                            data-insert="<?php echo $tab_4_item['tab_4_insert']; ?>"
                            data-stick="<?php
                                if (isset($tab_4_item['tab_4_stick_list']) && is_array($tab_4_item['tab_4_stick_list']) && count($tab_4_item['tab_4_stick_list']) > 0) {
                                    $tab_4_stick_list = $tab_4_item['tab_4_stick_list'];
                                    foreach ($tab_4_stick_list as $stick_item) {
                                        echo ' ( ' . $stick_item['tab_4_stick_count'] . ' - ' . $stick_item['tab_4_stick_name'] . ' ) ' ;
                                    }
                                }
                            ?>"

                            value="<?php echo $tab_4_item['tab_4_count'] . ' ' . $tab_4_item['tab_4_glass'] . ($tab_4_item['tab_4_insert'] ? ' ( ' . $tab_4_item['tab_4_insert'] . ' )' : ''); ?>">
                        <?php
                                if (isset($tab_4_item['tab_4_stick_list']) && is_array($tab_4_item['tab_4_stick_list']) && count($tab_4_item['tab_4_stick_list']) > 0) {
                        $tab_4_stick_list = $tab_4_item['tab_4_stick_list'];
                        foreach ($tab_4_stick_list as $stick_item) {
                        echo ' ( ' . $stick_item['tab_4_stick_count'] . ' - ' . $stick_item['tab_4_stick_name'] . ' ) ' ;
                        }
                        }
                        ?>
                    </option>
                    <?php
                    }
                    ?>
                </datalist>
            </div>
        </div>
        <!--К-сть-->
        <div class="f fc gap8 f_100">
            <div class="BIG">
                К-сть
            </div>
            <div class="shadow  h_50m f gap20 fac _br8 list_open">
                <input type="number" name="tab_4_count" id="tab_4_count" required/>
            </div>
        </div>
        <!--Специалист-->
        <div class="f fc gap8 f_200">
            <div class="w BIG">
                Працівник
            </div>
            <div class="w f fc">
                <input type="text" autocomplete="off" name="tab_4_master" list="tab_4_master" id="tab_4_master_selected" placeholder="Оберіть фахівця" class="shadow pad8" required/>
                <datalist id="tab_4_master" class="shadow">
                    <?php
                        $master_list_tab_4 = CFS()->get('master_list');

                    // Функция сравнения для блока tab_1_master
                    function compare_masters_tab_4($a, $b) {
                    $a_name = $a['master_name'];
                    $b_name = $b['master_name'];

                    // Сначала проверяем сортировку по кириллице
                    $result = strcoll($a_name, $b_name);

                    // Если строки равны по кириллице, используем сортировку по английскому
                    if ($result === 0) {
                    return strcmp($a_name, $b_name);
                    }

                    return $result;
                    }

                    // Сортировка массива для блока tab_1_master
                    usort($master_list_tab_4, 'compare_masters_tab_4');

                    foreach ($master_list_tab_4 as $index => $master_item) {
                    ?>
                    <option data-name="<?php echo $master_item['master_name']; ?>" data-id="<?php echo $index + 1; ?>" value="<?php echo $master_item['master_name']; ?>"></option>
                    <?php
                        }
                        ?>
                </datalist>
            </div>
        </div>
        <!--Скрытый-->
        <input type="hidden" name="action" value="tab_4_form_hidden">
        <!--Действие-->
        <div class="f fc gap8 f_250_10">
            <div class="w BIG">
                Дія
            </div>
            <div class="shadow f gap8 h_50m tab_4_buttons">
                <button class="btn btn_blue f_auto" name="Готове" type="submit">Готове</button>
                <button class="btn btn_red f_auto" name="Брак" type="submit">Брак</button>
                <button class="btn btn_black f_auto" name="Повернути" type="submit">Повернути</button>
            </div>
        </div>
        <!--Скрытый-->
        <input type="hidden" name="tab_4_glass_hidden" id="tab_4_glass_hidden">
        <input type="hidden" name="tab_4_count_hidden" id="tab_4_count_hidden">
        <input type="hidden" name="tab_4_insert_hidden" id="tab_4_insert_hidden">
        <input type="hidden" name="tab_4_stick_hidden" id="tab_4_stick_hidden">
        <input type="hidden" name="action" value="tab_4_form">
        <input type="hidden" name="tab_4_action" id="tab_4_action">
    </form>
    <!--скрипт-->
    <script>
        jQuery(function($) {
            $('.tab_4_buttons button').click(function(e) {
                var action = $(this).attr('name'); // Получаем значение атрибута name нажатой кнопки
                $('#tab_4_action').val(action); // Устанавливаем значение в скрытое поле

                var enteredValue = $('input[name="tab_4_product"]').val().trim(); // Получаем введенное значение
                var selectedOption = $('datalist#tab_4_product option[value="' + enteredValue + '"]');

                if (selectedOption.length > 0) {
                    // Получаем значения из выбранного элемента datalist и устанавливаем их в скрытые поля
                    var glass = selectedOption.attr('data-glass');
                    var count = selectedOption.attr('data-count');
                    var insert = selectedOption.attr('data-insert');
                    var stick = selectedOption.attr('data-stick'); // Получаем данные вставок

                    $('#tab_4_glass_hidden').val(glass);
                    $('#tab_4_count_hidden').val(count);
                    $('#tab_4_insert_hidden').val(insert);
                    $('#tab_4_stick_hidden').val(stick); // Устанавливаем данные вставок в скрытое поле
                } else {
                    // Если элемент не найден, очищаем скрытые поля
                    $('#tab_4_glass_hidden').val('');
                    $('#tab_4_count_hidden').val('');
                    $('#tab_4_insert_hidden').val('');
                    $('#tab_4_stick_hidden').val(''); // Очищаем данные вставок
                }

                var enteredGlass = $('input[name="tab_4_product"]').val().trim().toLowerCase();
                var isGlassExists = false;

                // Проверяем каждый элемент в datalist
                $('datalist#tab_4_product option').each(function() {
                    var currentGlassName = $(this).val().trim().toLowerCase();
                    if (currentGlassName === enteredGlass) {
                        // Проверяем наличие атрибута data-count
                        if ($(this).data('count') > 0) {
                            isGlassExists = true;
                            return false; // Прерываем цикл
                        }
                    }
                });

                if (!isGlassExists) {
                    alert('Виберіть посуд зі спіку');
                    return false; // Возвращаем false
                }

                var enterCount = $('input[name="tab_4_count"]').val().trim();
                if (!enterCount) {
                    alert('Оберіть кількість');
                    return false;
                }

                var enteredMaster = $('input[name="tab_4_master"]').val().trim().toLowerCase();
                var isMasterExists = $('datalist#tab_4_master option').filter(function() {
                    return $(this).val().trim().toLowerCase() === enteredMaster;
                }).length > 0;

                if (!isMasterExists) {
                    alert('Оберіть фахівця зі списку.');
                    return false;
                }

                // Если все проверки успешно пройдены, отправляем данные формы
                var formData = $('#tab_4_form').serialize();
            });
        });
    </script>
    <!--список-->
    <div class="f w fw gap20 list_stock">
        <div class="f fc gap8 shadow pad8 _br8 f_300 h300M">
            <h3>
                Поклейка
            </h3>
            <input type="text" autocomplete="off" name="" placeholder="Пошук посуду" id="tab_4_list_search" oninput="liveSearch('tab_4_list', this.value)">
            <ul id="tab_4_list" class="f fc gap8 h300M scroll">
                <?php
                $tab_4_list = CFS()->get('tab_4_list');

                // Проверяем наличие списка перед его использованием
                if (!empty($tab_4_list)) {
                // Сортируем список по полю tab_4_count
                usort($tab_4_list, function($a, $b) {
                return $a['tab_4_count'] - $b['tab_4_count'];
                });

                // Выводим каждый элемент списка
                foreach ($tab_4_list as $index => $tab_4_item) {
                ?>
                <li class="f fac gap8 list_item"
                    data-name="<?php echo isset($tab_4_item['tab_4_glass']) ? $tab_4_item['tab_4_glass'] . ' ' . $tab_4_item['tab_4_insert'] : ''; ?>"
                    data-id="<?php echo $index + 1; ?>"
                    data-count="<?php echo isset($tab_4_item['tab_4_count']) ? $tab_4_item['tab_4_count'] : ''; ?>">
                    <div>
                        <?php echo isset($tab_4_item['tab_4_count']) ? $tab_4_item['tab_4_count'] : ''; ?>
                    </div>
                    <div class="c4">
                        <?php echo isset($tab_4_item['tab_4_glass']) ? $tab_4_item['tab_4_glass'] : ''; ?>
                    </div>
                    <div class="c9">
                        <?php echo isset($tab_4_item['tab_4_insert']) ? $tab_4_item['tab_4_insert'] : ''; ?>
                    </div>
                    <?php if (isset($tab_4_item['tab_4_stick_list'])) : ?>
                    <ul class="f fac gap8">
                        <?php
                                    if (isset($tab_4_item['tab_4_stick_list']) && is_array($tab_4_item['tab_4_stick_list']) && count($tab_4_item['tab_4_stick_list']) > 0) {
                        $tab_4_stick_list = $tab_4_item['tab_4_stick_list'];
                        foreach ($tab_4_stick_list as $index => $stick_item) {
                        ?>
                        <li class="f fac gap8 c10">
                            <div>
                                <?php echo isset($stick_item['tab_4_stick_count']) ? $stick_item['tab_4_stick_count'] : ''; ?>
                            </div>
                            <div>
                                <?php echo isset($stick_item['tab_4_stick_name']) ? $stick_item['tab_4_stick_name'] : ''; ?>
                            </div>
                        </li>
                        <?php
                                        }
                                    }
                                    ?>
                    </ul>
                    <?php endif; ?>
                </li>
                <?php
                    }
                } else {
                    // Если список пуст, выводим сообщение "Пусто"
                    ?>
                <li class="f fac gap8 list_item">
                    <span>Пусто</span>
                </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</section>
<!--ТАБ 5 (ГОТОВОЕ)-->
<section id="tab_5" class="tabs__block f fc gap60">
    <form action="<?php echo admin_url('admin-ajax.php'); ?>" id="tab_5_form" class="f fw w gap8 f_f" method="post">
        <!--Стекло-->
        <div class="f fc gap8 f_200">
            <div class="w BIG">
                Продукт
            </div>
            <div class="w f fc">
                <input type="text" autocomplete="off" name="tab_5_product" list="tab_5_product" id="tab_5_product_selected" placeholder="Оберіть скло" class="shadow pad8" required/>
                <datalist id="tab_5_product" class="shadow">
                    <?php
                    $tab_5_list = CFS()->get('tab_5_list');

                    usort($tab_5_list, function($a, $b) {
                    return $a['tab_5_count'] - $b['tab_5_count'];
                    });

                    foreach ($tab_5_list as $index => $tab_5_item) {
                    ?>
                    <option data-id="<?php echo $index + 1; ?>"
                            data-count="<?php echo $tab_5_item['tab_5_count']; ?>"
                            data-glass="<?php echo $tab_5_item['tab_5_glass']; ?>"
                            data-insert="<?php echo $tab_5_item['tab_5_insert']; ?>"
                            data-stick="<?php
                                if (isset($tab_5_item['tab_5_stick_list']) && is_array($tab_5_item['tab_5_stick_list']) && count($tab_5_item['tab_5_stick_list']) > 0) {
                                    $tab_5_stick_list = $tab_5_item['tab_5_stick_list'];
                                    foreach ($tab_5_stick_list as $stick_item) {
                                        echo ' ( ' . $stick_item['tab_5_stick_count'] . ' - ' . $stick_item['tab_5_stick_name'] . ' ) ' ;
                                    }
                                }
                            ?>"

                            value="<?php echo $tab_5_item['tab_5_count'] . ' ' . $tab_5_item['tab_5_glass'] . ($tab_5_item['tab_5_insert'] ? ' ( ' . $tab_5_item['tab_5_insert'] . ' )' : ''); ?>">
                        <?php
                                if (isset($tab_5_item['tab_5_stick_list']) && is_array($tab_5_item['tab_5_stick_list']) && count($tab_5_item['tab_5_stick_list']) > 0) {
                        $tab_5_stick_list = $tab_5_item['tab_5_stick_list'];
                        foreach ($tab_5_stick_list as $stick_item) {
                        echo ' ( ' . $stick_item['tab_5_stick_count'] . ' - ' . $stick_item['tab_5_stick_name'] . ' ) ' ;
                        }
                        }
                        ?>
                    </option>
                    <?php
                    }
                    ?>

                </datalist>
            </div>
        </div>
        <!--К-сть-->
        <div class="f fc gap8 f_100">
            <div class="BIG">
                К-сть
            </div>
            <div class="shadow  h_50m f gap20 fac _br8 list_open">
                <input type="number" name="tab_5_count" id="tab_5_count" required/>
            </div>
        </div>
        <!--Специалист-->
        <div class="f fc gap8 f_200">
            <div class="w BIG">
                Працівник
            </div>
            <div class="w f fc">
                <input type="text" autocomplete="off" name="tab_5_master" list="tab_5_master" id="tab_5_master_selected" placeholder="Оберіть фахівця" class="shadow pad8" required/>
                <datalist id="tab_5_master" class="shadow">
                    <?php
                        $master_list_tab_5 = CFS()->get('master_list');

                    // Функция сравнения для блока tab_1_master
                    function compare_masters_tab_5($a, $b) {
                    $a_name = $a['master_name'];
                    $b_name = $b['master_name'];

                    // Сначала проверяем сортировку по кириллице
                    $result = strcoll($a_name, $b_name);

                    // Если строки равны по кириллице, используем сортировку по английскому
                    if ($result === 0) {
                    return strcmp($a_name, $b_name);
                    }

                    return $result;
                    }

                    // Сортировка массива для блока tab_1_master
                    usort($master_list_tab_5, 'compare_masters_tab_5');

                    foreach ($master_list_tab_5 as $index => $master_item) {
                    ?>
                    <option data-name="<?php echo $master_item['master_name']; ?>" data-id="<?php echo $index + 1; ?>" value="<?php echo $master_item['master_name']; ?>"></option>
                    <?php
                        }
                        ?>
                </datalist>
            </div>
        </div>
        <!--Действие-->
        <div class="f fc gap8 f_250_10">
            <div class="w BIG">
                Дія
            </div>
            <div class="shadow f gap8 h_50m tab_5_buttons">
                <button class="btn btn_blue f_auto" name="Продано" type="submit">Продано</button>
                <button class="btn btn_red f_auto" name="Брак" type="submit">Брак</button>
                <button class="btn btn_black f_auto" name="Повернути" type="submit">Повернути</button>
            </div>
        </div>
        <input type="hidden" name="tab_5_glass_hidden" id="tab_5_glass_hidden">
        <input type="hidden" name="tab_5_count_hidden" id="tab_5_count_hidden">
        <input type="hidden" name="tab_5_insert_hidden" id="tab_5_insert_hidden">
        <input type="hidden" name="tab_5_stick_hidden" id="tab_5_stick_hidden">
        <input type="hidden" name="action" value="tab_5_form">
        <input type="hidden" name="tab_5_action" id="tab_5_action">
    </form>
    <!--скрипт-->
    <script>
        jQuery(function($) {
            $('.tab_5_buttons button').click(function(e) {
                var action = $(this).attr('name'); // Получаем значение атрибута name нажатой кнопки
                $('#tab_5_action').val(action); // Устанавливаем значение в скрытое поле

                var enteredValue = $('input[name="tab_5_product"]').val().trim(); // Получаем введенное значение
                var selectedOption = $('datalist#tab_5_product option[value="' + enteredValue + '"]');

                if (selectedOption.length > 0) {
                    // Получаем значения из выбранного элемента datalist и устанавливаем их в скрытые поля
                    var glass = selectedOption.attr('data-glass');
                    var count = selectedOption.attr('data-count');
                    var insert = selectedOption.attr('data-insert');
                    var stick = selectedOption.attr('data-stick'); // Получаем данные вставок

                    $('#tab_5_glass_hidden').val(glass);
                    $('#tab_5_count_hidden').val(count);
                    $('#tab_5_insert_hidden').val(insert);
                    $('#tab_5_stick_hidden').val(stick); // Устанавливаем данные вставок в скрытое поле
                } else {
                    // Если элемент не найден, очищаем скрытые поля
                    $('#tab_5_glass_hidden').val('');
                    $('#tab_5_count_hidden').val('');
                    $('#tab_5_insert_hidden').val('');
                    $('#tab_5_stick_hidden').val(''); // Очищаем данные вставок
                }

                var enteredGlass = $('input[name="tab_5_product"]').val().trim().toLowerCase();
                var isGlassExists = false;

                // Проверяем каждый элемент в datalist
                $('datalist#tab_5_product option').each(function() {
                    var currentGlassName = $(this).val().trim().toLowerCase();
                    if (currentGlassName === enteredGlass) {
                        // Проверяем наличие атрибута data-count
                        if ($(this).data('count') > 0) {
                            isGlassExists = true;
                            return false; // Прерываем цикл
                        }
                    }
                });
                if (!isGlassExists) {
                    alert('Виберіть товар зі спіку');
                    return false; // Возвращаем false
                }

                var enterCount = $('input[name="tab_5_count"]').val().trim();
                if (!enterCount) {
                    alert('Оберіть кількість');
                    return false;
                }

                var enteredMaster = $('input[name="tab_5_master"]').val().trim().toLowerCase();
                var isMasterExists = $('datalist#tab_5_master option').filter(function() {
                    return $(this).val().trim().toLowerCase() === enteredMaster;
                }).length > 0;

                if (!isMasterExists) {
                    alert('Оберіть фахівця зі списку.');
                    return false;
                }

                // Если все проверки успешно пройдены, отправляем данные формы
                var formData = $('#tab_5_form').serialize();

                $.post(
                    '<?php echo admin_url('admin-ajax.php'); ?>',
                    formData,
                    function(res) {
                        // Выводим ответ сервера в консоль для отладки
                        console.log(res);
                        // Если ответ сервера содержит 'success', перезагружаем страницу
                        if (res === 'success') {
                            location.reload();
                        }
                    }
                );
            });
        });
    </script>
    <!--список-->
    <div class="f w fw gap20 list_stock">
        <div class="f fc gap8 shadow pad8 _br8 f_300 h300M">
            <h3>
                Готове
            </h3>
            <input type="text" autocomplete="off" name="" placeholder="Пошук товару" id="tab_5_list_search" oninput="liveSearch('tab_5_list', this.value)">
            <ul id="tab_5_list" class="f fc gap8 h300M scroll">
                <?php
                $tab_5_list = CFS()->get('tab_5_list');

                // Проверяем наличие данных в списке
                if (!empty($tab_5_list)) {
                usort($tab_5_list, function($a, $b) {
                return $a['tab_5_count'] - $b['tab_5_count'];
                });

                foreach ($tab_5_list as $index => $tab_5_item) {
                ?>
                <li class="f fac gap8 list_item"
                    data-name="<?php echo $tab_5_item['tab_5_glass'] . ' ' . $tab_5_item['tab_5_insert']; ?>"
                    data-id="<?php echo $index + 1; ?>"
                    data-count="<?php echo $tab_5_item['tab_5_count']; ?>">
                    <div>
                        <?php echo $tab_5_item['tab_5_count']; ?>
                    </div>
                    <div class="c4">
                        <?php echo $tab_5_item['tab_5_glass']; ?>
                    </div>
                    <div class="c9">
                        <?php echo $tab_5_item['tab_5_insert']; ?>
                    </div>
                    <ul class="f fac gap8">
                        <?php
                        $tab_5_stick_list = isset($tab_5_item['tab_5_stick_list']) ? $tab_5_item['tab_5_stick_list'] : array();

                        // Проверяем, есть ли вообще вставки
                        if (!empty($tab_5_stick_list)) {
                            // Сортируем вставки по количеству
                            usort($tab_5_stick_list, function($a, $b) {
                                return $a['tab_5_stick_count'] - $b['tab_5_stick_count'];
                            });

                            // Выводим каждую вставку
                            foreach ($tab_5_stick_list as $index => $stick_item) {
                        ?>
                        <li class="f fac gap8 c10">
                            <div>
                                <?php echo $stick_item['tab_5_stick_count']; ?>
                            </div>
                            <div>
                                <?php echo $stick_item['tab_5_stick_name']; ?>
                            </div>
                        </li>
                        <?php
                            }
                        }
                        ?>

                    </ul>
                </li>
                <?php
                    }
                } else {
                    // Если список пуст, выводим сообщение "Пусто"
                    ?>
                <li class="f fac gap8 list_item">
                    <span>Пусто</span>
                </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</section>
<!--ТАБ 6 (ОТЧЕТ)-->
<section id="tab_6" class="tabs__block f fc gap60">
    <!--Дата-->
    <div class="f w _f fac pad8t pad8b">
        <div class="calendar__body">
            <input type="text" id="dateRangeInput" readonly placeholder="Выберите диапазон">
            <div class="calendar-container" id="calendarContainer" style="display: none;">
            <div class="calendar-header">
                <button id="prevMonth">&lt;</button>
                <span id="currentMonth"></span>
                <button id="nextMonth">&gt;</button>
            </div>
            <div class="calendar-grid" id="calendarGrid"></div>
            </div>
        </div>
        <input id="search_date" type="date" name="дата">
    </div>
    <!--Фильтры поиска-->
    <div id="id_report_filter" class="w f gap2 f_f _b_b _b_t pad2">
        <div class=" f f_f fac pad4 _b_l _b_r id_report_filter_item filter_status">
            <input id="searchStatus" class="input_none_img" type="text" placeholder="Статус">
        </div>
        <div class=" f f_f fac pad4 _b_l _b_r id_report_filter_item filter_action">
            <input id="searchAction" class="input_none_img" type="text" placeholder="Дія">
        </div>
        <div class=" f f_f fac pad4 _b_l _b_r id_report_filter_item filter_name">
            <input id="searchName" class="input_none_img" type="text" placeholder="Найменування">
        </div>
        <div class=" f f_f fac pad4 _b_l _b_r id_report_filter_item filter_count">
            <input id="searchCount" class="input_none_img" type="text" placeholder="К-сть">
        </div>
        <div class=" f f_f fac pad4 _b_l _b_r id_report_filter_item filter_master">
            <input id="searchMaster" class="input_none_img" type="text" placeholder="Фахівець">
        </div>
        <div class=" f f_f fac pad4 _b_l _b_r id_report_filter_item filter_time">
            <input id="searchTime" class="input_none_img" type="text" placeholder="Час">
        </div>
    </div>
    <!--Перечень таблицы-->
    <ul id="id_report_post" class="w f gap4 f_f fc">
        <?php
    $tab_6_list = CFS()->get('tab_6_list');
        // Проверяем наличие данных в списке перед его использованием
        if (!empty($tab_6_list)) {
        $tab_6_list = array_reverse($tab_6_list);
        foreach ($tab_6_list as $index => $tab_6_item) {
        ?>
        <li data-id="<?php echo $index + 1; ?>" class="id_report_post_item gap2 fac _b_b _b_t b2 pad2">
            <div class="id_report_post_item_status pad2 _b_l _b_r id_report_post_column f fac">
                <?php if(isset($tab_6_item['tab_6_status'])): ?>
                <div class="tab_chapter">
                    <?php echo $tab_6_item['tab_6_status']; ?>
                </div>
                <div class="tab_6_img">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/<?php echo $tab_6_item['tab_6_status']; ?>.png" alt="<?php echo $tab_6_item['tab_6_status']; ?>">
                </div>
                <?php endif; ?>
            </div>
            <div class="id_report_post_item_action pad2 _b_l _b_r id_report_post_column f fac">
                <?php if(isset($tab_6_item['tab_6_action'])): ?>
                <?php echo $tab_6_item['tab_6_action']; ?>
                <?php endif; ?>
            </div>
            <div class="id_report_post_item_name pad2 _b_l _b_r id_report_post_column f fc">
                <div class="id_report_post_item_name__item">
                    <?php if(isset($tab_6_item['tab_6_name'])): ?>
                    <?php echo $tab_6_item['tab_6_name']; ?>
                    <?php endif; ?>
                </div>
                <div class="f gap5 fc id_report_post_item_name__stick">
                    <?php if(isset($tab_6_item['tab_6_stick_list']) && is_array($tab_6_item['tab_6_stick_list'])): ?>
                    <?php foreach ($tab_6_item['tab_6_stick_list'] as $stick_item): ?>
                    <span><?php echo $stick_item['tab_6_stick_count'] . ' - ' . $stick_item['tab_6_stick_name']; ?></span>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="id_report_post_item_count pad2 _b_l _b_r id_report_post_column f fac">
                <?php if(isset($tab_6_item['tab_6_count'])): ?>
                <?php echo $tab_6_item['tab_6_count']; ?>
                <?php endif; ?>
            </div>
            <div class="id_report_post_item_master pad2 _b_l _b_r id_report_post_column f fac">
                <?php if(isset($tab_6_item['tab_6_master'])): ?>
                <?php echo $tab_6_item['tab_6_master']; ?>
                <?php endif; ?>
            </div>
            <div class="id_report_post_item_time pad2 _b_l _b_r id_report_post_column f fac" data-date="<?php if(isset($tab_6_item['tab_6_date'])): ?><?php echo $tab_6_item['tab_6_date']; ?><?php endif; ?>">
                <?php if(isset($tab_6_item['tab_6_time'])): ?>
                <?php echo $tab_6_item['tab_6_time']; ?>
                <?php endif; ?>
            </div>
        </li>
        <?php
        }
    } else {
        // Если список пуст, выводим сообщение "Пусто"
        ?>
        <li class="f fac gap8 list_item">
            <span>Пусто</span>
        </li>
        <?php
    }
    ?>
    </ul>
    <!--excel-->
    <div id="excelForm">
        <div class="w f _f_ fac">
            <button id="exportToExcel" class="btn shadow f _f_ fac" type="submit" onclick="exportAndDownloadExcel()">
                <img class="h_50m" src="<?php echo get_template_directory_uri(); ?>/img/excel.png" alt="excel">
            </button>
        </div>
    </div>
</section>
<!--ТАБ 7 (РЕДАКТИРОВАНИЕ)-->
<section id="tab_7" class="tabs__block f fc gap60">
    <div class="f w fw gap60">

        <!-- Скло -->
        <form action="<?php echo admin_url('admin-ajax.php'); ?>" id="editing_glass_form" class="f fw w gap8 f_f" method="post">

            <div class="f fw w gap8 f_f f_600">
                <div class="f fw w gap8 f_f f_400">
                    <!--Стекло-->
                    <div class="f fc gap8 f_200">
                        <div class="w BIG">
                            Скло
                        </div>
                        <div class="w f fc">
                            <input  id="tab_7_glass_selected"
                                    type="text"
                                    name="tab_7_glass"
                                    list="tab_7_glass"
                                    placeholder="Оберіть скло"
                                    class="shadow pad8" autocomplete="off" required/>
                            <datalist id="tab_7_glass" class="shadow">
                                <?php
                            $glass_list = CFS()->get('glass_list');

                                // Функция для сортировки массива по значению glass_count
                                usort($glass_list, function($a, $b) {
                                return $a['glass_count'] - $b['glass_count'];
                                });

                                foreach ($glass_list as $index => $glass_item) {
                                ?>
                                <option
                                        data-id="<?php echo $index + 1; ?>"
                                        data-name="<?php echo $glass_item['glass_name']; ?>"
                                        data-count="<?php echo $glass_item['glass_count']; ?>"
                                        value="<?php echo $glass_item['glass_name']; ?>">
                                    <?php echo $glass_item['glass_count']; ?>
                                </option>
                                <?php
                            }
                            ?>
                            </datalist>
                        </div>
                    </div>
                    <!--К-сть-->
                    <div class="f fc gap8 f_80">
                        <div class="BIG">
                            К-сть
                        </div>
                        <div class="shadow  h_50m f gap20 fac _br8 list_open">
                            <input type="number" name="tab_7_glass_count" id="tab_7_glass_count" required/>
                        </div>
                    </div>
                </div>

                <!--Специалист-->
                <div class="f fc gap8 f_200">
                    <div class="w BIG">
                        Працівник
                    </div>
                    <div class="w f fc">
                        <input type="text" autocomplete="off" name="tab_7_glass_master" list="tab_7_glass_master" id="tab_7_glass_master_selected" placeholder="Оберіть фахівця" class="shadow pad8" required/>
                        <datalist id="tab_7_glass_master" class="shadow">
                            <?php
                        $master_list_glass = CFS()->get('master_list');

                            // Функция сравнения для блока tab_1_master
                            function compare_masters_glass($a, $b) {
                            $a_name = $a['master_name'];
                            $b_name = $b['master_name'];

                            // Сначала проверяем сортировку по кириллице
                            $result = strcoll($a_name, $b_name);

                            // Если строки равны по кириллице, используем сортировку по английскому
                            if ($result === 0) {
                            return strcmp($a_name, $b_name);
                            }

                            return $result;
                            }

                            // Сортировка массива для блока tab_1_master
                            usort($master_list_glass, 'compare_masters_glass');

                            foreach ($master_list_glass as $index => $master_item) {
                            ?>
                            <option data-name="<?php echo $master_item['master_name']; ?>" data-id="<?php echo $index + 1; ?>" value="<?php echo $master_item['master_name']; ?>"></option>
                            <?php
                        }
                        ?>
                        </datalist>
                    </div>
                </div>
            </div>
            <!--Действие-->
            <div class="f fc gap8 f_200">
                <div class="w BIG">
                    Дія
                </div>
                <div class="f fac gap8 glass_buttons">
                    <button class="btn f_auto shadow f _f_ fac" name="Додавання скла" type="submit">
                        <img class="img_act" src="<?php echo get_template_directory_uri(); ?>/img/item_plus.png">
                    </button>
                    <button class="btn f_auto shadow f _f_ fac" name="Віднімання скла" type="submit">
                        <img class="img_act" src="<?php echo get_template_directory_uri(); ?>/img/item_minus.png">
                    </button>
                    <?php if (current_user_can('administrator') || current_user_can('subscriber')) { ?>
                    <button class="btn f_auto shadow f _f_ fac" name="Створення скла" type="submit">
                        <img class="img_act" src="<?php echo get_template_directory_uri(); ?>/img/item_new.png">
                    </button>
                    <button class="btn f_auto shadow f _f_ fac" name="Видалення скла" type="submit">
                        <img class="img_act" src="<?php echo get_template_directory_uri(); ?>/img/item_delete.png">
                    </button>
                    <?php } ?>
                </div>
            </div>
            <!--Тип запроса-->
            <input type="hidden" name="action" value="glass_form">
            <input type="hidden" name="glass_action" id="glass_action">

        </form>
        <script>
            jQuery(function($) {
                $('.glass_buttons button').click(function(e) {
                    var action = $(this).attr('name');
                    $('#glass_action').val(action);

                    var enteredMaster = $('input[name="tab_7_glass_master"]').val().trim().toLowerCase();

                    var isMasterExists = false;
                    $('datalist#tab_7_glass_master option').each(function() {
                        var currentMaster = $(this).val().trim().toLowerCase();
                        if (currentMaster === enteredMaster) {
                            isMasterExists = true;
                            return false;
                        }
                    });

                    if (!isMasterExists) {
                        alert('Оберіть фахівця зі списку.');
                        return false;
                    }


                    if (action === 'Віднімання скла') {
                        var enteredGlassCount = parseInt($('#tab_7_glass_count').val()); // Получаем количество введенного стекла
                        var selectedGlassCount = parseInt($('#tab_7_glass_selected').attr('data-count')); // Получаем количество стекла из атрибута data-count

                        // Проверяем, чтобы количество введенного стекла не превышало количество доступного стекла
                        if (enteredGlassCount > selectedGlassCount) {
                            alert('Кількість введеного скла не може перевищувати кількість доступного скла.');
                            e.preventDefault(); // Отменяем стандартное действие кнопки
                        }

                        var enteredGlass = $('input[name="tab_7_glass"]').val().trim().toLowerCase();

                        var isGlassExists = false;
                        var enteredGlassLower = enteredGlass.toLowerCase();
                        $('datalist#tab_7_glass option').each(function() {
                            var currentGlassName = $(this).val().trim().toLowerCase();
                            if (currentGlassName === enteredGlassLower) {
                                isGlassExists = true;
                                return false;
                            }
                        });

                        if (!isGlassExists) {
                            alert('Оберіть скло зі списку.');
                            return false; // Завершаем обработчик
                        }
                    } else if (action === 'Видалення скла') {
                        document.getElementById('tab_7_glass_count').removeAttribute('required');
                        var enteredGlass = $('input[name="tab_7_glass"]').val().trim().toLowerCase();

                        var isGlassExists = false;
                        var enteredGlassLower = enteredGlass.toLowerCase();
                        $('datalist#tab_7_glass option').each(function() {
                            var currentGlassName = $(this).val().trim().toLowerCase();
                            if (currentGlassName === enteredGlassLower) {
                                isGlassExists = true;
                                return false;
                            }
                        });

                        if (!isGlassExists) {
                            alert('Оберіть скло зі списку.');
                            return false; // Завершаем обработчик
                        }
                    } else if (action === 'Додавання скла') {
                        var enteredGlass = $('input[name="tab_7_glass"]').val().trim().toLowerCase();

                        var isGlassExists = false;
                        $('datalist#tab_7_glass option').each(function() {
                            var currentGlassName = $(this).val().trim().toLowerCase();
                            if (currentGlassName === enteredGlass) {
                                isGlassExists = true;
                                return false;
                            }
                        });

                        if (!isGlassExists) {
                            alert('Оберіть скло зі списку.');
                            return false; // Завершаем обработчик
                        }
                    } else if (action === 'Створення скла') {
                        var enteredGlass = $('input[name="tab_7_glass"]').val().trim().toLowerCase();

                        var isNewGlassExists = false;
                        var enteredGlassLower = enteredGlass.toLowerCase();
                        $('datalist#tab_7_glass option').each(function() {
                            var currentGlassName = $(this).val().trim().toLowerCase();
                            if (currentGlassName === enteredGlassLower) {
                                isNewGlassExists = true;
                                return false;
                            }
                        });

                        if (isNewGlassExists) {
                            alert('Скло вже існує.');
                            return false;
                        }
                    }

                    var formData = $('#editing_glass_form').serialize();

                });
            });
        </script>

 <!-- Виїмка -->
<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="editing_insert_form" class="f fw w gap8 f_f" method="post">
    <div class="f fw w gap8 f_f f_600">
        <!--Виемка-->
        <div class="f fc gap8 f_400">
            <div class="BIG">
                Виїмка
            </div>
            <div class="w f fc">
                <input type="text" autocomplete="off" name="tab_7_insert" list="tab_7_insert" id="tab_7_insert_selected" placeholder="Оберіть виїмку" class="shadow pad8" required/>
                <datalist id="tab_7_insert" class="shadow">
                    <?php
                    $insert_list = CFS()->get('insert_list');
                    foreach ($insert_list as $index => $insert_item) {
                    ?>
                        <option data-name="<?php echo strtolower($insert_item['insert_name']); ?>" data-id="<?php echo $index + 1; ?>" value="<?php echo strtolower($insert_item['insert_name']); ?>"></option>
                    <?php
                    }
                    ?>
                </datalist>
            </div>
        </div>
        <!--Специалист-->
        <div class="f fc gap8 f_200">
            <div class="w BIG">
                Працівник
            </div>
            <div class="w f fc">
                <input type="text" autocomplete="off" name="tab_7_insert_master" list="tab_7_insert_master" id="tab_7_insert_master_selected" placeholder="Оберіть фахівця" class="shadow pad8" required/>
                <datalist id="tab_7_insert_master" class="shadow">
                    <?php
                    $master_list_insert = CFS()->get('master_list');
                    
                    function compare_masters_insert($a, $b) {
                        $a_name = $a['master_name'];
                        $b_name = $b['master_name'];
                        $result = strcoll($a_name, $b_name);
                        if ($result === 0) {
                            return strcmp($a_name, $b_name);
                        }
                        return $result;
                    }
                    
                    usort($master_list_insert, 'compare_masters_insert');
                    
                    foreach ($master_list_insert as $index => $master_item) {
                    ?>
                        <option data-name="<?php echo strtolower($master_item['master_name']); ?>" data-id="<?php echo $index + 1; ?>" value="<?php echo strtolower($master_item['master_name']); ?>"></option>
                    <?php
                    }
                    ?>
                </datalist>
            </div>
        </div>
    </div>
    <input type="hidden" name="action" value="insert_form">
    <div class="f fc gap8 f_200">
        <div class="w BIG">
            Дія
        </div>
        <div class="f fac gap8 insert_buttons">
            <?php if (current_user_can('administrator') || current_user_can('subscriber')) { ?>
            <button class="btn f_auto shadow f _f_ fac" name="Створення виїмки" type="submit">
                <img class="img_act" src="<?php echo get_template_directory_uri(); ?>/img/item_new.png">
            </button>
            <button class="btn f_auto shadow f _f_ fac" name="Видалення виїмки" type="submit">
                <img class="img_act" src="<?php echo get_template_directory_uri(); ?>/img/item_delete.png">
            </button>
            <?php } ?>
        </div>
    </div>
    <input type="hidden" name="insert_action" id="insert_action">
</form>
<script>
    jQuery(function($) {
        $('.insert_buttons button').click(function(e) {
            e.preventDefault(); // Предотвращаем отправку формы по умолчанию
            var action = $(this).attr('name'); // Получаем значение атрибута name нажатой кнопки
            $('#insert_action').val(action); // Устанавливаем значение в скрытое поле

            var enteredMaster = $('input[name="tab_7_insert_master"]').val().trim().toLowerCase();
            var isMasterExists = false;
            $('datalist#tab_7_insert_master option').each(function() {
                var currentMaster = $(this).val().trim().toLowerCase();
                if (currentMaster === enteredMaster) {
                    isMasterExists = true;
                    return false;
                }
            });

            if (!isMasterExists) {
                alert('Оберіть фахівця зі списку.');
                return false;
            }

            var enteredInsert = $('input[name="tab_7_insert"]').val().trim().toLowerCase();
            if (action === 'Видалення виїмки') {
                var isInsertExists = false;
                $('datalist#tab_7_insert option').each(function() {
                    var currentInsertName = $(this).val().trim().toLowerCase();
                    if (currentInsertName === enteredInsert) {
                        isInsertExists = true;
                        return false;
                    }
                });

                if (!isInsertExists) {
                    alert('Оберіть виїмку зі списку.');
                    return false;
                }
            } else if (action === 'Створення виїмки') {
                var isNewInsertExists = false;
                $('datalist#tab_7_insert option').each(function() {
                    var currentInsertName = $(this).val().trim().toLowerCase();
                    if (currentInsertName === enteredInsert) {
                        isNewInsertExists = true;
                        return false;
                    }
                });

                if (isNewInsertExists) {
                    alert('Виїмка вже існує.');
                    return false;
                }
            }

            // Приведение значений input к нижнему регистру перед отправкой формы
            $('input[name="tab_7_insert"], input[name="tab_7_insert_master"]').each(function() {
                $(this).val($(this).val().toLowerCase());
            });

            $('#editing_insert_form').submit(); // Отправляем форму после всех проверок
        });
    });
</script>





        <!-- Вставка -->
        <form action="<?php echo admin_url('admin-ajax.php'); ?>" id="editing_stick_form" class="f fw w gap8 f_f" method="post">
            <div class="f fw w gap8 f_f f_600">
                <div class="f fw w gap8 f_f f_400">
                    <!--Вставки-->
                    <div class="f fc gap8 f_200">
                        <div class="BIG">
                            Вставка
                        </div>
                        <div class="w f fc">
                            <input id="tab_7_stick_selected"
                                   type="text"
                                   name="tab_7_stick"
                                   list="tab_7_stick"
                                   placeholder="Оберіть виїмку"
                                   class="shadow pad8"
                                   autocomplete="off"
                                   required/>
                            <datalist
                                    id="tab_7_stick"
                                    class="shadow">
                                <?php
                                $stick_list = CFS()->get('stick_list');

                                usort($stick_list, function($a, $b) {
                                return $a['stick_count'] - $b['stick_count'];
                                });

                                foreach ($stick_list as $index => $stick_item) {
                                ?>
                                <option
                                        data-name="<?php echo $stick_item['stick_name']; ?>"
                                        data-id="<?php echo $index + 1; ?>"
                                        data-count="<?php echo $stick_item['stick_count']; ?>"
                                        value="<?php echo $stick_item['stick_name']; ?>">
                                    <?php echo $stick_item['stick_count']; ?>
                                </option>
                                <?php
                            }
                            ?>
                            </datalist>
                        </div>
                    </div>
                    <!--К-сть-->
                    <div class="f fc gap8 f_80">
                        <div class="BIG">
                            К-сть
                        </div>
                        <div class="shadow  h_50m f gap20 fac _br8 list_open">
                            <input type="number" name="tab_7_stick_count" id="tab_7_stick_count" required/>
                        </div>
                    </div>
                </div>
                <!--Специалист-->
                <div class="f fc gap8 f_200">
                    <div class="w BIG">
                        Працівник
                    </div>
                    <div class="w f fc">
                        <input type="text" autocomplete="off" name="tab_7_stick_master" list="tab_7_stick_master" id="tab_7_stick_master_selected" placeholder="Оберіть фахівця" class="shadow pad8" required/>
                        <datalist id="tab_7_stick_master" class="shadow">
                            <?php
                        $master_list_stick = CFS()->get('master_list');

                            // Функция сравнения для блока tab_1_master
                            function compare_masters_stick($a, $b) {
                            $a_name = $a['master_name'];
                            $b_name = $b['master_name'];

                            // Сначала проверяем сортировку по кириллице
                            $result = strcoll($a_name, $b_name);

                            // Если строки равны по кириллице, используем сортировку по английскому
                            if ($result === 0) {
                            return strcmp($a_name, $b_name);
                            }

                            return $result;
                            }

                            // Сортировка массива для блока tab_1_master
                            usort($master_list_stick, 'compare_masters_stick');

                            foreach ($master_list_stick as $index => $master_item) {
                            ?>
                            <option data-name="<?php echo $master_item['master_name']; ?>" data-id="<?php echo $index + 1; ?>" value="<?php echo $master_item['master_name']; ?>"></option>
                            <?php
                        }
                        ?>
                        </datalist>
                    </div>
                </div>
            </div>
            <!--Действие-->
            <div class="f fc gap8 f_200">
                <div class="w BIG">
                    Дія
                </div>
                <div class="f fac gap8 stick_buttons">
                    <button class="btn f_auto shadow f _f_ fac" name="Додавання вставки" type="submit">
                        <img class="img_act" src="<?php echo get_template_directory_uri(); ?>/img/item_plus.png">
                    </button>
                    <button class="btn f_auto shadow f _f_ fac" name="Віднімання вставки" type="submit">
                        <img class="img_act" src="<?php echo get_template_directory_uri(); ?>/img/item_minus.png">
                    </button>
                    <?php if (current_user_can('administrator') || current_user_can('subscriber')) { ?>
                    <button class="btn f_auto shadow f _f_ fac" name="Створення вставки" type="submit">
                        <img class="img_act" src="<?php echo get_template_directory_uri(); ?>/img/item_new.png">
                    </button>
                    <button class="btn f_auto shadow f _f_ fac" name="Видалення вставки" type="submit">
                        <img class="img_act" src="<?php echo get_template_directory_uri(); ?>/img/item_delete.png">
                    </button>
                    <?php } ?>
                </div>
            </div>
            <!--Тип запроса-->
            <input type="hidden" name="action" value="stick_form">
            <input type="hidden" name="stick_action" id="stick_action">
        </form>
        <script>
            jQuery(function($) {
                $('.stick_buttons button').click(function(e) {
                    var action = $(this).attr('name'); // Получаем значение атрибута name нажатой кнопки
                    $('#stick_action').val(action); // Устанавливаем значение в скрытое поле

                    if (action === 'Віднімання вставки') {
                        var enteredStickCount = parseInt($('#tab_7_stick_count').val()); // Получаем количество введенного стекла
                        var selectedStickCount = parseInt($('#tab_7_stick_selected').attr('data-count')); // Получаем количество стекла из атрибута data-count

                        // Проверяем, чтобы количество введенного стекла не превышало количество доступного стекла
                        if (enteredStickCount > selectedStickCount) {
                            alert('Кількість введених вставок не може перевищувати кількість доступного скла.');
                            e.preventDefault(); // Отменяем стандартное действие кнопки
                        }
                    }

                    var enteredMaster = $('input[name="tab_7_stick_master"]').val().trim(); // Получаем значение выбранного специалиста

                    var isMasterExists = false;
                    $('datalist#tab_7_stick_master option').each(function() {
                        var currentMaster = $(this).val().trim();
                        if (currentMaster === enteredMaster) {
                            isMasterExists = true;
                            return false; // Прерываем цикл, так как совпадение найдено
                        }
                    });

                    if (!isMasterExists) {
                        alert('Оберіть спеціаліста зі списку.');
                        return false; // Завершаем обработчик
                    }


                    // Проверяем, нужно ли применять проверку наличия стекла в списке
                    if (action === 'Віднімання вставки' || action === 'Додавання вставки' || action === 'Видалення вставки') {
                        var enteredStick = $('input[name="tab_7_stick"]').val().trim(); // Получаем значение введенного стекла

                        var isStickExists = false;
                        var enteredStickLower = enteredStick.toLowerCase(); // Приводим введенное значение стекла к нижнему регистру
                        $('datalist#tab_7_stick option').each(function() {
                            var currentStickName = $(this).val().trim().toLowerCase(); // Приводим текущее значение стекла к нижнему регистру
                            if (currentStickName === enteredStickLower) {
                                isStickExists = true;
                                return false; // Прерываем цикл, так как совпадение найдено
                            }
                        });

                        if (!isStickExists) {
                            alert('Оберіть вставку зі списку.');
                            return false; // Завершаем обработчик
                        }
                    } else if (action === 'Створення вставки') {
                        // Ваш код для действия "Нове скло"
                        // Например, проверка на отсутствие стекла с таким же названием
                        var enteredStick = $('input[name="tab_7_stick"]').val().trim();

                        var isNewStickExists = false;
                        var enteredStickLower = enteredStick.toLowerCase(); // Приводим введенное значение стекла к нижнему регистру
                        $('datalist#tab_7_stick option').each(function() {
                            var currentStickName = $(this).val().trim().toLowerCase(); // Приводим текущее значение стекла к нижнему регистру
                            if (currentStickName === enteredStickLower) {
                                isNewStickExists = true;
                                return false; // Прерываем цикл, так как совпадение найдено
                            }
                        });

                        if (isNewStickExists) {
                            alert('Вставка вже існує.');
                            return false; // Завершаем обработчик
                        }
                    }

                    if (action === 'Видалення вставки') {
                        document.getElementById('tab_7_stick_count').removeAttribute('required');
                    }

                    // Если все проверки успешно пройдены, отправляем данные формы
                    var formData = $('#editing_stick_form').serialize();

                });
            });
        </script>

        <!-- Фахівець -->
        <form action="<?php echo admin_url('admin-ajax.php'); ?>" id="editing_master_form" class="f fw w gap8 f_f" method="post">
            <div class="f fw w gap8 f_f f_600">
                <!--Специалист-->
                <div class="f fc gap8 f_400">
                    <div class="w BIG">
                        П.І.Б
                    </div>
                    <div class="w f fc">
                        <input type="text" autocomplete="off" name="tab_7_name" list="tab_7_name" id="tab_7_name_selected" placeholder="Оберіть фахівця" class="shadow pad8" required/>
                        <datalist id="tab_7_name" class="shadow">
                            <?php
                        $master_list_name = CFS()->get('master_list');

                            function compare_masters($a, $b) {
                            $a_name = $a['master_name'];
                            $b_name = $b['master_name'];

                            $result = strcoll($a_name, $b_name);

                            if ($result === 0) {
                            return strcmp($a_name, $b_name);
                            }

                            return $result;
                            }

                            usort($master_list_name, 'compare_masters');

                            foreach ($master_list_name as $index => $master_item) {
                            ?>
                            <option
                                    data-name="<?php echo $master_item['master_name']; ?>"
                                    data-id="<?php echo $index + 1; ?>"
                                    value="<?php echo $master_item['master_name']; ?>">
                            </option>
                            <?php
                        }
                        ?>
                        </datalist>
                    </div>
                </div>
                <!--Специалист-->
                <div class="f fc gap8 f_200">
                    <div class="w BIG">
                        Працівник
                    </div>
                    <div class="w f fc">
                        <input type="text" autocomplete="off" name="tab_7_name_master" list="tab_7_name_master" id="tab_7_name_master_selected" placeholder="Оберіть фахівця" class="shadow pad8" required/>
                        <datalist id="tab_7_name_master" class="shadow">
                            <?php
                            $master_list_master = CFS()->get('master_list');

                            function compare_masters_master($a, $b) {
                            $a_name = $a['master_name'];
                            $b_name = $b['master_name'];

                            $result = strcoll($a_name, $b_name);

                            if ($result === 0) {
                            return strcmp($a_name, $b_name);
                            }

                            return $result;
                            }

                            usort($master_list_master, 'compare_masters_master');

                            foreach ($master_list_master as $index => $master_item) {
                            ?>
                            <option data-name="<?php echo $master_item['master_name']; ?>" data-id="<?php echo $index + 1; ?>" value="<?php echo $master_item['master_name']; ?>"></option>
                            <?php
                        }
                        ?>
                        </datalist>
                    </div>
                </div>
            </div>
            <!--Скрытый-->
            <input type="hidden" name="action" value="master_form">
            <!--Действие-->
            <div class="f fc gap8 f_200">
                <div class="w BIG">
                    Дія
                </div>
                <div class="f fac gap8 masters_buttons">
                    <?php if (current_user_can('administrator') || current_user_can('subscriber')) { ?>
                    <button class="btn f_auto shadow f _f_ fac" name="Створення фахівця" type="submit">
                        <img class="img_act" src="<?php echo get_template_directory_uri(); ?>/img/item_new.png">
                    </button>
                    <button class="btn f_auto shadow f _f_ fac" name="Видалення фахівця" type="submit">
                        <img class="img_act" src="<?php echo get_template_directory_uri(); ?>/img/item_delete.png">
                    </button>
                    <?php } ?>
                </div>
            </div>
            <!--Тип запроса-->
            <input type="hidden" name="master_action" id="master_action">
        </form>
        <script>
            jQuery(function($) {
                $('.masters_buttons button').click(function(e) {
                    var action = $(this).attr('name'); // Получаем значение атрибута name нажатой кнопки
                    $('#master_action').val(action); // Устанавливаем значение в скрытое поле

                    var enteredMaster = $('input[name="tab_7_name_master"]').val().trim();

                    var isMasterExists = false;
                    $('datalist#tab_7_name_master option').each(function() {
                        var currentMaster = $(this).val().trim();
                        if (currentMaster === enteredMaster) {
                            isMasterExists = true;
                            return false;
                        }
                    });

                    if (!isMasterExists) {
                        alert('Оберіть фахівця зі списку.');
                        return false; // Завершаем обработчик
                    }

                    if (action === 'Створення фахівця') {
						var enteredName = $('input[name="tab_7_name"]').val().trim().toLowerCase();

						if (enteredName === '') {
							alert('Введіть П.І.Б. для створення.');
							return false; // Завершаем обработчик
						}

						var isNameExists = $('datalist#tab_7_name option').filter(function() {
							return $(this).val().toLowerCase() === enteredName;
						}).length > 0;

						if (isNameExists) {
							alert('П.І.Б. вже існує.');
							return false; // Завершаем обработчик
						}
                    } else if (action === 'Видалення фахівця') {
                        var enteredName = $('input[name="tab_7_name"]').val().trim();

                        // Проверяем, ввел ли пользователь какое-либо значение П.І.Б.
                        if (enteredName === '') {
                            alert('Введіть П.І.Б. для видалення.');
                            return false;
                        }

                        var isNameExists = false;
                        $('datalist#tab_7_name option').each(function() {
                            var currentName = $(this).val().trim();
                            if (currentName === enteredName) {
                                isNameExists = true;
                                return false; // Прерываем цикл, так как совпадение найдено
                            }
                        });

                        if (!isNameExists) {
                            alert('Оберіть П.І.Б. зі списку.');
                            return false; // Завершаем обработчик
                        }
                    }

					var formData = $('#editing_master_form').serialize();

                });
            });
        </script>

    </div>

    <!-- Списки склада-->
    <div class="f w fw gap20 list_stock">
        <div class="f fc gap8 shadow pad8 _br8 f_300 h300M">
            <h3>
                Скло
            </h3>
            <input type="text" autocomplete="off" name="" placeholder="Пошук скла" id="tab_7_search_list_glass" oninput="liveSearch('tab_7_list_glass', this.value)">
            <ul id="tab_7_list_glass" class="f fc gap8 h300M scroll">
                <?php
                $glass_list = CFS()->get('glass_list');

                // Проверяем наличие данных в списке перед его использованием
                if (!empty($glass_list)) {
                // Функция для сортировки массива по значению glass_count
                usort($glass_list, function($a, $b) {
                return $a['glass_count'] - $b['glass_count'];
                });

                // Выводим элементы списка, если данные присутствуют
                foreach ($glass_list as $index => $glass_item) {
                ?>
                <li class="f fac gap8 list_item" data-name="<?php echo $glass_item['glass_name']; ?>" data-id="<?php echo $index + 1; ?>" data-count="<?php echo $glass_item['glass_count']; ?>">
                            <span>
                                <?php echo $glass_item['glass_count']; ?>
                            </span>
                    <span class="c4">
                                <?php echo $glass_item['glass_name']; ?>
                            </span>
                </li>
                <?php
                    }
                } else {
                    // Если список пуст, выводим сообщение "Пусто"
                    ?>
                <li class="f fac gap8 list_item">
                    <span>Немає Скла</span>
                </li>
                <?php
                }
                ?>
            </ul>
        </div>
        <div class="f fc gap8 shadow pad8 _br8 f_300 h300M">
            <h3>
                Виїмка
            </h3>
            <input type="text" autocomplete="off" name="" placeholder="Пошук виїмки" id="tab_7_search_list_insert" oninput="liveSearch('tab_7_list_insert', this.value)">
            <ul id="tab_7_list_insert" class="f fc gap8 h300M scroll">
                <?php
                $insert_list = CFS()->get('insert_list');

                // Проверяем наличие данных в списке перед его использованием
                if (!empty($insert_list)) {
                foreach ($insert_list as $index => $insert_item) {
                ?>
                <li class="f fac gap8 list_item c9" data-name="<?php echo $insert_item['insert_name']; ?>" data-id="<?php echo $index + 1; ?>">
                    <?php echo $insert_item['insert_name']; ?>
                </li>
                <?php
                    }
                } else {
                    // Если список пуст, выводим сообщение "Пусто"
                    ?>
                <li class="f fac gap8 list_item c9">
                    <span>Немає виїмок</span>
                </li>
                <?php
                }
                ?>
            </ul>

        </div>
        <div class="f fc gap8 shadow pad8 _br8 f_300 h300M">
            <h3>
                Вставка
            </h3>
            <input type="text" autocomplete="off" name="" placeholder="Пошук вставки" id="tab_7_search_list_stick" oninput="liveSearch('tab_7_list_stick', this.value)">
            <ul id="tab_7_list_stick" class="f fc gap8 h300M scroll">
                <?php
                $stick_list = CFS()->get('stick_list');

                // Проверяем наличие вставок в списке
                if (!empty($stick_list)) {
                // Сортируем список по количеству вставок
                usort($stick_list, function($a, $b) {
                return $a['stick_count'] - $b['stick_count'];
                });

                foreach ($stick_list as $index => $stick_item) {
                ?>
                <li class="f fac gap8 list_item" data-name="<?php echo $stick_item['stick_name']; ?>" data-id="<?php echo $index + 1; ?>" data-count="<?php echo $stick_item['stick_count']; ?>">
                            <span>
                                <?php echo $stick_item['stick_count']; ?>
                            </span>
                    <span class="c10">
                                <?php echo $stick_item['stick_name']; ?>
                            </span>
                </li>
                <?php
                    }
                } else {
                    // Если список пуст, выводим сообщение "Пусто"
                    ?>
                <li class="f fac gap8 list_item c10">
                    <span>Немає вставок</span>
                </li>
                <?php
                }
                ?>
            </ul>

        </div>
    </div>
    <!-- Списки табов-->
    <div class="f w fw gap20 list_stock">
        <div class="f fw w gap20">
            <div class="f fc gap8 shadow pad8 _br8 f_300 h300M">
                <h3>
                    В печі
                </h3>
                <input type="text" autocomplete="off" name="" placeholder="Пошук скла" id="tab_7_tab_2_list_search" oninput="liveSearch('tab_7_tab_2_list', this.value)">
                <ul id="tab_7_tab_2_list" class="f fc gap8 h300M scroll">
                    <?php
    $tab_2_list = CFS()->get('tab_2_list');

                    // Проверяем наличие данных в списке
                    if (!empty($tab_2_list)) {
                    usort($tab_2_list, function($a, $b) {
                    return $a['tab_2_count'] - $b['tab_2_count'];
                    });

                    foreach ($tab_2_list as $index => $tab_2_item) {
                    ?>
                    <li class="f fac gap8 list_item"
                        data-name="<?php echo $tab_2_item['tab_2_glass'] . ' ' . $tab_2_item['tab_2_insert']; ?>"
                        data-id="<?php echo $index + 1; ?>"
                        data-count="<?php echo $tab_2_item['tab_2_count']; ?>">
        <span>
            <?php echo $tab_2_item['tab_2_count']; ?>
        </span>
                        <span class="c4">
            <?php echo $tab_2_item['tab_2_glass']; ?>
        </span>
                        <span class="c9">
            <?php if (isset($tab_2_item['tab_2_insert'])) {
                echo $tab_2_item['tab_2_insert'];
            } ?>
        </span>
                    </li>
                    <?php
    }
    } else {
    // Если список пуст, выводим соответствующее сообщение
    ?>
                    <li class="f fac gap8 list_item">
                        <span>Пусто</span>
                    </li>
                    <?php
    }
    ?>
                </ul>
            </div>
            <div class="f fc gap8 shadow pad8 _br8 f_300 h300M">
                <h3>
                    Напівфабрикат
                </h3>
                <input type="text" autocomplete="off" name="" placeholder="Пошук посуду" id="tab_7_tab_3_list_search" oninput="liveSearch('tab_7_tab_3_list', this.value)">
                <ul id="tab_7_tab_3_list" class="f fc gap8 h300M scroll">
                    <?php
    $tab_3_list = CFS()->get('tab_3_list');

                    // Проверяем наличие данных в списке
                    if (!empty($tab_3_list)) {
                    usort($tab_3_list, function($a, $b) {
                    return $a['tab_3_count'] - $b['tab_3_count'];
                    });

                    foreach ($tab_3_list as $index => $tab_3_item) {
                    ?>
                    <li class="f fac gap8 list_item"
                        data-name="<?php echo $tab_3_item['tab_3_glass'] . ' ' . $tab_3_item['tab_3_insert']; ?>"
                        data-id="<?php echo $index + 1; ?>"
                        data-count="<?php echo $tab_3_item['tab_3_count']; ?>">
    <span>
        <?php echo $tab_3_item['tab_3_count']; ?>
    </span>
                        <span class="c4">
        <?php echo $tab_3_item['tab_3_glass']; ?>
    </span>
                        <span class="c9">
        <?php echo $tab_3_item['tab_3_insert']; ?>
    </span>
                    </li>
                    <?php
    }
    } else {
    // Если список пуст, выводим соответствующее сообщение
    ?>
                    <li class="f fac gap8 list_item">
                        <span>Пусто</span>
                    </li>
                    <?php
    }
    ?>
                </ul>
            </div>
        </div>
        <div class="f fw w gap20">
            <div class="f fc gap8 shadow pad8 _br8 f_300 h300M">
                <h3>
                    Поклейка
                </h3>
                <input type="text" autocomplete="off" name="" placeholder="Пошук посуду" id="tab_7_tab_4_list_search" oninput="liveSearch('tab_7_tab_4_list', this.value)">
                <ul id="tab_7_tab_4_list" class="f fc gap8 h300M scroll">
                    <?php
    $tab_4_list = CFS()->get('tab_4_list');

                    // Проверяем наличие списка перед его использованием
                    if (!empty($tab_4_list)) {
                    // Сортируем список по полю tab_4_count
                    usort($tab_4_list, function($a, $b) {
                    return $a['tab_4_count'] - $b['tab_4_count'];
                    });

                    // Выводим каждый элемент списка
                    foreach ($tab_4_list as $index => $tab_4_item) {
                    ?>
                    <li class="f fac gap8 list_item"
                        data-name="<?php echo isset($tab_4_item['tab_4_glass']) ? $tab_4_item['tab_4_glass'] . ' ' . $tab_4_item['tab_4_insert'] : ''; ?>"
                        data-id="<?php echo $index + 1; ?>"
                        data-count="<?php echo isset($tab_4_item['tab_4_count']) ? $tab_4_item['tab_4_count'] : ''; ?>">
                        <div>
                            <?php echo isset($tab_4_item['tab_4_count']) ? $tab_4_item['tab_4_count'] : ''; ?>
                        </div>
                        <div class="c4">
                            <?php echo isset($tab_4_item['tab_4_glass']) ? $tab_4_item['tab_4_glass'] : ''; ?>
                        </div>
                        <div class="c9">
                            <?php echo isset($tab_4_item['tab_4_insert']) ? $tab_4_item['tab_4_insert'] : ''; ?>
                        </div>
                        <?php if (isset($tab_4_item['tab_4_stick_list'])) : ?>
                        <ul class="f fac gap8">
                            <?php
                if (isset($tab_4_item['tab_4_stick_list']) && is_array($tab_4_item['tab_4_stick_list']) && count($tab_4_item['tab_4_stick_list']) > 0) {
                            $tab_4_stick_list = $tab_4_item['tab_4_stick_list'];
                            foreach ($tab_4_stick_list as $index => $stick_item) {
                            ?>
                            <li class="f fac gap8 c10">
                                <div>
                                    <?php echo isset($stick_item['tab_4_stick_count']) ? $stick_item['tab_4_stick_count'] : ''; ?>
                                </div>
                                <div>
                                    <?php echo isset($stick_item['tab_4_stick_name']) ? $stick_item['tab_4_stick_name'] : ''; ?>
                                </div>
                            </li>
                            <?php
                    }
                }
                ?>
                        </ul>
                        <?php endif; ?>
                    </li>
                    <?php
    }
    } else {
    // Если список пуст, выводим сообщение "Пусто"
    ?>
                    <li class="f fac gap8 list_item">
                        <span>Пусто</span>
                    </li>
                    <?php
    }
    ?>
                </ul>
            </div>
            <div class="f fc gap8 shadow pad8 _br8 f_300 h300M">
                <h3>
                    Готове
                </h3>
                <input type="text" autocomplete="off" name="" placeholder="Пошук товару" id="tab_7_tab_5_list_search" oninput="liveSearch('tab_7_tab_5_list', this.value)">
                <ul id="tab_7_tab_5_list" class="f fc gap8 h300M scroll">
                    <?php
    $tab_5_list = CFS()->get('tab_5_list');

                    // Проверяем наличие данных в списке
                    if (!empty($tab_5_list)) {
                    usort($tab_5_list, function($a, $b) {
                    return $a['tab_5_count'] - $b['tab_5_count'];
                    });

                    foreach ($tab_5_list as $index => $tab_5_item) {
                    ?>
                    <li class="f fac gap8 list_item"
                        data-name="<?php echo $tab_5_item['tab_5_glass'] . ' ' . $tab_5_item['tab_5_insert']; ?>"
                        data-id="<?php echo $index + 1; ?>"
                        data-count="<?php echo $tab_5_item['tab_5_count']; ?>">
                        <div>
                            <?php echo $tab_5_item['tab_5_count']; ?>
                        </div>
                        <div class="c4">
                            <?php echo $tab_5_item['tab_5_glass']; ?>
                        </div>
                        <div class="c9">
                            <?php echo $tab_5_item['tab_5_insert']; ?>
                        </div>
                        <ul class="f fac gap8">
                            <?php
    $tab_5_stick_list = isset($tab_5_item['tab_5_stick_list']) ? $tab_5_item['tab_5_stick_list'] : array();

    // Проверяем, есть ли вообще вставки
    if (!empty($tab_5_stick_list)) {
    // Сортируем вставки по количеству
    usort($tab_5_stick_list, function($a, $b) {
        return $a['tab_5_stick_count'] - $b['tab_5_stick_count'];
    });

    // Выводим каждую вставку
    foreach ($tab_5_stick_list as $index => $stick_item) {
                            ?>
                            <li class="f fac gap8 c10">
                                <div>
                                    <?php echo $stick_item['tab_5_stick_count']; ?>
                                </div>
                                <div>
                                    <?php echo $stick_item['tab_5_stick_name']; ?>
                                </div>
                            </li>
                            <?php
    }
    }
    ?>

                        </ul>
                    </li>
                    <?php
    }
    } else {
    // Если список пуст, выводим сообщение "Пусто"
    ?>
                    <li class="f fac gap8 list_item">
                        <span>Пусто</span>
                    </li>
                    <?php
    }
    ?>
                </ul>
            </div>
        </div>
    </div>

    <?php if (current_user_can('administrator') || current_user_can('subscriber')) { ?>
    <!-- Списки -->
    <form action="<?php echo admin_url('admin-ajax.php'); ?>" id="editing_list_form" class="f fw w gap8 f_f pad56t pad56b" method="post">
        <div class="f fw w gap8 f_f f_600">
            <!--Список-->
            <div class="f fc gap8 f_400">
                <div class="w BIG">
                    Список
                </div>
                <div class="w f fc">
                    <input type="text" autocomplete="off" name="tab_7_list" list="tab_7_list" id="tab_7_list_selected" placeholder="Оберіть список" class="shadow pad8" required/>
                    <datalist id="tab_7_list" class="shadow">
                        <option
                                data-name="Піч"
                                data-id="2"
                                value="Піч">
                        </option>
                        <option
                                data-name="Напівфабрикат"
                                data-id="3"
                                value="Напівфабрикат">
                        </option>
                        <option
                                data-name="Поклейка"
                                data-id="4"
                                value="Поклейка">
                        </option>
                        <option
                                data-name="Готове"
                                data-id="5"
                                value="Готове">
                        </option>
                        <option
                                data-name="Звіт"
                                data-id="6"
                                value="Звіт">
                        </option>
                        <option
                                data-name="Скло"
                                data-id="7"
                                value="Скло">
                        </option>
                        <option
                                data-name="Виїмка"
                                data-id="8"
                                value="Виїмка">
                        </option>
                        <option
                                data-name="Вставка"
                                data-id="9"
                                value="Вставка">
                        </option>
                    </datalist>
                </div>
            </div>
            <!--Специалист-->
            <div class="f fc gap8 f_200">
                <div class="w BIG">
                    Працівник
                </div>
                <div class="w f fc">
                    <input type="text" autocomplete="off" name="tab_7_list_master" list="tab_7_list_master" id="tab_7_list_master_selected" placeholder="Оберіть фахівця" class="shadow pad8" required/>
                    <datalist id="tab_7_list_master" class="shadow">
                        <?php
                        $master_list_master = CFS()->get('master_list');

                        function compare_list_master($a, $b) {
                        $a_name = $a['master_list'];
                        $b_name = $b['master_list'];

                        $result = strcoll($a_name, $b_name);

                        if ($result === 0) {
                        return strcmp($a_name, $b_name);
                        }

                        return $result;
                        }

                        usort($master_list_master, 'compare_list_master');

                        foreach ($master_list_master as $index => $master_item) {
                        ?>
                        <option data-name="<?php echo $master_item['master_name']; ?>" data-id="<?php echo $index + 1; ?>" value="<?php echo $master_item['master_name']; ?>"></option>
                        <?php
                    }
                    ?>
                    </datalist>
                </div>
            </div>
        </div>
        <!--Скрытый-->
        <input type="hidden" name="action" value="list_form">
        <!--Действие-->
        <div class="f fc gap8 f_200">
            <div class="w BIG">
                Дія
            </div>
            <div class="f fac gap8 list_buttons">
                <button class="btn f_auto shadow f _f_ fac" name="Видалення" type="submit">
                    <img class="img_act" src="<?php echo get_template_directory_uri(); ?>/img/item_delete.png">
                </button>
            </div>
        </div>
        <!--Тип запроса-->
        <input type="hidden" name="list_action" id="list_action">
    </form>
    <script>
        jQuery(function($) {
            $('.list_buttons button').click(function(e) {
                var action = $(this).attr('name'); // Получаем значение атрибута name нажатой кнопки
                $('#list_action').val(action); // Устанавливаем значение в скрытое поле

                var enteredMaster = $('input[name="tab_7_list_master"]').val().trim(); // Получаем значение выбранного специалиста

                var isMasterExists = false;
                $('datalist#tab_7_list_master option').each(function() {
                    var currentMaster = $(this).val().trim();
                    if (currentMaster === enteredMaster) {
                        isMasterExists = true;
                        return false; // Прерываем цикл, так как совпадение найдено
                    }
                });

                if (!isMasterExists) {
                    alert('Оберіть фахівця зі списку.');
                    return false; // Завершаем обработчик
                }

                var enteredName = $('input[name="tab_7_list"]').val().trim(); // Получаем значение выбранного специалиста

                var isNameExists = false;
                $('datalist#tab_7_list option').each(function() {
                    var currentName = $(this).val().trim();
                    if (currentName === enteredName) {
                        isNameExists = true;
                        return false; // Прерываем цикл, так как совпадение найдено
                    }
                });

                if (!isNameExists) {
                    alert('Оберіть список зі списку.');
                    return false; // Завершаем обработчик
                }

                var confirmation = confirm('Ви впевнені, що хочете видалити все ' + enteredName + '?');
                if (!confirmation) {
                    return false; // Отмена отправки формы, если пользователь отказался
                }

                var formData = $('#editing_list_form').serialize();

            });
        });
    </script>
    <?php } ?>
</section>
<?php
// Проверяем, является ли текущий пользователь администратором
if ( ! current_user_can( 'administrator' ) ) {
    // Если пользователь не администратор, применяем стиль CSS
    echo '<style>';
echo '#wpadminbar { display: none; }';
echo '</style>';
}
?>
<?php
get_footer();
?>

