<?php
add_action('wp_ajax_tab_3_form', 'process_tab_3_form');
add_action('wp_ajax_nopriv_tab_3_form', 'process_tab_3_form');

function process_tab_3_form()
{
    // Проверяем наличие данных перед обработкой
    if (isset($_POST['tab_3_glass']) && isset($_POST['tab_3_count']) && isset($_POST['tab_3_master']) && isset($_POST['tab_3_action'])) {
        // Получаем данные из запроса
        $tab_3_status = 'Напівфабрикат';
        $tab_3_glass = sanitize_text_field($_POST['tab_3_glass']);
        $tab_3_count = intval($_POST['tab_3_count']);
        $tab_3_master = sanitize_text_field($_POST['tab_3_master']);
        $tab_3_action = sanitize_text_field($_POST['tab_3_action']);
        $tab_3_comments = isset($_POST['tab_3_comment']) ? sanitize_text_field($_POST['tab_3_comment']) : '';
        $tab_3_glass_hidden = isset($_POST['tab_3_glass_hidden']) ? sanitize_text_field($_POST['tab_3_glass_hidden']) : '';
        $tab_3_count_hidden = isset($_POST['tab_3_count_hidden']) ? intval($_POST['tab_3_count_hidden']) : '';
        $tab_3_insert_hidden = isset($_POST['tab_3_insert_hidden']) ? sanitize_text_field($_POST['tab_3_insert_hidden']) : '';

        $current_datetime = current_time('mysql');
        list($current_date, $current_time) = explode(' ', $current_datetime);
        $current_time = current_time('H:i');
        $current_date = $current_date;
        $tab_3_sticks = array();
        // Подготовка данных о вставках
        for ($i = 1; $i <= 4; $i++) {
            $stick_selected_key = 'tab_3_stick_' . $i;
            $stick_count_key = 'tab_3_stick_' . $i . '_count';

            if (isset($_POST[$stick_selected_key]) && isset($_POST[$stick_count_key])) {
                $stick_selected = sanitize_text_field($_POST[$stick_selected_key]);
                $stick_count = intval($_POST[$stick_count_key]);

                if (!empty($stick_selected) && $stick_count > 0) {
                    $tab_3_sticks[] = array(
                        'stick_name' => $stick_selected, // Добавляем для списка 4
                        'stick_count' => $stick_count, // Добавляем для списка 4
                        'tab_4_stick_name' => $stick_selected, // Добавляем для списка 4
                        'tab_4_stick_count' => $stick_count, // Добавляем для списка 4
                        'tab_6_stick_name' => $stick_selected, // Добавляем для списка 6
                        'tab_6_stick_count' => $stick_count // Добавляем для списка 6
                    );
                }
            }
        }
        $product = array(
            'status' => $tab_3_status,
            'glass' => $tab_3_glass,
            'count' => $tab_3_count,
            'master' => $tab_3_master,
            'action' => $tab_3_action,
            'glass_hidden' => $tab_3_glass_hidden,
            'count_hidden' => $tab_3_count_hidden,
            'insert_hidden' => $tab_3_insert_hidden,
            'date' => $current_date,
            'time' => $current_time,
            'sticks' => $tab_3_sticks,
            'comments' => $tab_3_comments,
        );
        // Указываем данные поста для обоих списков
        $post_data = array('ID' => 10);
        // Получаем список объектов из третьего списка и отнимаем
        $existing_tab_3_list = CFS()->get('tab_3_list', 10);
        $found = false;
        // Создаем объект для сравнения
        $new_item_to_compare = array(
            'tab_3_glass' => $tab_3_glass_hidden,
            'tab_3_insert' => $tab_3_insert_hidden
        );
        // Проверяем наличие объекта с такими же параметрами
        foreach ($existing_tab_3_list as $key => &$item) {
            $existing_item_to_compare = array(
                'tab_3_glass' => $item['tab_3_glass'],
                'tab_3_insert' => $item['tab_3_insert']
            );

            // Сравниваем объекты
            if ($existing_item_to_compare === $new_item_to_compare) {
                // Уменьшаем количество
                $item['tab_3_count'] -= $tab_3_count;

                // Проверяем, не стало ли количество отрицательным
                if ($item['tab_3_count'] < 0) {
                    echo 'error';
                    die;
                } elseif ($item['tab_3_count'] == 0) {
                    // Если количество равно нулю, удаляем этот элемент из списка
                    unset($existing_tab_3_list[$key]);
                }

                // Сохраняем обновленный список
                $field_data_tab_3 = array(
                    'tab_3_list' => $existing_tab_3_list
                );
                CFS()->save($field_data_tab_3, $post_data);

                $found = true;
                break;
            }
        }
        // Проверяем наличие совпадений и уменьшаем количество вставок с склада
        $existing_stick_list = CFS()->get('stick_list', 10);
        foreach ($existing_stick_list as &$item) {
            // Приводим все содержимое к нижнему регистру перед сравнением
            $existing_stick_name = strtolower($item['stick_name']);

            // Сравниваем наименования вставок
            foreach ($tab_3_sticks as $stick) {
                $stick_name = strtolower($stick['stick_name']);
                if ($existing_stick_name === $stick_name) {
                    // Уменьшаем количество
                    $item['stick_count'] -= $stick['stick_count'] * $tab_3_count;

                    // Проверяем, не стало ли количество отрицательным
                    if ($item['stick_count'] < 0) {
                        echo 'error';
                        die;
                    }
                }
            }
        }
        // print_r('half');
        // return 0 ;
        // Сохраняем обновленный список
        $field_data_stick_list = array('stick_list' => $existing_stick_list);
        if (!empty($field_data_stick_list)) {
            CFS()->save($field_data_stick_list, $post_data);
        }
        // Добавление объекта в список 6
        $existing_tab_6_list = CFS()->get('tab_6_list', 10);
        $existing_tab_6_list[] = array(
            'tab_6_status'     => $product['status'] ?? '',
            'tab_6_action'     => $product['action'] ?? '',
            'tab_6_name'       => ($product['glass_hidden'] ?? '') . ((isset($product['insert_hidden']) && $product['insert_hidden']) ? ' ( ' . $product['insert_hidden'] . ' )' : ''),
            'tab_6_count'      => $product['count'] ?? 0,
            'tab_6_master'     => $product['master'] ?? '',
            'tab_6_time'       => $product['time'] ?? '',
            'tab_6_date'       => $product['date'] ?? '',
            'tab_6_stick_list' => $product['sticks'] ?? [],
            'tab_6_comments'   => $tab_3_comments ?? '',
        );
        $field_data_tab_6 = array('tab_6_list' => $existing_tab_6_list);
        CFS()->save($field_data_tab_6, $post_data);

        if ($product['action'] === 'Поклейка') {
            // Получаем текущий список tab_4_list
            $existing_tab_4_list = CFS()->get('tab_4_list', 10);

            // Если не массив, инициализируем пустым массивом
            if (!is_array($existing_tab_4_list)) {
                $existing_tab_4_list = [];
            }

            // Приводим к нижнему регистру значения из $product один раз, чтобы не делать каждый раз в цикле
            $product_glass = strtolower($product['glass_hidden']);
            $product_insert = strtolower($product['insert_hidden']);

            // Защита для $product['sticks']
            $product_sticks = is_array($product['sticks']) ? $product['sticks'] : [];
            // Преобразуем палочки продукта в массив строк в нижнем регистре
            $product_sticks_str = array_map(function ($stick) {
                return is_string($stick) ? strtolower($stick) : '';
            }, $product_sticks);

            $found = false;

            foreach ($existing_tab_4_list as &$tab_4_item) {
                // Защита и преобразование для элементов списка
                $tab_4_glass = isset($tab_4_item['tab_4_glass']) ? strtolower($tab_4_item['tab_4_glass']) : '';
                $tab_4_insert = isset($tab_4_item['tab_4_insert']) ? strtolower($tab_4_item['tab_4_insert']) : '';

                $tab_4_stick_list = isset($tab_4_item['tab_4_stick_list']) && is_array($tab_4_item['tab_4_stick_list']) ? $tab_4_item['tab_4_stick_list'] : [];
                // Преобразуем палочки из списка в строки
                $tab_4_sticks_str = array_map(function ($stick) {
                    return is_string($stick) ? strtolower($stick) : '';
                }, $tab_4_stick_list);

                // Сравнение стекол и вставок
                if (
                    $tab_4_glass === $product_glass &&
                    $tab_4_insert === $product_insert &&
                    count($tab_4_sticks_str) === count($product_sticks_str) &&
                    empty(array_diff($tab_4_sticks_str, $product_sticks_str)) &&
                    empty(array_diff($product_sticks_str, $tab_4_sticks_str))
                ) {
                    // Сравниваем имена и количества палочек

                    $tab_4_sticks_names_counts = [];
                    foreach ($tab_4_stick_list as $stick) {
                        $name = isset($stick['tab_4_stick_name']) ? $stick['tab_4_stick_name'] : '';
                        $count = isset($stick['tab_4_stick_count']) ? $stick['tab_4_stick_count'] : '';
                        $tab_4_sticks_names_counts[] = $name . '-' . $count;
                    }
                    $product_sticks_names_counts = [];
                    foreach ($product_sticks as $stick) {
                        $name = isset($stick['tab_4_stick_name']) ? $stick['tab_4_stick_name'] : '';
                        $count = isset($stick['tab_4_stick_count']) ? $stick['tab_4_stick_count'] : '';
                        $product_sticks_names_counts[] = $name . '-' . $count;
                    }
                    sort($tab_4_sticks_names_counts);
                    sort($product_sticks_names_counts);

                    if ($tab_4_sticks_names_counts === $product_sticks_names_counts) {
                        // Обновляем количество и комментарии
                        $tab_4_item['tab_4_count'] = (int)($tab_4_item['tab_4_count'] ?? 0) + (int)$product['count'];
                        $tab_4_item['tab_4_comments'] = $product['comments'] ?? '';
                        $found = true;
                        break;
                    }
                }
            }
            unset($tab_4_item); // Снимаем ссылку

            // Если не найдено совпадений, добавляем новый элемент
            if (!$found) {
                $existing_tab_4_list[] = [
                    'tab_4_glass' => $product['glass_hidden'] ?? '',
                    'tab_4_insert' => $product['insert_hidden'] ?? '',
                    'tab_4_count' => (int)($product['count'] ?? 0),
                    'tab_4_comments' => $product['comments'] ?? '',
                    'tab_4_stick_list' => $product_sticks,
                ];
            }

            // Сохраняем обновленный список
            CFS()->save(['tab_4_list' => $existing_tab_4_list], $post_data);
        } else if ($product['action'] === 'Повернути') {
            // Добавление объекта в список 2
            $existing_tab_2_list = CFS()->get('tab_2_list', 10);
            $found = false;
            foreach ($existing_tab_2_list as &$tab_2_item) {
                $tab_2_glass = strtolower($tab_2_item['tab_2_glass']);
                $tab_2_insert = strtolower($tab_2_item['tab_2_insert']);

                if (($tab_2_glass === strtolower($product['glass_hidden']) && $tab_2_insert === strtolower($product['insert_hidden'])) ||
                    ($tab_2_glass === strtolower($product['glass_hidden']) && empty($product['insert_hidden']))
                ) {
                    $tab_2_item['tab_2_count'] += $product['count'];
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $existing_tab_2_list[] = array(
                    'tab_2_glass' => $product['glass_hidden'],
                    'tab_2_insert' => $product['insert_hidden'],
                    'tab_2_count' => $product['count'],
                );
            }
            $field_data_tab_2 = array('tab_2_list' => $existing_tab_2_list);
            CFS()->save($field_data_tab_2, $post_data);
        } else {
            // БРАК
        }
    }
    wp_redirect($_SERVER['HTTP_REFERER']);
    exit;
}
