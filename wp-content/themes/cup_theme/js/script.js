document.addEventListener('DOMContentLoaded', function() {

    filterAndSearch();

    setupDateAndFilters();

    redCount();

    // Получаем идентификатор выбранного таба из localStorage
    var selectedTabId = localStorage.getItem('selectedTabId');

    // Если выбранный таб не сохранен, открываем первый таб
    if (!selectedTabId) {
        selectedTabId = 'tab_1';
        localStorage.setItem('selectedTabId', selectedTabId); // Сохраняем выбранный таб
    }

    // Показать выбранный таб при загрузке страницы
    showTab(selectedTabId);

    setActiveButton();

    clickButtonTab();

    setRedColorForDefects();
});



// Универсальная функция для преобразования текста в нижний регистр при вводе
function convertToLowerCaseOnInput(element) {
    element.addEventListener('input', function() {
        this.value = this.value.toLowerCase();
    });
}

// Применение функции ко всем текстовым полям на странице
document.addEventListener('DOMContentLoaded', function() {
    var textInputs = document.querySelectorAll('input[type="text"]');
    textInputs.forEach(function(input) {
        convertToLowerCaseOnInput(input);
    });
});





// Функция для установки красного цвета для элементов списка с действием "Брак" или "Продано"
function setRedColorForDefects() {
    var items = document.querySelectorAll('#id_report_post .id_report_post_item');
    items.forEach(function(item) {
        var text = item.textContent.toLowerCase();
        if (text.includes('брак')) {
            item.style.color = 'var(--c6)';
        } else if (text.includes('продано')) {
            item.style.color = 'var(--c11)';
        } else if (text.includes('видалення')) {
            item.style.color = 'var(--c6)';
        }
    });
}


// function capitalizeInputValue(inputId) {
//     var inputElement = document.getElementById(inputId);

//     inputElement.addEventListener('input', function(event) {
//         var enteredValue = event.target.value.toLowerCase();

//         // Разделим строку на слова
//         var words = enteredValue.split(" ");

//         // Преобразуем каждое слово, начиная с первого символа, к верхнему регистру
//         var capitalizedWords = words.map(function(word) {
//             // Проверяем, начинается ли слово с '('. Если да, то оставляем его без изменений
//             if (word.charAt(0) === '(') {
//                 return word;
//             }
//             // Преобразуем первую букву к верхнему регистру
//             return word.charAt(0).toUpperCase() + word.slice(1);
//         });

//         // Объединяем слова обратно в строку
//         var capitalizedValue = capitalizedWords.join(" ");

//         event.target.value = capitalizedValue;
//     });
// }




// // Вызываем функцию для заданного поля ввода
// capitalizeInputValue('tab_1_glass_selected');
// capitalizeInputValue('tab_1_insert_selected');
// capitalizeInputValue('tab_1_master_selected');
// capitalizeInputValue('search_list_glass');
// capitalizeInputValue('search_list_insert');
// capitalizeInputValue('search_list_stick');

// capitalizeInputValue('tab_2_glass_selected');
// capitalizeInputValue('tab_2_master_selected');
// capitalizeInputValue('tab_2_list_search');

// capitalizeInputValue('tab_3_glass_selected');
// capitalizeInputValue('tab_3_master_selected');
// capitalizeInputValue('tab_3_stick_1_selected');
// capitalizeInputValue('tab_3_stick_2_selected');
// capitalizeInputValue('tab_3_stick_3_selected');
// capitalizeInputValue('tab_3_stick_4_selected');
// capitalizeInputValue('tab_3_list_search');

// capitalizeInputValue('tab_4_product_selected');
// capitalizeInputValue('tab_4_master_selected');
// capitalizeInputValue('tab_4_list_search');

// capitalizeInputValue('tab_5_product_selected');
// capitalizeInputValue('tab_5_master_selected');
// capitalizeInputValue('tab_5_list_search');


// capitalizeInputValue('tab_7_glass_selected');
// capitalizeInputValue('tab_7_glass_master_selected');
// capitalizeInputValue('tab_7_insert_selected');
// capitalizeInputValue('tab_7_insert_master_selected');
// capitalizeInputValue('tab_7_stick_selected');
// capitalizeInputValue('tab_7_stick_master_selected');
// capitalizeInputValue('tab_7_name_selected');
// capitalizeInputValue('tab_7_name_master_selected');
// capitalizeInputValue('tab_7_list_selected');
// capitalizeInputValue('tab_7_list_master_selected');


// capitalizeInputValue('tab_7_tab_2_list_search');
// capitalizeInputValue('tab_7_tab_3_list_search');
// capitalizeInputValue('tab_7_tab_4_list_search');
// capitalizeInputValue('tab_7_tab_5_list_search');



