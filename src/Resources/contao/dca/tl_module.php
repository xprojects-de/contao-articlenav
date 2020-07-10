<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['xarticlenav'] = '{title_legend},name,type;xarticlenavpageid,navigationTpl;{expert_legend:hide},cssID';

$GLOBALS['TL_DCA']['tl_module']['fields']['xarticlenavpageid'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_module']['xarticlenavpageid'],
    'exclude' => true,
    'inputType' => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval' => array('fieldType' => 'radio', 'tl_class' => 'clr'),
    'relation' => array('type' => 'hasOne', 'load' => 'eager'),
    'sql' => "int(10) unsigned NOT NULL default '0'"
);
