<<<<<<< Upstream, based on origin/master
<?php
// Heading
$_['heading_title']                = 'UPS';

// Text
$_['text_extension']               = 'Доставка';
$_['text_success']                 = 'Успех: Вы изменили доставку UPS!';
$_['text_edit']                    = 'Редактировать доставку UPS';
$_['text_regular_daily_pickup']    = 'Регулярная ежедневная доставка';
$_['text_daily_pickup']            = 'Ежедневная доставка';
$_['text_customer_counter']        = 'Счетчик заказчика';
$_['text_one_time_pickup']         = 'Разовая доставка';
$_['text_on_call_air_pickup']      = 'Авиа-доставка по требованию';
$_['text_letter_center']           = 'Центр сообщений';
$_['text_air_service_center']      = 'Центр авиа обслуживания';
$_['text_suggested_retail_rates']  = 'Рекомендуемая розничная цена (UPS Store)';
$_['text_package']                 = 'Пакет';
$_['text_ups_letter']              = 'Письмо UPS';
$_['text_ups_tube']                = 'Трубопровод UPS';
$_['text_ups_pak']                 = 'Упаковка UPS';
$_['text_ups_express_box']         = 'UPS Express-Box';
$_['text_ups_25kg_box']            = 'UPS упаковка 25 кг';
$_['text_ups_10kg_box']            = 'UPS упаковка 10 кг';
$_['text_us']                      = 'Место происхождения: США';
$_['text_ca']                      = 'Место происхождения: Канада';
$_['text_eu']                      = 'Место происхождения: Евросоюз';
$_['text_pr']                      = 'Место происхождения: Пуэрто-Рико';
$_['text_mx']                      = 'Место происхождения: Мексика';
$_['text_other']                   = 'Другие места происхождения';
$_['text_test']                    = 'Проверка';
$_['text_production']              = 'Производство';
$_['text_residential']             = 'Бытовой';
$_['text_commercial']              = 'Коммерческие';
$_['text_next_day_air']            = 'UPS Next Day Air';
$_['text_2nd_day_air']             = 'UPS Second Day Air';
$_['text_ground']                  = 'UPS Ground';
$_['text_3_day_select']            = 'UPS Three-Day Select';
$_['text_next_day_air_saver']      = 'UPS Next Day Air Saver';
$_['text_next_day_air_early_am']   = 'UPS Next Day Air Early A.M.';
$_['text_2nd_day_air_am']          = 'UPS Second Day Air A.M.';
$_['text_saver']                   = 'UPS Saver';
$_['text_worldwide_express']       = 'UPS Worldwide Express';
$_['text_worldwide_expedited']     = 'UPS Worldwide Expedited';
$_['text_standard']                = 'UPS Standard';
$_['text_worldwide_express_plus']  = 'UPS Worldwide Express Plus';
$_['text_express']                 = 'UPS Express';
$_['text_expedited']               = 'UPS Expedited';
$_['text_express_early_am']        = 'UPS Express Early A.M.';
$_['text_express_plus']            = 'UPS Express Plus';
$_['text_today_standard']          = 'UPS Today Standard';
$_['text_today_dedicated_courier'] = 'UPS Today Dedicated Courier';
$_['text_today_intercity']         = 'UPS Today Intercity';
$_['text_today_express']           = 'UPS Today Express';
$_['text_today_express_saver']     = 'UPS Today Express Saver';

// Entry
$_['entry_key']                    = 'Ключ доступа';
$_['entry_username']               = 'Логин';
$_['entry_password']               = 'Пароль';
$_['entry_pickup']                 = 'Pickup Method';
$_['entry_packaging']              = 'Packaging Type';
$_['entry_classification']         = 'Customer Classification Code';
$_['entry_origin']                 = 'Shipping Origin Code';
$_['entry_city']                   = 'Город происхождения';
$_['entry_state']                  = 'Штат/провинция происхождения';
$_['entry_country']                = 'Страна происхождения';
$_['entry_postcode']               = 'Zip/почтовый индекс места происхождения';
$_['entry_test']                   = 'Тестовый режим';
$_['entry_quote_type']             = 'Quote Type';
$_['entry_service']                = 'Услуги';
$_['entry_insurance']              = 'Включить страхование';
$_['entry_display_weight']         = 'Показать вес посылки';
$_['entry_weight_class']           = 'Класс веса';
$_['entry_length_class']           = 'Класс длины';
$_['entry_dimension']			   = 'Габаритные размеры (Д x Ш x В)';
$_['entry_length']                 = 'Длина';
$_['entry_height']                 = 'Высота';
$_['entry_width']                  = 'Width';
$_['entry_tax_class']              = 'Tax Class';
$_['entry_geo_zone']               = 'Geo Zone';
$_['entry_status']                 = 'Status';
$_['entry_sort_order']             = 'Sort Order';
$_['entry_debug']      			   = 'Debug Mode';

