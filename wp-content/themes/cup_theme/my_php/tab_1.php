<?php
add_action('wp_ajax_tab_1_form', 'process_tab_1_form');
add_action('wp_ajax_nopriv_tab_1_form', 'process_tab_1_form');

function process_tab_1_form() {

    $tab_1_status = 'Оформлення';
    $tab_1_glass = isset($_POST['tab_1_glass']) ? sanitize_text_field($_POST['tab_1_glass']) : ''; //стекло
    $tab_1_count = isset($_POST['tab_1_count']) ? intval($_POST['tab_1_count']) : 0; // количество
    $tab_1_insert = isset($_POST['tab_1_insert']) ? sanitize_text_field($_POST['tab_1_insert']) : ''; // выемка
    $tab_1_master = isset($_POST['tab_1_master']) ? sanitize_text_field($_POST['tab_1_master']) : ''; // мастер
    $tab_1_action = isset($_POST['tab_1_action']) ? sanitize_text_field($_POST['tab_1_action']) : ''; // действие

    $current_datetime = current_time('mysql');
    list($current_date, $current_time) = explode(' ', $current_datetime);
    $current_time = current_time('H:i');
    $current_date = $current_date;

    $existing_glass_list = CFS()->get('glass_list', 10);

    // Уменьшаем количество стекла в glass_list
    foreach ($existing_glass_list as $key => $glass_item) {
        if ($glass_item['glass_name'] === $tab_1_glass) {
            $existing_glass_list[$key]['glass_count'] -= $tab_1_count;
            // Проверка, чтобы количество стекла не стало отрицательным
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

    // Проверяем и записываем в tab_2_list
    if ($tab_1_action === 'У піч') {
        if ($tab_1_glass && $tab_1_count > 0 && $tab_1_master && $tab_1_action) {
        $existing_tab_2_list = CFS()->get('tab_2_list', 10);

        // Проверка на уникальность в tab_2_list
        $found = false;
        foreach ($existing_tab_2_list as $key => $tab_2_item) {
            if ($tab_2_item['tab_2_glass'] === $tab_1_glass && $tab_2_item['tab_2_insert'] === $tab_1_insert) {
                $existing_tab_2_list[$key]['tab_2_count'] += $tab_1_count;
                $found = true;
                break;
            }
            // Проверяем на уникальность, если tab_2_insert не определен
            if ($tab_1_insert === '' && $tab_2_item['tab_2_glass'] === $tab_1_glass && $tab_2_item['tab_2_insert'] === '') {
                $existing_tab_2_list[$key]['tab_2_count'] += $tab_1_count;
                $found = true;
                break;
            }
        }

        // Если элемент не найден, добавляем новый
        if (!$found) {
            $tab_1_block = array(
                'tab_2_count' => $tab_1_count,
                'tab_2_glass' => $tab_1_glass,
                'tab_2_insert' => $tab_1_insert
            );
            $existing_tab_2_list[] = $tab_1_block;
        }
    } else {
        echo 'error';
        die;
    }

    // Сохраняем tab_2_list
    $field_data_tab_2 = array(
        'tab_2_list' => $existing_tab_2_list
    );
    $post_data = array(
        'ID' => 10
    );
    CFS()->save($field_data_tab_2, $post_data);
    }


    // добавление в отчеты
    $tab_1_name = $tab_1_glass;
    if (!empty($tab_1_insert)) {
        $tab_1_name .= ' ( ' . $tab_1_insert . ' )';
    } else {
        $tab_1_name .= '';
    }

    $report_block = array(
        'tab_6_status' => $tab_1_status,
        'tab_6_name' => $tab_1_name,
        'tab_6_count' => $tab_1_count,
        'tab_6_master' => $tab_1_master,
        'tab_6_action' => $tab_1_action,
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