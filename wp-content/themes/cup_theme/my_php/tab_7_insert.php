<?php
add_action('wp_ajax_insert_form', 'process_insert_form');
add_action('wp_ajax_nopriv_insert_form', 'process_insert_form');

function process_insert_form() {
    $tab_7_status = 'Редагування';
    $insert_name = isset($_POST['tab_7_insert']) ? strtolower(sanitize_text_field($_POST['tab_7_insert'])) : '';
    $insert_master = isset($_POST['tab_7_insert_master']) ? strtolower(sanitize_text_field($_POST['tab_7_insert_master'])) : '';
    $insert_action = isset($_POST['insert_action']) ? sanitize_text_field($_POST['insert_action']) : '';
    $insert_comments = isset($_POST['tab_7_insert_comment']) ? sanitize_text_field($_POST['tab_7_insert_comment']) : '';

    // Отладочная информация
    error_log("Insert Name: " . $insert_name);
    error_log("Insert Master: " . $insert_master);

    $current_datetime = current_time('mysql');
    list($current_date, $current_time) = explode(' ', $current_datetime);
    $current_time = current_time('H:i');
    $current_date = $current_date;

    // Запись в insert_list в зависимости от действия
    if ($insert_action === 'Створення виїмки') {
        if ($insert_name && $insert_master && $insert_action) {
            $insert_block = array(
                'insert_name' => $insert_name,
                'insert_comments'=>$insert_comments
            );

            $existing_insert_list = CFS()->get('insert_list', 10);
            $existing_insert_list[] = $insert_block;

            // Отладочная информация
            error_log("Existing Insert List: " . print_r($existing_insert_list, true));

            $field_data_insert = array(
                'insert_list' => $existing_insert_list
            );

            $post_data = array(
                'ID' => 10
            );

            CFS()->save($field_data_insert, $post_data);
        } else {
            echo 'error';
            die;
        }
    } elseif ($insert_action === 'Видалення виїмки') {
        $existing_insert_list = CFS()->get('insert_list', 10);
        // Поиск элемента для удаления по совпадению insert_name с insert_name
        foreach ($existing_insert_list as $key => $insert_item) {
            if (strtolower($insert_item['insert_name']) === $insert_name) {
                unset($existing_insert_list[$key]); // Удаление элемента из массива
                break; // Прерывание цикла после удаления
            }
        }
        $existing_insert_list = array_values($existing_insert_list); // Пересобрать массив, чтобы переиндексировать его

        $field_data_insert = array(
            'insert_list' => $existing_insert_list
        );

        $post_data = array(
            'ID' => 10
        );

        CFS()->save($field_data_insert, $post_data);
    } else {
        // Если нет действия или неправильное действие, ничего не делаем
    }

    $report_block = array(
        'tab_6_status' => $tab_7_status,
        'tab_6_name' => $insert_name,
        'tab_6_count' => 1,
        'tab_6_master' => $insert_master,
        'tab_6_action' => $insert_action,
        'tab_6_time' => $current_time,
        'tab_6_date' => $current_date,
        'tab_6_comment' => $insert_comments,
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

    wp_redirect($_SERVER['HTTP_REFERER']);
    exit;
}
?>
