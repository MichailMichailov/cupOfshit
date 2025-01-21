<?php
add_action('wp_ajax_tab_5_form', 'process_tab_5_form');
add_action('wp_ajax_nopriv_tab_5_form', 'process_tab_5_form');

function process_tab_5_form()
{
    if (isset($_POST['tab_5_product']) && isset($_POST['tab_5_count']) && isset($_POST['tab_5_master']) && isset($_POST['tab_5_action'])) {
        $tab_5_status = 'Готове';
        $tab_5_product = sanitize_text_field($_POST['tab_5_product']);
        $tab_5_count = intval($_POST['tab_5_count']);
        $tab_5_master = sanitize_text_field($_POST['tab_5_master']);
        $tab_5_action = sanitize_text_field($_POST['tab_5_action']);

        $current_datetime = current_time('mysql');
        list($current_date, $current_time) = explode(' ', $current_datetime);
        $current_time = current_time('H:i');
        $current_date = $current_date;

        $tab_5_glass_hidden = isset($_POST['tab_5_glass_hidden']) ? sanitize_text_field($_POST['tab_5_glass_hidden']) : '';
        $tab_5_count_hidden = isset($_POST['tab_5_count_hidden']) ? intval($_POST['tab_5_count_hidden']) : '';
        $tab_5_insert_hidden = isset($_POST['tab_5_insert_hidden']) ? sanitize_text_field($_POST['tab_5_insert_hidden']) : '';
        $tab_5_stick_hidden = isset($_POST['tab_5_stick_hidden']) ? sanitize_text_field($_POST['tab_5_stick_hidden']) : '';

        $sticks = explode(') ', $tab_5_stick_hidden);
        $tab_5_sticks = array();

        foreach ($sticks as $stick) {
            $stick = trim($stick, '()');
            $parts = explode('-', $stick);
            $stick_count = isset($parts[0]) ? trim($parts[0]) : '';
            $stick_name = isset($parts[1]) ? trim($parts[1]) : '';

            if (!empty($stick_count) && !empty($stick_name)) {
                $tab_5_sticks[] = array(
                    'tab_4_stick_name' => $stick_name,
                    'tab_4_stick_count' => $stick_count,
                    'tab_5_stick_name' => $stick_name,
                    'tab_5_stick_count' => $stick_count,
                    'tab_6_stick_name' => $stick_name,
                    'tab_6_stick_count' => $stick_count
                );
            }
        }

        $post_data = array(
            'ID' => 10
        );

        $product = array(
            'status' => $tab_5_status,
            'glass' => $tab_5_glass_hidden,
            'count' => $tab_5_count,
            'master' => $tab_5_master,
            'action' => $tab_5_action,
            'glass_hidden' => $tab_5_glass_hidden,
            'count_hidden' => $tab_5_count_hidden,
            'insert_hidden' => $tab_5_insert_hidden,
            'date' => $current_date,
            'time' => $current_time,
            'sticks' => $tab_5_sticks
        );

        $existing_tab_5_list = CFS()->get('tab_5_list', 10);
        $found_tab_5 = false;

        foreach ($existing_tab_5_list as $key => &$tab_5_item) {
            $tab_5_glass = strtolower($tab_5_item['tab_5_glass']);
            $tab_5_insert = strtolower($tab_5_item['tab_5_insert']);
            $tab_5_sticks = array_map('strtolower', array_column($tab_5_item['tab_5_stick_list'], 'tab_5_stick_name'));

            $product_glass = strtolower($product['glass_hidden']);
            $product_insert = strtolower($product['insert_hidden']);
            $product_sticks = array_map('strtolower', array_column($product['sticks'], 'tab_5_stick_name'));

            if ($tab_5_glass === $product_glass
                && $tab_5_insert === $product_insert
                && count($tab_5_sticks) === count($product_sticks)
                && empty(array_diff($tab_5_sticks, $product_sticks))) {

                $tab_5_sticks_names_counts = [];
                foreach ($tab_5_item['tab_5_stick_list'] as $stick) {
                    $name_count = $stick['tab_5_stick_name'] . '-' . $stick['tab_5_stick_count'];
                    $tab_5_sticks_names_counts[] = $name_count;
                }

                $product_sticks_names_counts = [];
                foreach ($product['sticks'] as $stick) {
                    $name_count = $stick['tab_5_stick_name'] . '-' . $stick['tab_5_stick_count'];
                    $product_sticks_names_counts[] = $name_count;
                }

                sort($tab_5_sticks_names_counts);
                sort($product_sticks_names_counts);

                if ($tab_5_sticks_names_counts === $product_sticks_names_counts) {
                    $tab_5_item['tab_5_count'] -= $product['count'];
                    $found_tab_5 = true;

                    if ($tab_5_item['tab_5_count'] <= 0) {
                        unset($existing_tab_5_list[$key]);
                    }

                    break;
                }
            }
        }

        $field_data_tab_5 = [
            'tab_5_list' => $existing_tab_5_list
        ];
        CFS()->save($field_data_tab_5, $post_data);

        if ($product['action'] === 'Продано') {
            // ничего не делаем
        } else if ($product['action'] === 'Повернути') {
            $existing_tab_4_list = CFS()->get('tab_4_list', 10);
            $found_tab_4 = false;

            foreach ($existing_tab_4_list as &$tab_4_item) {
                $tab_4_glass = strtolower($tab_4_item['tab_4_glass']);
                $tab_4_insert = strtolower($tab_4_item['tab_4_insert']);
                $tab_4_sticks = array_map('strtolower', $tab_4_item['tab_4_stick_list']);
                $product_sticks = array_map('strtolower', $product['sticks']);

                if ($tab_4_glass === strtolower($product['glass_hidden'])
                    && $tab_4_insert === strtolower($product['insert_hidden'])
                    && count($tab_4_sticks) === count($product_sticks)
                    && array_diff($tab_4_sticks, $product_sticks) === array_diff($product_sticks, $tab_4_sticks)) {

                    $tab_4_sticks_names_counts = array();
                    foreach ($tab_4_item['tab_4_stick_list'] as $stick) {
                        $name_count = $stick['tab_4_stick_name'] . '-' . $stick['tab_4_stick_count'];
                        $tab_4_sticks_names_counts[] = $name_count;
                    }

                    $product_sticks_names_counts = array();
                    foreach ($product['sticks'] as $stick) {
                        $name_count = $stick['tab_4_stick_name'] . '-' . $stick['tab_4_stick_count'];
                        $product_sticks_names_counts[] = $name_count;
                    }

                    sort($tab_4_sticks_names_counts);
                    sort($product_sticks_names_counts);

                    if ($tab_4_sticks_names_counts === $product_sticks_names_counts) {
                        $tab_4_item['tab_4_count'] += $product['count'];
                        $found_tab_4 = true;
                        break;
                    }
                }
            }

            if (!$found_tab_4 || empty($existing_tab_4_list)) {
                $existing_tab_4_list[] = array(
                    'tab_4_glass' => $product['glass_hidden'],
                    'tab_4_insert' => $product['insert_hidden'],
                    'tab_4_count' => $product['count'],
                    'tab_4_stick_list' => $product['sticks']
                );
            }

            $field_data_tab_4 = array(
                'tab_4_list' => $existing_tab_4_list
            );
            CFS()->save($field_data_tab_4, $post_data);
        } else if ($product['action'] === 'Брак') {
            // ничего не делаем
        } else {
            // ничего не делаем
        }

        $report_block = array(
            'tab_6_status' => $product['status'],
            'tab_6_action' => $product['action'],
            'tab_6_name' => $product['glass_hidden'] . ($product['insert_hidden'] ? ' (' . $product['insert_hidden'] . ')' : ''),
            'tab_6_count' => $product['count'],
            'tab_6_master' => $product['master'],
            'tab_6_time' => $product['time'],
            'tab_6_date' => $product['date'],
            'tab_6_stick_list' => $product['sticks']
        );

        $existing_report_list = CFS()->get('tab_6_list', 10);
        $existing_report_list[] = $report_block;

        $field_data_report = array(
            'tab_6_list' => $existing_report_list
        );

        CFS()->save($field_data_report, $post_data);
    }

    wp_redirect($_SERVER['HTTP_REFERER']);
    exit;
}