// Поле К-сть
// - запрет ввода без выбора наименования
// - запрет ввода символов кроме чисел
// - запрет ввода отрицательного числа
// - запрет ввода числа больше количества наименования.
// Формирование data-count="" в input === data-count="" выбраного наименования option,
// затем data-count="" (input) === значению max="" поля К-сть
// Создание номера полученого наименования и обновление максимального значения
function createCountAndMaxValue(listId, targetInputId) {
    var input = document.querySelector('[list="' + listId + '"]');
    var selectedGlass = input.value;
    var dataList = document.getElementById(listId);
    var options = dataList.querySelectorAll('option');
    var targetInput = document.getElementById(targetInputId);

    // Найти выбранный элемент в списке и получить его значение data-count
    for (var i = 0; i < options.length; i++) {
        var option = options[i];
        if (option.value === selectedGlass) {
            var count = option.dataset.count;
            input.setAttribute('data-count', count);

            // Обновляем максимальное значение в поле ввода числа
            if (count) {
                targetInput.setAttribute('max', count);
            } else {
                targetInput.removeAttribute('max');
            }

            // Проверяем введенное значение на соответствие максимальному
            var value = parseInt(targetInput.value);
            var max = parseInt(targetInput.getAttribute('max'));
            if (max && value > max) {
                targetInput.value = max;
            }

            return;
        }
    }

    // Если выбранный элемент не найден, сбросить значение data-count и max
    input.removeAttribute('data-count');
    targetInput.removeAttribute('max');
}

// Добавляем обработчик события input для поля с наименованием
document.getElementById('tab_1_glass_selected').addEventListener('input', function() {
    createCountAndMaxValue('tab_1_glass', 'tab_1_count');
});
document.getElementById('tab_2_glass_selected').addEventListener('input', function() {
    createCountAndMaxValue('tab_2_glass', 'tab_2_count');
});
document.getElementById('tab_3_glass_selected').addEventListener('input', function() {
    createCountAndMaxValue('tab_3_glass', 'tab_3_count');
});
document.getElementById('tab_4_product_selected').addEventListener('input', function() {
    createCountAndMaxValue('tab_4_product', 'tab_4_count');
});
document.getElementById('tab_5_product_selected').addEventListener('input', function() {
    createCountAndMaxValue('tab_5_product', 'tab_5_count');
});


// Функция для обработки ввода чисел с проверкой выбранного элемента
function attentionNumber(NumberId, ItemSelected) {
    var numberInput = document.getElementById(NumberId);

    // Функция для проверки ввода чисел и вывода сообщения об ошибке
    function checkInput(event) {
        var value = event.target.value;
        var glassInput = document.getElementById(ItemSelected);
        var selectedGlass = glassInput.value.trim();
        var max = parseInt(event.target.getAttribute('max'));

        // Если наименование не выбрано, выводим сообщение
        if (selectedGlass === '') {
            alert("Оберіть найменування зі списку");
            event.target.value = ''; // Очищаем поле с числом
        } else if (!/^\d+$/.test(value) || value.startsWith('-') || (max && parseInt(value) > max)) {
            // Предотвращаем ввод недопустимых значений и чисел больше максимального
            event.target.value = '';
        }
    }

    numberInput.addEventListener('input', checkInput);
}

attentionNumber('tab_1_count', 'tab_1_glass_selected');
attentionNumber('tab_2_count', 'tab_2_glass_selected');
attentionNumber('tab_3_count', 'tab_3_glass_selected');
//вставки
attentionNumber('tab_3_stick_1_count', 'tab_3_stick_1_selected');
attentionNumber('tab_3_stick_2_count', 'tab_3_stick_2_selected');
attentionNumber('tab_3_stick_3_count', 'tab_3_stick_3_selected');
attentionNumber('tab_3_stick_4_count', 'tab_3_stick_4_selected');

attentionNumber('tab_4_count', 'tab_4_product_selected');
attentionNumber('tab_5_count', 'tab_5_product_selected');

attentionNumber('tab_7_glass_count', 'tab_7_glass_selected');
attentionNumber('tab_7_stick_count', 'tab_7_stick_selected');


