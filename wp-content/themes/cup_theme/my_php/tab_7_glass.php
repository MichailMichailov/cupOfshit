<?php
add_action('wp_ajax_glass_form', 'process_glass_form');
add_action('wp_ajax_nopriv_glass_form', 'process_glass_form');

function process_glass_form() {

    $tab_7_status = 'Редагування';
    $glass_action = isset($_POST['glass_action']) ? sanitize_text_field($_POST['glass_action']) : ''; // Получаем значение атрибута name кнопки
    $glass_name = isset($_POST['tab_7_glass']) ? sanitize_text_field($_POST['tab_7_glass']) : '';
    $glass_count = ($glass_action === 'Видалення скла') ? 'Все' : (isset($_POST['tab_7_glass_count']) ? intval($_POST['tab_7_glass_count']) : 0);
    $glass_master = isset($_POST['tab_7_glass_master']) ? sanitize_text_field($_POST['tab_7_glass_master']) : '';
    $glass_comments = isset($_POST['tab_7_glass_comment']) ? sanitize_text_field($_POST['tab_7_glass_comment']) : '';

    $current_datetime = current_time('mysql');
    list($current_date, $current_time) = explode(' ', $current_datetime);
    $current_time = current_time('H:i');
    $current_date = $current_date;


    // Запись в glass_list в зависимости от действия
    if ($glass_action === 'Створення скла') {
        if ($glass_name && $glass_count > 0 && $glass_master && $glass_action && $glass_comments) {
            $glass_block = array(
                'glass_count' => $glass_count,
                'glass_name' => $glass_name,
                'glass_comments' => $glass_comments
            );
            $existing_glass_list = CFS()->get('glass_list', 10);
            $existing_glass_list[] = $glass_block;
            $field_data_glass = array( 'glass_list' => $existing_glass_list );
            $post_data = array( 'ID' => 10);
            CFS()->save($field_data_glass, $post_data);
        } else {
            echo 'error';
            die;
        }
    } elseif ($glass_action === 'Додавання скла') {
        if ($glass_name && $glass_count > 0 && $glass_master && $glass_action) {
            $existing_glass_list = CFS()->get('glass_list', 10);

            // Ищем стекло с указанным именем в списке
            foreach ($existing_glass_list as $key => $glass_item) {
                if ($glass_item['glass_name'] === $glass_name) {
                    // Найдено стекло, обновляем его количество
                    $existing_glass_list[$key]['glass_count'] += $glass_count;
                    $existing_glass_list[$key]['glass_comments'] = $glass_comments;
                    // Сохраняем обновленный список стекол
                    $field_data_glass = array(
                        'glass_list' => $existing_glass_list
                    );

                    $post_data = array(
                        'ID' => 10
                    );

                    CFS()->save($field_data_glass, $post_data);

                    // Прерываем цикл после обновления стекла
                    break;
                }
            }
        } else {
            echo 'error';
            die;
        }
    } elseif ($glass_action === 'Віднімання скла') {
        if ($glass_name && $glass_count > 0 && $glass_master && $glass_action) {
            $existing_glass_list = CFS()->get('glass_list', 10);

            // Ищем стекло с указанным именем в списке
            foreach ($existing_glass_list as $key => $glass_item) {
                if ($glass_item['glass_name'] === $glass_name) {
                    // Найдено стекло, уменьшаем его количество
                    $existing_glass_list[$key]['glass_count'] -= $glass_count;
                    $existing_glass_list[$key]['glass_comments'] = $glass_comments;

                    // Проверяем, чтобы количество стекла не стало отрицательным
                    if ($existing_glass_list[$key]['glass_count'] < 0) {
                        echo 'error';
                        die;
                    }

                    // Сохраняем обновленный список стекол
                    $field_data_glass = array(
                        'glass_list' => $existing_glass_list
                    );

                    $post_data = array(
                        'ID' => 10
                    );

                    CFS()->save($field_data_glass, $post_data);

                    // Прерываем цикл после обновления стекла
                    break;
                }
            }
        } else {
            echo 'error';
            die;
        }
    } elseif  ($glass_action === 'Видалення скла') {
        $existing_glass_list = CFS()->get('glass_list', 10);
        // Поиск элемента для удаления по совпадению glass_name с glass_name
        foreach ($existing_glass_list as $key => $glass_item) {
            if ($glass_item['glass_name'] === $glass_name) {
                unset($existing_glass_list[$key]); // Удаление элемента из массива
                break; // Прерывание цикла после удаления
            }
        }
                $field_data_glass = array(
            'glass_list' => $existing_glass_list
        );

        $post_data = array(
            'ID' => 10
        );

        CFS()->save($field_data_glass, $post_data);
    } else {
        // Если нет действия или неправильное действие, ничего не делаем
    }

    // Запись в tab_6_list для любой кнопки
    $report_block = array(
        'tab_6_status' => $tab_7_status,
        'tab_6_name' => $glass_name, // Используем разделенное наименование
        'tab_6_count' => $glass_count,
        'tab_6_master' => $glass_master,
        'tab_6_action' => $glass_action,
        'tab_6_time' => $current_time,
        'tab_6_date' => $current_date,
        'tab_6_comments' => $glass_comments,
    );
    // Отладочный вывод для проверки содержимого $report_block
    $existing_report_list = CFS()->get('tab_6_list', 10);
    $existing_report_list[] = $report_block;
    $field_data_report = array( 'tab_6_list' => $existing_report_list );
    $post_data = array( 'ID' => 10);
    CFS()->save($field_data_report, $post_data);
    wp_redirect( $_SERVER['HTTP_REFERER'] );
    exit;
}
?>