// Help
$_['help_key']                     = 'Enter the XML rates access key assigned to you by UPS.';
$_['help_username']                = 'Enter your UPS Services account username.';
$_['help_password']                = 'Enter your UPS Services account password.';
$_['help_pickup']                  = 'How do you give packages to UPS (only used when origin is US)?';
$_['help_packaging']               = 'What kind of packaging do you use?';
$_['help_classification']          = '01 - If you are billing to a UPS account and have a daily UPS pickup, 03 - If you do not have a UPS account or you are billing to a UPS account but do not have a daily pickup, 04 - If you are shipping from a retail outlet (only used when origin is US)';
$_['help_origin']                  = 'What origin point should be used (this setting affects only what UPS product names are shown to the user)';
$_['help_city']                    = 'Enter the name of the origin city.';
$_['help_state']                   = 'Enter the two-letter code for your origin state/province.';
$_['help_country']                 = 'Enter the two-letter code for your origin country.';
$_['help_postcode']                = 'Enter your origin zip/postalcode.';
$_['help_test']                    = 'Use this module in Test (YES) or Production mode (NO)?';
$_['help_quote_type']              = 'Quote for Residential or Commercial Delivery.';
$_['help_service']                 = 'Select the UPS services to be offered.';
$_['help_insurance']               = 'Enables insurance with product total as the value';
$_['help_display_weight']          = 'Do you want to display the shipping weight? (e.g. Delivery Weight : 2.7674 kg)';
$_['help_weight_class']            = 'Set to kilograms or pounds.';
$_['help_length_class']            = 'Выбрать сантиметры или дюймы.';
$_['help_dimension']			   = 'This is assumed to be your average packing box size. Individual item dimensions are not supported at this time so you must enter average dimensions like 5x5x5.';
$_['help_debug']      			   = 'Сохранять данные о посылках в системном журнале';

// Error
$_['error_permission']             = 'Внимание: Нет прав для на изменение настроек доставки UPS (США)!';
$_['error_key']                    = 'Требуется ключ доступа!';
$_['error_username']               = 'Введите имя пользователя!';
$_['error_password']               = 'Введите пароль!';
$_['error_city']                   = 'Город происхождения!';
$_['error_state']                  = 'Введите штат/провинцию происхождения!';
$_['error_country']                = 'Введите страну происхождения!';
$_['error_dimension']              = 'Введите средние размеры!';
=======
<<<<<<< HEAD
<?php
// Heading
$_['heading_title']                = 'UPS';

