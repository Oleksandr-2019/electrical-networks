'use strict';//може працювати і без строго режиму

// створення кнопки "add_telephone_numbers_link"
var $addTelephoneNumbersButton = $('<button type="button" class="add_telephone_numbers_link btn btn-primary">Додати телефон</button>');

var $newLinkLi = $('<li></li>').append($addTelephoneNumbersButton);

var $numberClick = -1;

jQuery(document).ready(function() {

    //визначаєм останню цифру в id реальних номерів так як номери що плануються
    //записувать мають бути більшими ніж останнній з уже існуючих
    var $lostNumberElemTRealTelephone = $('fieldset.realTelNumbersWrap div').last().children().attr('id');
    var lastIndex = $lostNumberElemTRealTelephone.lastIndexOf("_");       // позиция последнего пробела
    $lostNumberElemTRealTelephone = $lostNumberElemTRealTelephone.substring($lostNumberElemTRealTelephone.length, lastIndex + 1)


    //$lostNumberElemTRealTelephone = $lostNumberElemTRealTelephone.toString().slice(-1);
    $lostNumberElemTRealTelephone = Number($lostNumberElemTRealTelephone);

    console.log($lostNumberElemTRealTelephone);







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
        $lostNumberElemTRealTelephone = $lostNumberElemTRealTelephone + 1;
        console.log($lostNumberElemTRealTelephone);
        addTelephoneNumbersForm($collectionHolder, $newLinkLi, $numberClick, $lostNumberElemTRealTelephone);
    });



    function addTelephoneNumbersForm($collectionHolder, $newLinkLi, $numberClick, $lostNumberElemTRealTelephone) {

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



        //newForm = newForm.replace(/contacts/g, $numberClick);
        //Формування id ідентифікатора і name для input який буде добавлятись в список нових номерів
        //що планується добавить
        var $dynammicIdAndName = 'contract_details[telephoneNumbers][' + $lostNumberElemTRealTelephone + ']';

        $lostNumberElemTRealTelephone = $lostNumberElemTRealTelephone + 1;

        //newForm =  $('<input type="text" id="5" name="contract_details[telephoneNumbers][5]" class="form-control">')
        //<input type="text" id="5" name="contract_details[telephoneNumbers][5]" class="form-control">
        //<input type="text" id="6" name="contract_details[telephoneNumbers]5]" class="form-control">
        newForm =  $('<input type="text">')
        newForm =  $(newForm).attr('id', $lostNumberElemTRealTelephone);
        newForm =  $(newForm).attr('name', $dynammicIdAndName);
        newForm =  $(newForm).attr('class', 'form-control');


        // Додасть інпут для нового контакту, перед кнопкою "Додати телефон"
        var $newFormLi = $('<li></li>').append(newForm);

        $newLinkLi.before($newFormLi);

    }

});


jQuery(document).ready(function() {
    var buttonMenu = $('.hamburger-menu');
    buttonMenu.on('click', function() {
        $('.hamburger-menu__line-2').toggleClass('hamburger-menu__line--hidden');
        $('.hamburger-menu__line-1').toggleClass('hamburger-menu__line-1--open');
        $('.hamburger-menu__line-3').toggleClass('hamburger-menu__line-3--open');
        $('.navigation-main').slideToggle( "slow" );
    })
    var width_browser = $( window ).width();
    if (width_browser < 1000) {
        $('.navigation-main').hide();
    } else {
        $('.navigation-main').show();
    }
    $(window).resize(function() {

        var width_browser = $( window ).width();
        $('.hamburger-menu__line-2').removeClass('hamburger-menu__line--hidden');
        $('.hamburger-menu__line-1').removeClass('hamburger-menu__line-1--open');
        $('.hamburger-menu__line-3').removeClass('hamburger-menu__line-3--open');
        if (width_browser < 1000) {
            $('.navigation-main').hide();
        } else {
            $('.navigation-main').show();
        }


    });
})