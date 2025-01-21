<?php
add_action('wp_ajax_master_form', 'process_master_form');
add_action('wp_ajax_nopriv_master_form', 'process_master_form');

function process_master_form() {

    $tab_7_status = 'Редагування';
    $name_name = isset($_POST['tab_7_name']) ? sanitize_text_field($_POST['tab_7_name']) : '';
    $name_master = isset($_POST['tab_7_name_master']) ? sanitize_text_field($_POST['tab_7_name_master']) : '';
    $name_action = isset($_POST['master_action']) ? sanitize_text_field($_POST['master_action']) : ''; // Получаем значение атрибута name кнопки

    $current_datetime = current_time('mysql');
    list($current_date, $current_time) = explode(' ', $current_datetime);
    $current_time = current_time('H:i');
    $current_date = $current_date;

    // Запись в tab_6_list для любой кнопки
    $report_block = array(
        'tab_6_status' => $tab_7_status,
        'tab_6_action' => $name_action,
        'tab_6_name' => $name_name,
        'tab_6_count' => 1,
        'tab_6_master' => $name_master,
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

    // Запись в name_list в зависимости от действия
    if ($name_action === 'Створення фахівця') {
        if ($name_name && $name_master && $name_action) {
            $name_block = array(
                'master_name' => $name_name
            );

            $existing_name_list = CFS()->get('master_list', 10);
            $existing_name_list[] = $name_block;

            $field_data_name = array(
                'master_list' => $existing_name_list
            );

            $post_data = array(
                'ID' => 10
            );

            CFS()->save($field_data_name, $post_data);
        } else {
            echo 'error';
            die;
        }
    } elseif ($name_action === 'Видалення фахівця') {
        $existing_name_list = CFS()->get('master_list', 10);
        // Поиск элемента для удаления по совпадению name_name с name_name
        foreach ($existing_name_list as $key => $name_item) {
            if ($name_item['master_name'] === $name_name) {
                unset($existing_name_list[$key]); // Удаление элемента из массива
                break; // Прерывание цикла после удаления
            }
        }
        $field_data_name = array(
            'master_list' => $existing_name_list
        );

        $post_data = array(
            'ID' => 10
        );

        CFS()->save($field_data_name, $post_data);
    } else {
        // Если нет действия или неправильное действие, ничего не делаем
    }

    wp_redirect( $_SERVER['HTTP_REFERER'] );
    exit;
}
?>
