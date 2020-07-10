<?php

$GLOBALS['TL_DCA']['tl_article']['palettes']['default'] = str_replace('{title_legend}', 'xarticlenav;{title_legend}', $GLOBALS['TL_DCA']['tl_article']['palettes']['default']);
$GLOBALS['TL_DCA']['tl_article']['fields']['xarticlenav'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_article']['xarticlenav'],
    'inputType' => 'checkbox',
    'exclude' => true,
    'eval' => array('tl_class' => 'clr wizard'),
    'sql' => "int(10) unsigned NOT NULL default '0'"
);
