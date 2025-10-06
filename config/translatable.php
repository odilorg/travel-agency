<?php

return [
    /*
     * The locales that can be used in your application.
     */
    'locales' => ['en', 'ru', 'fr'],

    /*
     * The default locale of your application.
     */
    'fallback_locale' => 'en',

    /*
     * The locale key that should be used in the database.
     */
    'locale_key' => 'locale',

    /*
     * The separator used to glue locales to attributes.
     */
    'locale_separator' => '-',

    /*
     * The model attributes that should be translatable.
     */
    'translatable_attributes' => [],

    /*
     * The application locales that your model has translations for.
     */
    'use_property_fallback' => true,

    /*
     * Using MySQL 5.7+ JSON columns for translations
     */
    'use_json_columns' => true,
];
