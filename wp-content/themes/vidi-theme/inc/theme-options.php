<?php



use Carbon_Fields\Container;

use Carbon_Fields\Field;



Container::make('theme_options', 'Настройки сайта')

        ->set_page_menu_position( 2 )

        ->set_icon ('dashicons-admin-generic')

        
        ->add_tab(__('Хедер сайта'), array(
            Field::make ('text', 'header_contacts_tel', 'Текст кнопки'),
            Field::make ('text', 'header_contacts_tel_link', 'Ссылка на номер телефона')
                ->help_text('ссылка на номер телефона вида tel:+700000000, whatsApp - https://wa.me/+7900000000'),
            Field::make('image', 'header_contacts_tel_link_image', 'Иконка')
        ))
        
        ->add_tab(__('Футер сайта'), array(

            Field::make('complex', 'footer_contacts', 'Ссылки')

                ->add_fields( array(

                    Field::make('text', 'footer_contact_name', 'Название')

                        ->set_width(33),

                    Field::make('text', 'footer_contact_link', 'Ссылка на контакт')

                        ->set_width(33),

                    Field::make('image', 'footer_contact_image', 'Иконка контакта')

                        ->set_width(33),

                )),

            Field::make('text', 'footer_tel_contact_link', 'Ссылка на телефон')

            ->set_width(33)

            ->help_text('ссылка на телефон вида tel:+700000000, whatsApp - https://wa.me/+7900000000'),

            Field::make('text', 'footer_tel_contact', 'Номер телефона')

            ->set_width(33)

            ->help_text('Номер телефона, отображающийся на сайте')
           

))




->add_tab(__('Contact Form'), array(

            Field::make('text', 'contactform1_head', 'Contact form#1 heading'),
            Field::make('text', 'contactform2_head', 'Contact form#2 heading'),
            Field::make('text', 'contactform_shortcode', 'Contact form#1 shortcode'),

));

