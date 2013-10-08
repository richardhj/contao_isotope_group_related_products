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
 * @copyright  Isotope eCommerce Workgroup 2009-2012
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @author     Fred Bliss <fred.bliss@intelligentspark.com>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


/**
 * Class ModuleIsotopeRelatedProducts
 * List products related to the current product reader.
 */
class ModuleIsotopeRelatedProductsByGroups extends ModuleIsotopeRelatedProducts
{

	/**
	 * Do not cache related products cause the list is different depending on URL parameters
	 * @var boolean
	 */
	protected $blnCacheProducts = false;


	/**
	 * Generate the module
	 * @return string
	 */
	public function generate()
	{
		return parent::generate();
	}


	/**
	 * Find all products we need to list.
	 * @param null $arrCacheIds
	 * @return array
	 */
	protected function findProducts($arrCacheIds=null)
	{
		$strAlias = $this->Input->get('product');
		$arrIds = array(0);
		$arrJumpTo = array();

		// Added following 2 lines
		$objCategories = $this->Database->prepare("SELECT *, (SELECT jumpTo FROM tl_iso_related_categories WHERE id=category) AS jumpTo FROM tl_iso_groups WHERE id IN (SELECT gid FROM tl_iso_products WHERE " . (is_numeric($strAlias) ? 'id' : 'alias') . "=?" . ($this->iso_list_where != '' ? ' AND '.$this->iso_list_where : '') . ") AND category IN (" . implode(',', $this->iso_related_categories) . ") ORDER BY id=" . implode(' DESC, id=', $this->iso_related_categories) . " DESC")->execute($strAlias);

		if ($objCategories->numRows < 1)
		{
			$objCategories = $this->Database->prepare("SELECT *, (SELECT jumpTo FROM tl_iso_related_categories WHERE id=category) AS jumpTo FROM tl_iso_related_products WHERE pid IN (SELECT id FROM tl_iso_products WHERE " . (is_numeric($strAlias) ? 'id' : 'alias') . "=?" . ($this->iso_list_where != '' ? ' AND '.$this->iso_list_where : '') . ") AND category IN (" . implode(',', $this->iso_related_categories) . ") ORDER BY id=" . implode(' DESC, id=', $this->iso_related_categories) . " DESC")->execute($strAlias);
		}

		while ($objCategories->next())
		{
			$ids = deserialize($objCategories->products);

			if (is_array($ids) && !empty($ids))
			{
				$arrIds = array_unique(array_merge($arrIds, $ids));

				if ($objCategories->jumpTo)
				{
					$arrJumpTo = array_fill_keys($ids, $objCategories->jumpTo) + $arrJumpTo;
				}
			}
		}

		return IsotopeFrontend::getProducts($arrIds, IsotopeFrontend::getReaderPageId(null, $this->iso_reader_jumpTo));
	}
}
