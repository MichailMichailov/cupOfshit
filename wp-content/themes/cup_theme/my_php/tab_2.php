<?php
add_action('wp_ajax_tab_2_form', 'process_tab_2_form');
add_action('wp_ajax_nopriv_tab_2_form', 'process_tab_2_form');

function process_tab_2_form() {
    if (isset($_POST['tab_2_glass'], $_POST['tab_2_count'], $_POST['tab_2_master'], $_POST['tab_2_action'])) {
        $tab_2_glass_insert = sanitize_text_field($_POST['tab_2_glass']);

        $tab_2_status = 'Піч';
        // Извлекаем название стекла и выемки с использованием регулярного выражения
        preg_match('/^(.*?)\s*(?:\((.*?)\))?$/', $tab_2_glass_insert, $matches);
        $tab_2_glass = isset($matches[1]) ? trim($matches[1]) : '';
        $tab_2_insert = isset($matches[2]) ? trim($matches[2]) : '';

        $tab_2_count = intval($_POST['tab_2_count']);
        $tab_2_master = sanitize_text_field($_POST['tab_2_master']);
        $tab_2_action = sanitize_text_field($_POST['tab_2_action']);

        $current_datetime = current_time('mysql');
        list($current_date, $current_time) = explode(' ', $current_datetime);
        $current_time = current_time('H:i');
        $current_date = $current_date;


// Уменьшаем количество стекла в tab_2_list
$existing_tab_2_list = CFS()->get('tab_2_list', 10);

if (!empty($existing_tab_2_list)) {
    foreach ($existing_tab_2_list as $key => $glass_item) {
        $existing_tab_2_glass = $glass_item['tab_2_glass'];
        $existing_tab_2_insert = $glass_item['tab_2_insert'];

        if (strtolower($existing_tab_2_glass) === strtolower($tab_2_glass) && strtolower($existing_tab_2_insert) === strtolower($tab_2_insert)) {
            $existing_tab_2_list[$key]['tab_2_count'] -= $tab_2_count;

            if ($existing_tab_2_list[$key]['tab_2_count'] < 0) {
                echo 'error';
                die;
            } elseif ($existing_tab_2_list[$key]['tab_2_count'] == 0) {
                // Если количество равно нулю, удаляем этот элемент из списка
                unset($existing_tab_2_list[$key]);
            }

            $field_data_tab_2 = array(
                'tab_2_list' => $existing_tab_2_list
            );

            $post_data = array(
                'ID' => 10 // Замените 10 на ID вашей записи, в которую вы хотите сохранить данные
            );

            CFS()->save($field_data_tab_2, $post_data);
            break;
        }
    }
}


        if ($tab_2_action === 'Напівфабрикат') {
            // Получаем текущий список tab_3_list
            $existing_tab_3_list = CFS()->get('tab_3_list', 10);

            // Проверяем наличие элемента с таким же стеклом и выемкой в списке
            $found = false;
            foreach ($existing_tab_3_list as $key => $tab_3_item) {
                if (strtolower($tab_3_item['tab_3_glass'] . ' ' . $tab_3_item['tab_3_insert']) === strtolower($tab_2_glass . ' ' . $tab_2_insert)) {
                    // Если нашли такой элемент, увеличиваем количество и выходим из цикла
                    $existing_tab_3_list[$key]['tab_3_count'] += $tab_2_count;
                    $found = true;
                    break;
                }
            }

            // Если не нашли элемент, добавляем новый элемент в список
            if (!$found) {
                $new_tab_3_item = array(
                    'tab_3_glass' => $tab_2_glass,
                    'tab_3_insert' => $tab_2_insert,
                    'tab_3_count' => $tab_2_count
                );
                $existing_tab_3_list[] = $new_tab_3_item;
            }

            // Сохраняем обновленный список tab_3_list
            $field_data_tab_3 = array(
                'tab_3_list' => $existing_tab_3_list
            );

            $post_data_tab_3 = array(
                'ID' => 10 // ID записи, в которую нужно сохранить данные для третьего списка
            );

            CFS()->save($field_data_tab_3, $post_data_tab_3);

            } else if ($tab_2_action === 'Повернути') {
            // Получаем текущий список glass_list
            $existing_glass_list = CFS()->get('glass_list', 10);

            // Проверяем наличие элемента с таким же стеклом в списке
            $found = false;
            foreach ($existing_glass_list as $key => $glass_item) {
                if (strtolower($glass_item['glass_name']) === strtolower($tab_2_glass)) {
                    // Если нашли такой элемент, увеличиваем количество и выходим из цикла
                    $existing_glass_list[$key]['glass_count'] += $tab_2_count;
                    $found = true;
                    break;
                }
            }

            // Если не нашли элемент, добавляем новый элемент в список
            if (!$found) {
                $new_glass_item = array(
                    'glass_name' => $tab_2_glass,
                    'glass_count' => $tab_2_count
                );
                $existing_glass_list[] = $new_glass_item;
            }

            // Сохраняем обновленный список glass_list
            $field_data_glass = array(
                'glass_list' => $existing_glass_list
            );

            $post_data_glass = array(
                'ID' => 10 // ID записи, в которую нужно сохранить данные для списка стекла
            );

            CFS()->save($field_data_glass, $post_data_glass);
        }


        // Добавляем данные в отчет
        $report_block = array(
            'tab_6_status' => $tab_2_status,
            'tab_6_name' => $tab_2_glass_insert,
            'tab_6_count' => $tab_2_count,
            'tab_6_master' => $tab_2_master,
            'tab_6_action' => $tab_2_action,
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
}
?>