<?php

/**
 * Created by PhpStorm.
 * User: elliot
 * Date: 14/10/16
 * Time: 1:49 PM
 */
class SasquatchAdmin extends ModelAdmin
{
    public static $url_segment = 'sasquatch';

    public static $menu_title = 'Sasquatch';

    public static $managed_models = array(
        'SasquatchConfig' => array(
            'title' => 'Configuration'
        )
    );

    public function getEditForm($id = null, $fields = null) {
        $form = parent::getEditForm();

//        $form->Fields()->removeByName('SasquatchConfig');
        return $form;
    }
}