// Text
$_['text_extension']               = 'Доставка';
$_['text_success']                 = 'Успех: Вы изменили доставку UPS!';
$_['text_edit']                    = 'Редактировать доставку UPS';
$_['text_regular_daily_pickup']    = 'Регулярная ежедневная доставка';
$_['text_daily_pickup']            = 'Ежедневная доставка';
$_['text_customer_counter']        = 'Счетчик заказчика';
$_['text_one_time_pickup']         = 'Разовая доставка';
$_['text_on_call_air_pickup']      = 'Авиа-доставка по требованию';
$_['text_letter_center']           = 'Центр сообщений';
$_['text_air_service_center']      = 'Центр авиа обслуживания';
$_['text_suggested_retail_rates']  = 'Рекомендуемая розничная цена (UPS Store)';
$_['text_package']                 = 'Пакет';
$_['text_ups_letter']              = 'Письмо UPS';
$_['text_ups_tube']                = 'Трубопровод UPS';
$_['text_ups_pak']                 = 'Упаковка UPS';
$_['text_ups_express_box']         = 'UPS Express-Box';
$_['text_ups_25kg_box']            = 'UPS упаковка 25 кг';
$_['text_ups_10kg_box']            = 'UPS упаковка 10 кг';
$_['text_us']                      = 'Место происхождения: США';
$_['text_ca']                      = 'Место происхождения: Канада';
$_['text_eu']                      = 'Место происхождения: Евросоюз';
$_['text_pr']                      = 'Место происхождения: Пуэрто-Рико';
$_['text_mx']                      = 'Место происхождения: Мексика';
$_['text_other']                   = 'Другие места происхождения';
$_['text_test']                    = 'Проверка';
$_['text_production']              = 'Производство';
$_['text_residential']             = 'Бытовой';
$_['text_commercial']              = 'Коммерческие';
$_['text_next_day_air']            = 'UPS Next Day Air';
$_['text_2nd_day_air']             = 'UPS Second Day Air';
$_['text_ground']                  = 'UPS Ground';
$_['text_3_day_select']            = 'UPS Three-Day Select';
$_['text_next_day_air_saver']      = 'UPS Next Day Air Saver';
$_['text_next_day_air_early_am']   = 'UPS Next Day Air Early A.M.';
$_['text_2nd_day_air_am']          = 'UPS Second Day Air A.M.';
$_['text_saver']                   = 'UPS Saver';
$_['text_worldwide_express']       = 'UPS Worldwide Express';
$_['text_worldwide_expedited']     = 'UPS Worldwide Expedited';
$_['text_standard']                = 'UPS Standard';
$_['text_worldwide_express_plus']  = 'UPS Worldwide Express Plus';
$_['text_express']                 = 'UPS Express';
$_['text_expedited']               = 'UPS Expedited';
$_['text_express_early_am']        = 'UPS Express Early A.M.';
$_['text_express_plus']            = 'UPS Express Plus';
$_['text_today_standard']          = 'UPS Today Standard';
$_['text_today_dedicated_courier'] = 'UPS Today Dedicated Courier';
$_['text_today_intercity']         = 'UPS Today Intercity';
$_['text_today_express']           = 'UPS Today Express';
$_['text_today_express_saver']     = 'UPS Today Express Saver';

// Entry
$_['entry_key']                    = 'Ключ доступа';
$_['entry_username']               = 'Логин';
$_['entry_password']               = 'Пароль';
$_['entry_pickup']                 = 'Pickup Method';
$_['entry_packaging']              = 'Packaging Type';
$_['entry_classification']         = 'Customer Classification Code';
$_['entry_origin']                 = 'Shipping Origin Code';
$_['entry_city']                   = 'Город происхождения';
$_['entry_state']                  = 'Штат/провинция происхождения';
$_['entry_country']                = 'Страна происхождения';
$_['entry_postcode']               = 'Zip/почтовый индекс места происхождения';
$_['entry_test']                   = 'Тестовый режим';
$_['entry_quote_type']             = 'Quote Type';
$_['entry_service']                = 'Услуги';
$_['entry_insurance']              = 'Включить страхование';
$_['entry_display_weight']         = 'Показать вес посылки';
$_['entry_weight_class']           = 'Класс веса';
$_['entry_length_class']           = 'Класс длины';
$_['entry_dimension']			   = 'Габаритные размеры (Д x Ш x В)';
$_['entry_length']                 = 'Длина';
$_['entry_height']                 = 'Высота';
$_['entry_width']                  = 'Width';
$_['entry_tax_class']              = 'Tax Class';
$_['entry_geo_zone']               = 'Geo Zone';
$_['entry_status']                 = 'Status';
$_['entry_sort_order']             = 'Sort Order';
$_['entry_debug']      			   = 'Debug Mode';

// Help
$_['help_key']                     = 'Enter the XML rates access key assigned to you by UPS.';
$_['help_username']                = 'Enter your UPS Services account username.';
$_['help_password']                = 'Enter your UPS Services account password.';
$_['help_pickup']                  = 'How do you give packages to UPS (only used when origin is US)?';
$_['help_packaging']               = 'What kind of packaging do you use?';
$_['help_classification']          = '01 - If you are billing to a UPS account and have a daily UPS pickup, 03 - If you do not have a UPS account or you are billing to a UPS account but do not have a daily pickup, 04 - If you are shipping from a retail outlet (only used when origin is US)';
$_['help_origin']                  = 'What origin point should be used (this setting affects only what UPS product names are shown to the user)';
$_['help_city']                    = 'Enter the name of the origin city.';
$_['help_state']                   = 'Enter the two-letter code for your origin state/province.';
$_['help_country']                 = 'Enter the two-letter code for your origin country.';
$_['help_postcode']                = 'Enter your origin zip/postalcode.';
$_['help_test']                    = 'Use this module in Test (YES) or Production mode (NO)?';
$_['help_quote_type']              = 'Quote for Residential or Commercial Delivery.';
$_['help_service']                 = 'Select the UPS services to be offered.';
$_['help_insurance']               = 'Enables insurance with product total as the value';
$_['help_display_weight']          = 'Do you want to display the shipping weight? (e.g. Delivery Weight : 2.7674 kg)';
$_['help_weight_class']            = 'Set to kilograms or pounds.';
$_['help_length_class']            = 'Выбрать сантиметры или дюймы.';
$_['help_dimension']			   = 'This is assumed to be your average packing box size. Individual item dimensions are not supported at this time so you must enter average dimensions like 5x5x5.';
$_['help_debug']      			   = 'Сохранять данные о посылках в системном журнале';

