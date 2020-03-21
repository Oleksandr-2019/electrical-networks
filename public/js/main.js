'use strict';//може працювати і без строго режиму

// створення кнопки "add_telephone_numbers_link"
var $addTelephoneNumbersButton = $('<button type="button" class="add_telephone_numbers_link">Додати телефон</button>');
var $newLinkLi = $('<li></li>').append($addTelephoneNumbersButton);
var $numberClick = -1;


jQuery(document).ready(function() {

    //визначаєм сторрінку оновлення
    //шляхом визначення чи існують вже якісь номери на сторінкі
    var $realTelNumbers = $('.realTelNumbersWrap');
    var $realTelNumbersLength = $realTelNumbers.find('div input').length;
    if ($realTelNumbersLength !== 0) {
        $numberClick = $realTelNumbersLength
    }

    // Отримує ul, який містить колекцію тегів пропонованих номерів
    var $collectionHolder = $('ul.classTelephoneNumbers');

    //додає якір "Додати телефон" та li до тегів ul
    $collectionHolder.append($newLinkLi);

    // підраховуємо наявні вхідні дані форми, використовуємо це як нове
    // покажчик при вставці нового елемента (шукає кількість li у яких всередині є input)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);


    $addTelephoneNumbersButton.on('click', function(e) {
        // додає форму нового тегу (див. наступний блок коду)
        // тобто запускає функцію addTelephoneNumbersForm
        console.log($numberClick = $numberClick + 1);


        addTelephoneNumbersForm($collectionHolder, $newLinkLi, $numberClick);
    });

    function addTelephoneNumbersForm($collectionHolder, $newLinkLi, $numberClick) {

        // Отримує пояснення-прототип даних раніше
        var prototype = $collectionHolder.data('prototype');

        // отримує новий індекс
        var index = $collectionHolder.data('index');

        var newForm = prototype;

        // Це потрібно вам, лише якщо ви не встановили 'label' => false у полі своїх тегів у ContractDetailsType
        // Замініть '__name__label__' у HTML-прототипі на
        // замість цього буде число, залежно від кількості телефонниз номерів у нас
        //newForm = newForm.replace(/__name__label__/g, index);


        // Замініть '__name__' у HTML прототипу на
        // замість цього буде число, залежно від кількості предметів у нас
        //newForm = newForm.replace(/__name__/g, index);

        // збільшити індекс на один для наступного пункту
        //$collectionHolder.data('index', index + 1);

        // Відобразити форму на сторінці в лі, перед посиланням "Додати тег"
        //var $newFormLi = $('<li></li>').append(newForm);



        newForm = newForm.replace(/contacts/g, $numberClick);

        var $newFormLi = $('<li></li>').append(newForm);
        $newLinkLi.before($newFormLi);


    }

});



// Пока браузеры еще не договорились.. заботимся об этом сами!
var battery = navigator.battery || navigator.webkitBattery || navigator.mozBattery;

console.log("Cтатус зарядки батареи: ", battery.charging); // true
console.log("Уровень зарядки батареи: ", battery.level); // 0.58
console.log("Осталось времени: ", battery.dischargingTime); // 600

battery.addEventListener("chargingchange", function(e) {
    console.log("Изменен статус зарядки батареи: ", battery.charging);
}, false);
battery.addEventListener("chargingtimechange", function(e) {
    console.log("Изменено время до конца зарядки: ", battery.chargingTime);
}, false);
battery.addEventListener("dischargingtimechange", function(e) {
    console.log("Изменено время оставшееся до разрядки: ", battery.dischargingTime);
}, false);
battery.addEventListener("levelchange", function(e) {
    console.log("Изменен уровень зарядки: ", battery.level);
}, false);






