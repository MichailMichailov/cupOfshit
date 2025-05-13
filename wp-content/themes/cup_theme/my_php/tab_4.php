<?php
add_action('wp_ajax_tab_4_form', 'process_tab_4_form');
add_action('wp_ajax_nopriv_tab_4_form', 'process_tab_4_form');

function process_tab_4_form()
{
	// Проверяем наличие данных перед обработкой
	if (isset($_POST['tab_4_product']) && isset($_POST['tab_4_count']) && isset($_POST['tab_4_master']) && isset($_POST['tab_4_action'])) {
		// Получаем данные из запроса
		$tab_4_status = 'Поклейка';
		$tab_4_product = sanitize_text_field($_POST['tab_4_product']);
		$tab_4_count = intval($_POST['tab_4_count']);
		$tab_4_master = sanitize_text_field($_POST['tab_4_master']);
		$tab_4_action = sanitize_text_field($_POST['tab_4_action']);

		$current_datetime = current_time('mysql');
		list($current_date, $current_time) = explode(' ', $current_datetime);
		$current_time = current_time('H:i');
		$current_date = $current_date;

		$tab_4_glass_hidden = isset($_POST['tab_4_glass_hidden']) ? sanitize_text_field($_POST['tab_4_glass_hidden']) : '';
		$tab_4_count_hidden = isset($_POST['tab_4_count_hidden']) ? intval($_POST['tab_4_count_hidden']) : '';
		$tab_4_insert_hidden = isset($_POST['tab_4_insert_hidden']) ? sanitize_text_field($_POST['tab_4_insert_hidden']) : '';
		$tab_4_stick_hidden = isset($_POST['tab_4_stick_hidden']) ? sanitize_text_field($_POST['tab_4_stick_hidden']) : '';
		// Разделяем строку на отдельные вставки
		$sticks = explode(') ', $tab_4_stick_hidden);
		// Создаем массив для хранения вставок
		$tab_4_sticks = array();
		// Перебираем каждую вставку

		foreach ($sticks as $stick) {
			// Удаляем лишние пробелы и скобки
			$stick = trim($stick, '()');
			// Разделяем вставку на количество и наименование по дефизу
			$parts = explode('-', $stick);
			// Получаем количество и наименование
			$stick_count = isset($parts[0]) ? trim($parts[0]) : '';
			$stick_name = isset($parts[1]) ? trim($parts[1]) : '';
			// Добавляем вставку в массив, если количество и наименование не пустые
			if (!empty($stick_count) && !empty($stick_name)) {
				$tab_4_sticks[] = array(
					'stick_name' => $stick_name, // Исправлено
					'stick_count' => $stick_count, // Исправлено
					'tab_4_stick_name' => $stick_name,
					'tab_4_stick_count' => $stick_count,
					'tab_5_stick_name' => $stick_name,
					'tab_5_stick_count' => $stick_count,
					'tab_6_stick_name' => $stick_name,
					'tab_6_stick_count' => $stick_count
				);
			}
		}
		$post_data = array( 'ID' => 10 ); // Определение $post_data перед использованием
		$product = array(
			'status' => $tab_4_status,
			'glass' => $tab_4_glass_hidden,
			'count' => $tab_4_count,
			'master' => $tab_4_master,
			'action' => $tab_4_action,
			'glass_hidden' => $tab_4_glass_hidden,
			'count_hidden' => $tab_4_count_hidden,
			'insert_hidden' => $tab_4_insert_hidden,
			'date' => $current_date,
			'time' => $current_time,
			'sticks' => $tab_4_sticks
		);

		if ($product['action'] === 'Готове') {
			// список пятый
			$existing_tab_5_list = CFS()->get('tab_5_list', 10);
			$found = false;
			foreach ($existing_tab_5_list as &$tab_5_item) {

				// Приводим все содержимое к нижнему регистру перед сравнением
				$tab_5_glass = strtolower($tab_5_item['tab_5_glass']);
				$tab_5_insert = strtolower($tab_5_item['tab_5_insert']);
				$tab_5_sticks = array_map(function ($stick) {
					return strtolower($stick['tab_5_stick_name']);
				}, $tab_5_item['tab_5_stick_list']);
				$product_sticks = array_map(function ($stick) {
					return strtolower($stick['tab_4_stick_name']);
				}, $product['sticks']);
				// Проверяем совпадение стекла и выемки
				if (
					$tab_5_glass === strtolower($product['glass_hidden'])
					&& $tab_5_insert === strtolower($product['insert_hidden'])
					&& count($tab_5_sticks) === count($product_sticks)
					&& array_diff($tab_5_sticks, $product_sticks) === array_diff($product_sticks, $tab_5_sticks)
				) {

					// Проверяем уникальные наименования и количество вставок
					$tab_5_sticks_names_counts = array();
					foreach ($tab_5_item['tab_5_stick_list'] as $stick) {
						$name_count = $stick['tab_5_stick_name'] . '-' . $stick['tab_5_stick_count'];
						$tab_5_sticks_names_counts[] = $name_count;
					}

					$product_sticks_names_counts = array();
					foreach ($product['sticks'] as $stick) {
						$name_count = $stick['tab_5_stick_name'] . '-' . $stick['tab_5_stick_count'];
						$product_sticks_names_counts[] = $name_count;
					}

					sort($tab_5_sticks_names_counts);
					sort($product_sticks_names_counts);

					if ($tab_5_sticks_names_counts === $product_sticks_names_counts) {
						$tab_5_item['tab_5_count'] += $product['count'];
						$found = true;
						break;
					}
				}
			}
			// Если совпадение не найдено или список пустой, добавляем новый элемент
			if (!$found || empty($existing_tab_5_list)) {
				$existing_tab_5_list[] = array(
					'tab_5_glass' => $product['glass_hidden'],
					'tab_5_insert' => $product['insert_hidden'],
					'tab_5_count' => $product['count'],
					'tab_5_stick_list' => $product['sticks']
				);
			}

			// Сохраняем обновленный список tab_4_list
			$field_data_tab_5 = array( 'tab_5_list' => $existing_tab_5_list);
			// raskoment
			CFS()->save($field_data_tab_5, $post_data);
		}
		// возврат в третий список
		else if ($product['action'] === 'Повернути') {
			$existing_tab_3_list = CFS()->get('tab_3_list', 10);
			$found = false;

			foreach ($existing_tab_3_list as &$tab_3_item) {
				$tab_3_glass = strtolower($tab_3_item['tab_3_glass']);
				$tab_3_insert = strtolower($tab_3_item['tab_3_insert']);

				if (($tab_3_glass === strtolower($product['glass_hidden']) && $tab_3_insert === strtolower($product['insert_hidden']))
					|| ($tab_3_glass === strtolower($product['glass_hidden']) && empty($product['insert_hidden']))
				) {
					$tab_3_item['tab_3_count'] += $product['count'];
					$found = true;
					break;
				}
			}

			if (!$found) {
				$existing_tab_3_list[] = array(
					'tab_3_glass' => $product['glass_hidden'],
					'tab_3_insert' => $product['insert_hidden'],
					'tab_3_count' => $product['count']
				);
			}

			$field_data_tab_3 = array(
				'tab_3_list' => $existing_tab_3_list
			);

			CFS()->save($field_data_tab_3, $post_data);

			//Возврат вставок

			$existing_stick_list = CFS()->get('stick_list', 10);

			// Перебираем вставки, указанные в запросе
			foreach ($tab_4_sticks as $stick) {
				$stick_name = $stick['stick_name'];
				$stick_count = $stick['stick_count'];

				$found_stick = false; // Флаг для отслеживания наличия совпадения вставки

				// Перебираем список существующих вставок
				foreach ($existing_stick_list as &$stick_item) {
					// Если наименование вставки совпадает с текущей вставкой
					if ($stick_item['stick_name'] === $stick_name) {
						// Увеличиваем количество вставки
						$stick_item['stick_count'] += $stick_count * $tab_4_count;
						$found_stick = true; // Устанавливаем флаг совпадения
						break; // Прерываем цикл, так как совпадение найдено
					}
				}

				// Если совпадения не было найдено, добавляем новую вставку в список
				if (!$found_stick) {
					$existing_stick_list[] = array(
						'stick_name' => $stick_name,
						'stick_count' => $stick_count * $tab_4_count
					);
				}
			}

			// Сохраняем обновленный список вставок
			$field_data_sticks = array(
				'stick_list' => $existing_stick_list
			);
			CFS()->save($field_data_sticks, $post_data);
		} else if ($product['action'] === 'Брак') {
			// Ничего не делаем
		}

		//уменьшение количества наименований этого списка
		$existing_tab_4_list = CFS()->get('tab_4_list', 10);
		$found_tab_4 = false;

		foreach ($existing_tab_4_list as $key => &$tab_4_item) {
			// Приводим все содержимое к нижнему регистру перед сравнением
			$tab_4_glass = strtolower($tab_4_item['tab_4_glass']);
			$tab_4_insert = strtolower($tab_4_item['tab_4_insert']);
			$tab_4_sticks = array_map('strtolower', array_column($tab_4_item['tab_4_stick_list'], 'tab_4_stick_name'));

			$product_glass = strtolower($product['glass_hidden']);
			$product_insert = strtolower($product['insert_hidden']);
			$product_sticks = array_map('strtolower', array_column($product['sticks'], 'tab_4_stick_name'));

			// Проверяем совпадение стекла и выемки
			if (
				$tab_4_glass === $product_glass
				&& $tab_4_insert === $product_insert
				&& count($tab_4_sticks) === count($product_sticks)
				&& empty(array_diff($tab_4_sticks, $product_sticks))
			) {

				// Проверяем уникальные наименования и количество вставок
				$tab_4_sticks_names_counts = [];
				foreach ($tab_4_item['tab_4_stick_list'] as $stick) {
					$name_count = $stick['tab_4_stick_name'] . '-' . $stick['tab_4_stick_count'];
					$tab_4_sticks_names_counts[] = $name_count;
				}

				$product_sticks_names_counts = [];
				foreach ($product['sticks'] as $stick) {
					$name_count = $stick['tab_4_stick_name'] . '-' . $stick['tab_4_stick_count'];
					$product_sticks_names_counts[] = $name_count;
				}

				sort($tab_4_sticks_names_counts);
				sort($product_sticks_names_counts);

				if ($tab_4_sticks_names_counts === $product_sticks_names_counts) {
					$tab_4_item['tab_4_count'] -= $product['count'];
					$found_tab_4 = true;

					// Удаляем элемент, если количество становится нулевым или отрицательным
					if ($tab_4_item['tab_4_count'] <= 0) {
						unset($existing_tab_4_list[$key]);
					}

					break;
				}
			}
		}

		// Сохраняем обновленный список tab_4_list
		$field_data_tab_4 = [ 'tab_4_list' => $existing_tab_4_list ];
		// raskoment
		CFS()->save($field_data_tab_4, $post_data);


		// Добавляем данные в отчет
		$report_block = array(
			'tab_6_status' => $product['status'],
			'tab_6_action' => $product['action'],
			'tab_6_name' => $product['glass_hidden'] . ($product['insert_hidden'] ? ' ( ' . $product['insert_hidden'] . ' )' : ''),
			'tab_6_count' => $product['count'],
			'tab_6_master' => $product['master'],
			'tab_6_time' => $product['time'],
			'tab_6_date' => $product['date'],
			'tab_6_stick_list' => $product['sticks']
		);
		// Получаем существующий отчет
		$existing_report_list = CFS()->get('tab_6_list', 10);
		// Добавляем новый блок данных в отчет
		$existing_report_list[] = $report_block;
		// Подготавливаем данные для сохранения
		$field_data_report = array( 'tab_6_list' => $existing_report_list );
		// Указываем данные поста
		// $post_data = array( 'ID' => 10 );
		// Сохраняем данные
		try {
			CFS()->save($field_data_report, $post_data);		
		} catch (Exception $e) {
			echo '<pre>';
			print_r($existing_report_list);
			echo '</pre>';
			echo 'Ошибка: ' . $e->getMessage(); // Вывод текста ошибки
			return 0;
		}
		
	} else {
		echo 'error'; // Если данные отсутствуют, возвращаем ошибку
	}

	wp_redirect($_SERVER['HTTP_REFERER']);
	exit;
}