//добавление data-count для стекла и вставок ТАБ 7
//для передачи данных в ajax для определения к-ства на складе для отнимания
function updateDataCount(selectedInputId, dataListId) {
    var dataList = document.getElementById(dataListId);
    var selectedInput = document.getElementById(selectedInputId);

    selectedInput.addEventListener('input', function() {
        var selectedOption = dataList.querySelector('option[value="' + selectedInput.value + '"]');
        if (selectedOption) {
            var count = selectedOption.getAttribute('data-count');
            selectedInput.setAttribute('data-count', count);
        } else {
            selectedInput.removeAttribute('data-count');
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    updateDataCount('tab_7_stick_selected', 'tab_7_stick');
    updateDataCount('tab_7_glass_selected', 'tab_7_glass');

    updateDataCount('tab_3_stick_1_selected', 'tab_3_stick_1');
    updateDataCount('tab_3_stick_2_selected', 'tab_3_stick_2');
    updateDataCount('tab_3_stick_3_selected', 'tab_3_stick_3');
    updateDataCount('tab_3_stick_4_selected', 'tab_3_stick_4');
});





//функция открытия блоково табов
function showTab(tabId) {
    // Скрыть все табы
    var tabs = document.querySelectorAll('.tabs__block');
    tabs.forEach(function(tab) {
        tab.classList.remove('active-tab');
    });

    // Показать выбранный таб
    var selectedTab = document.getElementById(tabId);
    selectedTab.classList.add('active-tab');

    // Сохраняем выбранный таб в localStorage
    localStorage.setItem('selectedTabId', tabId);
}

// функция выбраного таба
function clickButtonTab () {
    for (var i = 1; i <= 7; i++) {
        var buttonId = 'tab_' + i + '_button';
        var button = document.getElementById(buttonId);
        button.addEventListener('click', function() {
            setActiveButton();
        });
    }
}

//добавляение активной кнопки от активного контейнера
function setActiveButton() {
    // Перебираем все табы
    for (var i = 1; i <= 7; i++) {
        var tabId = 'tab_' + i;
        var buttonId = tabId + '_button';
        var tab = document.getElementById(tabId);
        var button = document.getElementById(buttonId);

        // Если таб имеет класс active-tab, добавляем класс btn_tab_active кнопке
        if (tab.classList.contains('active-tab')) {
            button.classList.add('btn_tab_active');
        } else {
            button.classList.remove('btn_tab_active');
        }
    }
}







// Функция для установки текущей даты и добавления обработчиков событий для полей ввода
function setupDateAndFilters() {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    var currentDate = yyyy + '-' + mm + '-' + dd;

    document.getElementById('search_date').value = currentDate;

    filterAndSearch();

    // Добавляем обработчики событий для изменения каждого поля ввода
    document.getElementById('search_date').addEventListener('change', filterAndSearch);
    document.getElementById('searchStatus').addEventListener('input', filterAndSearch);
    document.getElementById('searchAction').addEventListener('input', filterAndSearch);
    document.getElementById('searchName').addEventListener('input', filterAndSearch);
    document.getElementById('searchCount').addEventListener('input', filterAndSearch);
    document.getElementById('searchMaster').addEventListener('input', filterAndSearch);
    document.getElementById('searchTime').addEventListener('input', filterAndSearch);
}



// Функция для фильтрации элементов по выбранной дате и поиску значений
function filterAndSearch() {
    var selectedDate = document.getElementById('search_date').value;
    var searchStatus = document.getElementById('searchStatus').value.trim().toLowerCase();
    var searchAction = document.getElementById('searchAction').value.trim().toLowerCase();
    var searchName = document.getElementById('searchName').value.trim().toLowerCase();
    var searchCount = document.getElementById('searchCount').value.trim().toLowerCase();
    var searchMaster = document.getElementById('searchMaster').value.trim().toLowerCase();
    var searchTime = document.getElementById('searchTime').value.trim().toLowerCase();

    var listItems = document.querySelectorAll('#id_report_post .id_report_post_item');

    listItems.forEach(function(item) {
        var itemDate = item.querySelector('.id_report_post_item_time').getAttribute('data-date');
        var statusValue = item.querySelector('.id_report_post_item_status').textContent.trim().toLowerCase();
        var actionValue = item.querySelector('.id_report_post_item_action').textContent.trim().toLowerCase();
        var nameValue = item.querySelector('.id_report_post_item_name').textContent.trim().toLowerCase();
        var countValue = item.querySelector('.id_report_post_item_count').textContent.trim().toLowerCase();
        var masterValue = item.querySelector('.id_report_post_item_master').textContent.trim().toLowerCase();
        var timeValue = item.querySelector('.id_report_post_item_time').textContent.trim().toLowerCase();

        var listItem = item.closest('.id_report_post_item');

        // Проверяем совпадение даты
        var dateMatch = (itemDate === selectedDate || selectedDate === '');

        // Проверяем совпадение поисковых текстов
        var statusMatch = (statusValue.includes(searchStatus) || searchStatus === '');
        var actionMatch = (actionValue.includes(searchAction) || searchAction === '');
        var nameMatch = (nameValue.includes(searchName) || searchName === '');
        var countMatch = (countValue.includes(searchCount) || searchCount === '');
        var masterMatch = (masterValue.includes(searchMaster) || searchMaster === '');
        var timeMatch = (timeValue.includes(searchTime) || searchTime === '');

        // Показываем элемент, если совпадает дата и все поисковые тексты
        if (statusMatch && dateMatch && actionMatch && nameMatch && countMatch && masterMatch && timeMatch) {
            listItem.style.display = 'flex';
        } else {
            listItem.style.display = 'none';
        }
    });
}



//универсальная функци поиска по списку
function liveSearch(elementId, searchText) {
    let input = searchText.toUpperCase();
    let listItems = document.querySelectorAll(`#${elementId} .list_item`);

    listItems.forEach(item => {
        let textValue = item.innerText || item.textContent; // Поменял местами
        let shouldBeVisible = textValue.toUpperCase().includes(input);

        if (shouldBeVisible) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
}



//if < 2000 * == red

function redCount() {
    // Выбираем все элементы, которые могут содержать числовое значение
    var allItems = document.querySelectorAll('.list_stock *');

    // Перебираем каждый элемент на странице
    allItems.forEach(function(item) {
        // Получаем текстовое содержимое элемента
        var textContent = item.textContent.trim();
        // Проверяем, является ли содержимое числом и меньше ли оно 2000
        if (!isNaN(textContent) && parseInt(textContent) < 2000) {
            // Если условие выполняется, применяем красный цвет
            item.style.color = 'red';
        }
    });
}


//функция отображения реального времени
document.addEventListener('DOMContentLoaded', function() {
    // Функция для обновления даты и времени
    function updateDateTime() {
        // Получаем текущую дату и время
        var currentDateTime = new Date();

        // Форматируем дату и время по вашим предпочтениям
        var formattedDateTime = currentDateTime.toLocaleString(); // Например, "01/29/2024, 10:30:00 AM"

        // Обновляем содержимое тега <h6> с отформатированной датой и временем
        document.getElementById('currentDateTime').textContent = formattedDateTime;
    }

    // Обновляем дату и время при загрузке страницы
    updateDateTime();

    // Затем устанавливаем интервал для обновления даты и времени каждую секунду (или другой период)
    setInterval(updateDateTime, 1000); // Обновляем каждую секунду
});


function addNumber(fieldName, counterName) {
    // Получаем значение поля
    var fieldValue = document.getElementsByName(fieldName)[0].value;
    // Получаем элемент счетчика
    var counterField = document.getElementsByName(counterName)[0];

    // Проверяем, не пустое ли поле
    if (fieldValue !== '') {
        // Если поле не пустое, делаем счетчик обязательным
        counterField.required = true;
    } else {
        // Если поле пустое, удаляем обязательность счетчика
        counterField.required = false;
    }
}


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

//// Функция для проверки времени и вызова exportAndDownloadExcel() в нужное время
//function executeAtSpecificTime(hour, minute) {
//    var now = new Date();
//    var currentHour = now.getHours();
//    var currentMinute = now.getMinutes();
//
//    if (currentHour === hour && currentMinute === minute) {
//        // Вызываем функцию для формирования и скачивания файла Excel
//        exportAndDownloadExcel();
//    }
//}
//
//// Устанавливаем интервал проверки времени каждую минуту
//setInterval(function() {
//    executeAtSpecificTime(12, 00);
//    executeAtSpecificTime(14, 00);
//    executeAtSpecificTime(16, 00);
//    executeAtSpecificTime(18, 00);
//    executeAtSpecificTime(20, 00);
//}, 60000); // 60000 миллисекунд = 1 минута
//exportAndDownloadExcel();





// Функция для обновления информации о количестве выбранных вставок
function updateSelectedCount(inputId, dataListId) {
    var input = document.getElementById(inputId);
    var selectedOption = document.querySelector('#' + dataListId + ' option[value="' + input.value + '"]');

    if (selectedOption) {
        var count = selectedOption.getAttribute('data-count');
        input.setAttribute('data-count', count);
    } else {
        // Очищаем информацию, если опция не выбрана
        input.removeAttribute('data-count');
    }
}

// Вызов функции при загрузке страницы для установки начального значения
updateSelectedCount('tab_3_stick_1_selected', 'tab_3_stick_1');
updateSelectedCount('tab_3_stick_2_selected', 'tab_3_stick_2');
updateSelectedCount('tab_3_stick_3_selected', 'tab_3_stick_3');

// Слушатель события изменения значения в поле ввода
document.getElementById('tab_3_stick_1_selected').addEventListener('input', function() {
    updateSelectedCount('tab_3_stick_1_selected', 'tab_3_stick_1');
});

document.getElementById('tab_3_stick_2_selected').addEventListener('input', function() {
    updateSelectedCount('tab_3_stick_2_selected', 'tab_3_stick_2');
});

document.getElementById('tab_3_stick_3_selected').addEventListener('input', function() {
    updateSelectedCount('tab_3_stick_3_selected', 'tab_3_stick_3');
});