<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Richard Henkenjohann 2013
 * @author     Richard Henkenjohann
 * @license    LGPL
 */


/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_iso_groups']['palettes']['default'] = str_replace
(
	',name',
	',name,category,products',
	$GLOBALS['TL_DCA']['tl_iso_groups']['palettes']['default']
);


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_iso_groups']['fields']['category'] = array
(
	'label'             => &$GLOBALS['TL_LANG']['tl_iso_related_products']['category'],
	'exclude'           => true,
	'filter'            => true,
	'inputType'         => 'select',
	'foreignKey'        => 'tl_iso_related_categories.name',
	'eval'              => array('mandatory'=>true, 'includeBlankOption'=>true, 'chosen'=>true)
);

$GLOBALS['TL_DCA']['tl_iso_groups']['fields']['products'] = array
(
	'label'             => &$GLOBALS['TL_LANG']['tl_iso_related_products']['products'],
	'exclude'           => true,
	'inputType'         => 'productTree',
	'eval'              => array('mandatory'=>true, 'fieldType'=>'checkbox', 'variants'=>true, 'tl_class'=>'clr'),
);