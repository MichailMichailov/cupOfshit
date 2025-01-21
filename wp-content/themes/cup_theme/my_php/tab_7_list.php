<?php
add_action('wp_ajax_list_form', 'process_list_form');
add_action('wp_ajax_nopriv_list_form', 'process_list_form');

function process_list_form() {

    $tab_7_status = 'Редагування';
    $name_name = isset($_POST['tab_7_list']) ? sanitize_text_field($_POST['tab_7_list']) : '';
    $name_master = isset($_POST['tab_7_list_master']) ? sanitize_text_field($_POST['tab_7_list_master']) : '';
    $name_action = isset($_POST['list_action']) ? sanitize_text_field($_POST['list_action']) : ''; // Получаем значение атрибута name кнопки

    $current_datetime = current_time('mysql');
    list($current_date, $current_time) = explode(' ', $current_datetime);
    $current_time = current_time('H:i');
    $current_date = $current_date;

    // Запись в tab_6_list для любой кнопки
    $report_block = array(
        'tab_6_status' => $tab_7_status,
        'tab_6_action' => $name_action,
        'tab_6_name' => $name_name,
        'tab_6_count' => 'Все',
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


    $existing_tab_2_list = CFS()->get('tab_2_list', 10);
    $existing_tab_3_list = CFS()->get('tab_3_list', 10);
    $existing_tab_4_list = CFS()->get('tab_4_list', 10);
    $existing_tab_5_list = CFS()->get('tab_5_list', 10);
    $existing_tab_6_list = CFS()->get('tab_6_list', 10);
    $existing_tab_glass_list = CFS()->get('glass_list', 10);
    $existing_tab_insert_list = CFS()->get('insert_list', 10);
    $existing_tab_stick_list = CFS()->get('stick_list', 10);


    // Запись в name_list в зависимости от действия
    if ($name_name === 'Піч') {
        $existing_tab_2_list = array();
        $field_data = array('tab_2_list' => $existing_tab_2_list);
        CFS()->save($field_data, $post_data);
    } elseif ($name_name === 'Напівфабрикат') {
        $existing_tab_3_list = array();
        $field_data = array('tab_3_list' => $existing_tab_3_list);
        CFS()->save($field_data, $post_data);
    } elseif ($name_name === 'Поклейка') {
        $existing_tab_4_list = array();
        $field_data = array('tab_4_list' => $existing_tab_4_list);
        CFS()->save($field_data, $post_data);
    } elseif ($name_name === 'Готове') {
        $existing_tab_5_list = array();
        $field_data = array('tab_5_list' => $existing_tab_5_list);
        CFS()->save($field_data, $post_data);
    } elseif ($name_name === 'Звіт') {
        $existing_tab_6_list = array();
        $field_data = array('tab_6_list' => $existing_tab_6_list);
        CFS()->save($field_data, $post_data);
    } elseif ($name_name === 'Скло') {
        $existing_glass_list = array();
        $field_data = array('glass_list' => $existing_glass_list);
        CFS()->save($field_data, $post_data);
    } elseif ($name_name === 'Виїмка') {
        $existing_insert_list = array();
        $field_data = array('insert_list' => $existing_insert_list);
        CFS()->save($field_data, $post_data);
    } elseif ($name_name === 'Вставка') {
        $existing_stick_list = array();
        $field_data = array('stick_list' => $existing_stick_list);
        CFS()->save($field_data, $post_data);
    } else {
        // success
    }

    wp_redirect( $_SERVER['HTTP_REFERER'] );
    exit;
}
?>
