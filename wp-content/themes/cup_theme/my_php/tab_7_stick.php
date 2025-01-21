<?php
add_action('wp_ajax_stick_form', 'process_stick_form');
add_action('wp_ajax_nopriv_stick_form', 'process_stick_form');

function process_stick_form() {

    $tab_7_status = 'Редагування';
    $stick_action = isset($_POST['stick_action']) ? sanitize_text_field($_POST['stick_action']) : ''; // Получаем значение атрибута name кнопки
    $stick_name = isset($_POST['tab_7_stick']) ? sanitize_text_field($_POST['tab_7_stick']) : '';
    $stick_count = ($stick_action === 'Видалення вставки') ? 'Все' : (isset($_POST['tab_7_stick_count']) ? intval($_POST['tab_7_stick_count']) : 0);
    $stick_master = isset($_POST['tab_7_stick_master']) ? sanitize_text_field($_POST['tab_7_stick_master']) : '';

    $current_datetime = current_time('mysql');
    list($current_date, $current_time) = explode(' ', $current_datetime);
    $current_time = current_time('H:i');
    $current_date = $current_date;

    // Запись в stick_list в зависимости от действия
    if ($stick_action === 'Створення вставки') {
        if ($stick_name && $stick_count > 0 && $stick_master && $stick_action) {
            $stick_block = array(
                'stick_count' => $stick_count,
                'stick_name' => $stick_name
            );

            $existing_stick_list = CFS()->get('stick_list', 10);
            $existing_stick_list[] = $stick_block;

            $field_data_stick = array(
                'stick_list' => $existing_stick_list
            );

            $post_data = array(
                'ID' => 10
            );

            CFS()->save($field_data_stick, $post_data);
        } else {
            echo 'error';
            die;
        }
    } elseif ($stick_action === 'Додавання вставки') {
        if ($stick_name && $stick_count > 0 && $stick_master && $stick_action) {
            $existing_stick_list = CFS()->get('stick_list', 10);

            // Ищем стекло с указанным именем в списке
            foreach ($existing_stick_list as $key => $stick_item) {
                if ($stick_item['stick_name'] === $stick_name) {
                    // Найдено стекло, обновляем его количество
                    $existing_stick_list[$key]['stick_count'] += $stick_count;

                    // Сохраняем обновленный список стекол
                    $field_data_stick = array(
                        'stick_list' => $existing_stick_list
                    );

                    $post_data = array(
                        'ID' => 10
                    );

                    CFS()->save($field_data_stick, $post_data);

                    // Прерываем цикл после обновления стекла
                    break;
                }
            }
        } else {
            echo 'error';
            die;
        }
    } elseif ($stick_action === 'Віднімання вставки') {
        if ($stick_name && $stick_count > 0 && $stick_master && $stick_action) {
            $existing_stick_list = CFS()->get('stick_list', 10);

            // Ищем стекло с указанным именем в списке
            foreach ($existing_stick_list as $key => $stick_item) {
                if ($stick_item['stick_name'] === $stick_name) {
                    // Найдено стекло, уменьшаем его количество
                    $existing_stick_list[$key]['stick_count'] -= $stick_count;

                    // Проверяем, чтобы количество стекла не стало отрицательным
                    if ($existing_stick_list[$key]['stick_count'] < 0) {
                        echo 'error';
                        die;
                    }

                    // Сохраняем обновленный список стекол
                    $field_data_stick = array(
                        'stick_list' => $existing_stick_list
                    );

                    $post_data = array(
                        'ID' => 10
                    );

                    CFS()->save($field_data_stick, $post_data);

                    // Прерываем цикл после обновления стекла
                    break;
                }
            }
        } else {
            echo 'error';
            die;
        }
    } elseif  ($stick_action === 'Видалення вставки') {
        $existing_stick_list = CFS()->get('stick_list', 10);
        // Поиск элемента для удаления по совпадению stick_name с stick_name
        foreach ($existing_stick_list as $key => $stick_item) {
            if ($stick_item['stick_name'] === $stick_name) {
                unset($existing_stick_list[$key]); // Удаление элемента из массива
                break; // Прерывание цикла после удаления
            }
        }
                $field_data_stick = array(
            'stick_list' => $existing_stick_list
        );

        $post_data = array(
            'ID' => 10
        );

        CFS()->save($field_data_stick, $post_data);
    } else {
        // Если нет действия или неправильное действие, ничего не делаем
    }

    // Запись в tab_6_list для любой кнопки
    $report_block = array(
        'tab_6_status' => $tab_7_status,
        'tab_6_name' => $stick_name, // Используем разделенное наименование
        'tab_6_count' => $stick_count,
        'tab_6_master' => $stick_master,
        'tab_6_action' => $stick_action,
        'tab_6_time' => $current_time,
        'tab_6_date' => $current_date
    );

    $existing_report_list = CFS()->get('tab_6_list', 10);
    $existing_report_list[] = $report_block;

    $field_data_report = array(
        'tab_6_list' => $existing_report_list
    );

    $post_data = array(
        'ID' => 10
    );

    CFS()->save($field_data_report, $post_data);

    wp_redirect( $_SERVER['HTTP_REFERER'] );
    exit;
}
?>