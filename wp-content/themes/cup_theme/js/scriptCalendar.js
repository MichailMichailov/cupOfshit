const calendarGrid = document.getElementById('calendarGrid');
const currentMonthLabel = document.getElementById('currentMonth');
const prevMonthButton = document.getElementById('prevMonth');
const nextMonthButton = document.getElementById('nextMonth');
const dateRangeInput = document.getElementById('dateRangeInput');
const calendarContainer = document.getElementById('calendarContainer');

let currentDate = new Date();
let startDate = null;
let endDate = null;

const dayNames = ['ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ', 'ВС'];

function events(){
  dateRangeInput.addEventListener('focus', () => {
    calendarContainer.style.display = 'block';
  });
  document.addEventListener('click', (event) => {
    if ( !calendarContainer.contains(event.target) && event.target !== dateRangeInput) {
      calendarContainer.style.display = 'none';
      dateRangeInput.blur(); 
    }
  });
  prevMonthButton.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    generateCalendar(currentDate);
    calendarContainer.style.display = 'block';
  });

  nextMonthButton.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    generateCalendar(currentDate);
    calendarContainer.style.display = 'block';
  });

}


// Генерация календаря
function generateCalendar(date) {
  calendarGrid.innerHTML = '';
  dayNames.forEach(day => {
    const dayCell = document.createElement('div');
    dayCell.className = 'day-name';
    dayCell.textContent = day;
    calendarGrid.appendChild(dayCell);
  });

  const year = date.getFullYear();
  const month = date.getMonth();
  const firstDay = new Date(year, month, 1).getDay();
  const lastDay = new Date(year, month + 1, 0).getDate();

  // Смещение для первого дня
  const startOffset = firstDay === 0 ? 6 : firstDay - 1;

  for (let i = 0; i < startOffset; i++) {
    const emptyCell = document.createElement('div');
    emptyCell.className = 'date-cell';
    calendarGrid.appendChild(emptyCell);
  }

  // Генерация дат месяца
  for (let day = 1; day <= lastDay; day++) {
    const dateCell = document.createElement('div');
    dateCell.className = 'date-cell';
    dateCell.textContent = day;
    const cellDate = new Date(year, month, day);

    dateCell.addEventListener('click', () => {
      if (!startDate || (startDate && endDate)) {
        startDate = cellDate;
        endDate = null;
      } else {
        if (cellDate < startDate) {
          endDate = startDate;
          startDate = cellDate;
        } else {
          endDate = cellDate;
        }
      }
      highlightRange();
    });

    calendarGrid.appendChild(dateCell);
  }
  highlightRange();
  currentMonthLabel.textContent = date.toLocaleDateString('ru-RU', { year: 'numeric', month: 'long' });
}

// Выделение диапазона
function highlightRange() {
  const cells = calendarGrid.querySelectorAll('.date-cell');
  cells.forEach(cell => cell.classList.remove('selected', 'range'));

  const start = startDate ? startDate.getTime() : null;
  const end = endDate ? endDate.getTime() : null;

  cells.forEach(cell => {
    const cellDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), parseInt(cell.textContent));
    const cellTime = cellDate.getTime();

    if (start === cellTime) {
      cell.classList.add('selected');
    } else if (end === cellTime) {
      cell.classList.add('selected');
    } else if (start && end && cellTime > start && cellTime < end) {
      cell.classList.add('range');
    }
  });

  if (startDate && endDate) {
    dateRangeInput.value = `${formatDate(startDate)} - ${formatDate(endDate)}`;
    calendarContainer.style.display = 'none';
    dateRangeInput.blur(); 
    const event = new Event('change', { bubbles: true, cancelable: true });
    dateRangeInput.dispatchEvent(event);
  }
}

// Форматирование даты в строку
function formatDate(date) {
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, '0');
  const day = String(date.getDate()).padStart(2, '0'); 
  return `${year}-${month}-${day}`; 
}

generateCalendar(currentDate);
events()


document.addEventListener('DOMContentLoaded',()=>{})
