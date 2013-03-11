<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Component Helper
jimport('joomla.application.component.helper');
jimport('joomla.application.categories');

/**
 * Service Component Route Helper
 *
 * @package     Service
 * @subpackage  com_service
 * @since       2.5
 */
abstract class ServiceHelperRoute
{
	protected static $lookup;

	/**
	 * Get the service route
	 *
	 * @param   int  $id     The route of the service.
	 * @param   int  $catid  The id of the category.
	 *
	 * @return  string
	 *
	 * @since   2.5
	 */
	public static function getServiceRoute($id, $catid)
	{
		$needles = array(
			'service' => array((int) $id)
		);

		// Create the link
		$link = 'index.php?option=com_service&view=service&id=' . $id;

		if ((int) $catid > 1)
		{
			$categories = JCategories::getInstance('Service');
			$category = $categories->get((int) $catid);

			if ($category)
			{
				// TODO Throw error that the category either not exists or is unpublished
				$needles['category'] = array_reverse($category->getPath());
				$needles['categories'] = $needles['category'];
				$link .= '&catid=' . $catid;
			}
		}

		if ($item = self::_findItem($needles))
		{
			$link .= '&Itemid=' . $item;
		}
		elseif ($item = self::_findItem())
		{
			$link .= '&Itemid=' . $item;
		}

		return $link;
	}

	/**
	 * Get the categiry route
	 *
	 * @param   int  $catid  The id of the category.
	 *
	 * @return  string
	 *
	 * @since   2.5
	 */
	public static function getCategoryRoute($catid)
	{
		if ($catid instanceof JCategoryNode)
		{
			$id = $catid->id;
			$category = $catid;
		}
		else
		{
			$id = (int) $catid;
			$category = JCategories::getInstance('Service')->get($id);
		}

		if ($id < 1)
		{
			$link = '';
		}
		else
		{
			$needles = array(
				'category' => array($id)
			);

			if ($item = self::_findItem($needles))
			{
				$link = 'index.php?Itemid=' . $item;
			}
			else
			{
				// Create the link
				$link = 'index.php?option=com_service&view=category&id=' . $id;

				if ($category)
				{
					$catids = array_reverse($category->getPath());
					$needles = array(
						'category' => $catids,
						'categories' => $catids
					);

					if ($item = self::_findItem($needles))
					{
						$link .= '&Itemid=' . $item;
					}
					elseif ($item = self::_findItem())
					{
						$link .= '&Itemid=' . $item;
					}
				}
			}
		}

		return $link;
	}

	/**
	 * Find the item
	 *
	 * @param   boleam  $needles  The needles.
	 *
	 * @return  void
	 *
	 * @since   2.5
	 */
	protected static function _findItem($needles = null)
	{
		$app   = JFactory::getApplication();
		$menus = $app->getMenu('site');

		// Prepare the reverse lookup array.
		if (self::$lookup === null)
		{
			self::$lookup = array();

			$component = JComponentHelper::getComponent('com_service');
			$items     = $menus->getItems('component_id', $component->id);

			foreach ($items as $item)
			{
				if (isset($item->query) && isset($item->query['view']))
				{
					$view = $item->query['view'];

					if (!isset(self::$lookup[$view]))
					{
						self::$lookup[$view] = array();
					}
					if (isset($item->query['id']))
					{
						self::$lookup[$view][$item->query['id']] = $item->id;
					}
				}
			}
		}

		if ($needles)
		{
			foreach ($needles as $view => $ids)
			{
				if (isset(self::$lookup[$view]))
				{
					foreach ($ids as $id)
					{
						if (isset(self::$lookup[$view][(int) $id]))
						{
							return self::$lookup[$view][(int) $id];
						}
					}
				}
			}
		}
		else
		{
			$active = $menus->getActive();
			if ($active)
			{
				return $active->id;
			}
		}

		return null;
	}
}