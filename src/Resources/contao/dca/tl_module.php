<?php

declare(strict_types=1);

use XProjects\Articlenav\Controller\ArticlenavController;

$GLOBALS['TL_DCA']['tl_module']['palettes'][ArticlenavController::TYPE] = '{title_legend},name,type;articlenavpageid;articlenavoffsettop;{template_legend:hide},customTpl;{expert_legend:hide},cssID';

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

$GLOBALS['TL_DCA']['tl_module']['fields']['articlenavoffsettop'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_module']['articlenavoffsettop'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class' => 'clr'),
    'sql' => "int(10) unsigned NOT NULL default '0'"
);
