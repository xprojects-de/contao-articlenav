<?php

declare(strict_types=1);

use Contao\CoreBundle\DataContainer\PaletteManipulator;

PaletteManipulator::create()
    ->addField('articlenav', 'title_legend', PaletteManipulator::POSITION_PREPEND)
    ->applyToPalette('default', 'tl_article');

$GLOBALS['TL_DCA']['tl_article']['fields']['articlenav'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_article']['articlenav'],
    'inputType' => 'checkbox',
    'exclude' => true,
    'eval' => array('tl_class' => 'clr wizard'),
    'sql' => "int(10) unsigned NOT NULL default '0'"
);