// Error
$_['error_permission']             = 'Внимание: Нет прав для на изменение настроек доставки UPS (США)!';
$_['error_key']                    = 'Требуется ключ доступа!';
$_['error_username']               = 'Введите имя пользователя!';
$_['error_password']               = 'Введите пароль!';
$_['error_city']                   = 'Город происхождения!';
$_['error_state']                  = 'Введите штат/провинцию происхождения!';
$_['error_country']                = 'Введите страну происхождения!';
=======
<?php
// Heading
$_['heading_title']                = 'UPS';

// Text
$_['text_extension']               = 'Доставка';
$_['text_success']                 = 'Успех: Вы изменили доставку UPS!';
$_['text_edit']                    = 'Редактировать доставку UPS';
$_['text_regular_daily_pickup']    = 'Регулярная ежедневная доставка';
$_['text_daily_pickup']            = 'Ежедневная доставка';
$_['text_customer_counter']        = 'Счетчик заказчика';
$_['text_one_time_pickup']         = 'Разовая доставка';
$_['text_on_call_air_pickup']      = 'Авиа-доставка по требованию';
$_['text_letter_center']           = 'Центр сообщений';
$_['text_air_service_center']      = 'Центр авиа обслуживания';
$_['text_suggested_retail_rates']  = 'Рекомендуемая розничная цена (UPS Store)';
$_['text_package']                 = 'Пакет';
$_['text_ups_letter']              = 'Письмо UPS';
$_['text_ups_tube']                = 'Трубопровод UPS';
$_['text_ups_pak']                 = 'Упаковка UPS';
$_['text_ups_express_box']         = 'UPS Express-Box';
$_['text_ups_25kg_box']            = 'UPS упаковка 25 кг';
$_['text_ups_10kg_box']            = 'UPS упаковка 10 кг';
$_['text_us']                      = 'Место происхождения: США';
$_['text_ca']                      = 'Место происхождения: Канада';
$_['text_eu']                      = 'Место происхождения: Евросоюз';
$_['text_pr']                      = 'Место происхождения: Пуэрто-Рико';
$_['text_mx']                      = 'Место происхождения: Мексика';
$_['text_other']                   = 'Другие места происхождения';
$_['text_test']                    = 'Проверка';
$_['text_production']              = 'Производство';
$_['text_residential']             = 'Бытовой';
$_['text_commercial']              = 'Коммерческие';
$_['text_next_day_air']            = 'UPS Next Day Air';
$_['text_2nd_day_air']             = 'UPS Second Day Air';
$_['text_ground']                  = 'UPS Ground';
$_['text_3_day_select']            = 'UPS Three-Day Select';
$_['text_next_day_air_saver']      = 'UPS Next Day Air Saver';
$_['text_next_day_air_early_am']   = 'UPS Next Day Air Early A.M.';
$_['text_2nd_day_air_am']          = 'UPS Second Day Air A.M.';
$_['text_saver']                   = 'UPS Saver';
$_['text_worldwide_express']       = 'UPS Worldwide Express';
$_['text_worldwide_expedited']     = 'UPS Worldwide Expedited';
$_['text_standard']                = 'UPS Standard';
$_['text_worldwide_express_plus']  = 'UPS Worldwide Express Plus';
$_['text_express']                 = 'UPS Express';
$_['text_expedited']               = 'UPS Expedited';
$_['text_express_early_am']        = 'UPS Express Early A.M.';
$_['text_express_plus']            = 'UPS Express Plus';
$_['text_today_standard']          = 'UPS Today Standard';
$_['text_today_dedicated_courier'] = 'UPS Today Dedicated Courier';
$_['text_today_intercity']         = 'UPS Today Intercity';
$_['text_today_express']           = 'UPS Today Express';
$_['text_today_express_saver']     = 'UPS Today Express Saver';

