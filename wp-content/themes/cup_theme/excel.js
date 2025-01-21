// Функция для формирования и скачивания файла Excel
function exportAndDownloadExcel() {
    // Получаем отфильтрованные элементы таблицы
    var filteredItems = document.querySelectorAll('#id_report_post .id_report_post_item[style*="display: flex"]');
    var sheetData = [];
    var headers = ['Статус','Дія', 'Найменування', 'К-сть', 'Фахівець', 'Час'];

    // Добавляем заголовок "Звіт" и текущую дату в начало массива данных
    var reportTitle = ['Звіт'];
    var currentDate = ['Дата: ' + new Date().toLocaleDateString('uk-UA')];
    sheetData.push(reportTitle, currentDate, headers);

    // Получаем данные из отфильтрованных элементов и добавляем их в массив данных
    filteredItems.forEach(function(item) {
        var status = item.querySelector('.id_report_post_item_status').textContent.trim();
        var action = item.querySelector('.id_report_post_item_action').textContent.trim();
        var nameItems = item.querySelectorAll('.id_report_post_item_name__item');
        var count = item.querySelector('.id_report_post_item_count').textContent.trim();
        var master = item.querySelector('.id_report_post_item_master').textContent.trim();
        var time = item.querySelector('.id_report_post_item_time').textContent.trim();

        var nameData = '';

        // Получаем информацию о наименованиях
        nameItems.forEach(function(nameItem, index) {
            nameData += nameItem.textContent.trim();
            // Если есть вставки, добавляем их вместе с наименованием, разделяя переносом строки
            var stickItems = item.querySelectorAll('.id_report_post_item_name__stick span');
            if (stickItems.length > 0 && index === 0) {
                nameData += '\n';
                stickItems.forEach(function(stickItem) {
                    nameData += stickItem.textContent.trim() + '\n';
                });
            }
            // Если это не последний элемент, добавляем разделитель
            if (index !== nameItems.length - 1) {
                nameData += '\n';
            }
        });

        // Формируем строку данных для текущего элемента
        var rowData = [status, action, nameData, count, master, time];
        sheetData.push(rowData);
    });

    // Формируем имя файла из слова "Звіт" и выбранной даты, если дата выбрана
    var selectedDate = document.getElementById('search_date').value;
    var fileName = selectedDate ? 'Звіт_' + selectedDate + '.xlsx' : 'report.xlsx';

    // Создаем новую книгу Excel
    var workbook = XLSX.utils.book_new();
    var worksheet = XLSX.utils.aoa_to_sheet(sheetData);
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Report');

    // Скачиваем файл Excel
    XLSX.writeFile(workbook, fileName);
}

// Устанавливаем интервал для вызова функции каждые 10 секунд (10000 миллисекунд)
//setInterval(exportAndDownloadExcel, 10000);

// Функция для проверки времени и вызова exportAndDownloadExcel() в нужное время
function executeAtSpecificTime(hour, minute) {
    var now = new Date();
    var currentHour = now.getHours();
    var currentMinute = now.getMinutes();

    if (currentHour === hour && currentMinute === minute) {
        // Вызываем функцию для формирования и скачивания файла Excel
        exportAndDownloadExcel();
    }
}

// Устанавливаем интервал проверки времени каждую минуту
setInterval(function() {
    executeAtSpecificTime(12, 00);
    executeAtSpecificTime(14, 00);
    executeAtSpecificTime(16, 00);
    executeAtSpecificTime(18, 00);
    executeAtSpecificTime(20, 00);
}, 60000); // 60000 миллисекунд = 1 минута
exportAndDownloadExcel();
