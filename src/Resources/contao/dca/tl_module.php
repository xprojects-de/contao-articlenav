<?php

declare(strict_types=1);

$GLOBALS['TL_DCA']['tl_module']['palettes']['xarticlenav'] = '{title_legend},name,type;articlenavpageid,navigationTpl;{expert_legend:hide},cssID';

$GLOBALS['TL_DCA']['tl_module']['fields']['articlenavpageid'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_module']['articlenavpageid'],
    'exclude' => true,
    'inputType' => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval' => array('fieldType' => 'radio', 'tl_class' => 'clr'),
    'relation' => array('type' => 'hasOne', 'load' => 'eager'),
    'sql' => "int(10) unsigned NOT NULL default '0'"
);