// Entry
$_['entry_key']                    = 'Ключ доступа';
$_['entry_username']               = 'Логин';
$_['entry_password']               = 'Пароль';
$_['entry_pickup']                 = 'Pickup Method';
$_['entry_packaging']              = 'Packaging Type';
$_['entry_classification']         = 'Customer Classification Code';
$_['entry_origin']                 = 'Shipping Origin Code';
$_['entry_city']                   = 'Город происхождения';
$_['entry_state']                  = 'Штат/провинция происхождения';
$_['entry_country']                = 'Страна происхождения';
$_['entry_postcode']               = 'Zip/почтовый индекс места происхождения';
$_['entry_test']                   = 'Тестовый режим';
$_['entry_quote_type']             = 'Quote Type';
$_['entry_service']                = 'Услуги';
$_['entry_insurance']              = 'Включить страхование';
$_['entry_display_weight']         = 'Показать вес посылки';
$_['entry_weight_class']           = 'Класс веса';
$_['entry_length_class']           = 'Класс длины';
$_['entry_dimension']			   = 'Габаритные размеры (Д x Ш x В)';
$_['entry_length']                 = 'Длина';
$_['entry_height']                 = 'Высота';
$_['entry_width']                  = 'Width';
$_['entry_tax_class']              = 'Tax Class';
$_['entry_geo_zone']               = 'Geo Zone';
$_['entry_status']                 = 'Status';
$_['entry_sort_order']             = 'Sort Order';
$_['entry_debug']      			   = 'Debug Mode';

// Help
$_['help_key']                     = 'Enter the XML rates access key assigned to you by UPS.';
$_['help_username']                = 'Enter your UPS Services account username.';
$_['help_password']                = 'Enter your UPS Services account password.';
$_['help_pickup']                  = 'How do you give packages to UPS (only used when origin is US)?';
$_['help_packaging']               = 'What kind of packaging do you use?';
$_['help_classification']          = '01 - If you are billing to a UPS account and have a daily UPS pickup, 03 - If you do not have a UPS account or you are billing to a UPS account but do not have a daily pickup, 04 - If you are shipping from a retail outlet (only used when origin is US)';
$_['help_origin']                  = 'What origin point should be used (this setting affects only what UPS product names are shown to the user)';
$_['help_city']                    = 'Enter the name of the origin city.';
$_['help_state']                   = 'Enter the two-letter code for your origin state/province.';
$_['help_country']                 = 'Enter the two-letter code for your origin country.';
$_['help_postcode']                = 'Enter your origin zip/postalcode.';
$_['help_test']                    = 'Use this module in Test (YES) or Production mode (NO)?';
$_['help_quote_type']              = 'Quote for Residential or Commercial Delivery.';
$_['help_service']                 = 'Select the UPS services to be offered.';
$_['help_insurance']               = 'Enables insurance with product total as the value';
$_['help_display_weight']          = 'Do you want to display the shipping weight? (e.g. Delivery Weight : 2.7674 kg)';
$_['help_weight_class']            = 'Set to kilograms or pounds.';
$_['help_length_class']            = 'Выбрать сантиметры или дюймы.';
$_['help_dimension']			   = 'This is assumed to be your average packing box size. Individual item dimensions are not supported at this time so you must enter average dimensions like 5x5x5.';
$_['help_debug']      			   = 'Сохранять данные о посылках в системном журнале';

// Error
$_['error_permission']             = 'Внимание: Нет прав для на изменение настроек доставки UPS (США)!';
$_['error_key']                    = 'Требуется ключ доступа!';
$_['error_username']               = 'Введите имя пользователя!';
$_['error_password']               = 'Введите пароль!';
$_['error_city']                   = 'Город происхождения!';
$_['error_state']                  = 'Введите штат/провинцию происхождения!';
$_['error_country']                = 'Введите страну происхождения!';
>>>>>>> origin/master
$_['error_dimension']              = 'Введите средние размеры!';
>>>>>>> 0ccdbb6 Фиксация 21,01,2019
