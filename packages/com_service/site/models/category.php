<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Service Component Category Model
 *
 * @package     Service
 * @subpackage  com_service
 * @since       2.5
 */
class ServiceModelCategory extends JModelList
{
	/**
	 * Category items data
	 *
	 * @var     array
	 */
	protected $_item = null;

	protected $_records = null;

	protected $_siblings = null;

	protected $_children = null;

	protected $_parent = null;

	/**
	 * The category that applies.
	 *
	 * @access  protected
	 * @var     object
	 */
	protected $_category = null;

	/**
	 * The list of other Service categories.
	 *
	 * @access	protected
	 * @var		array
	 */
	protected $_categories = null;

	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JController
	 * @since   2.5
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'title', 'a.title',
				'alias', 'a.alias',
				'checked_out', 'a.checked_out',
				'checked_out_time', 'a.checked_out_time',
				'catid', 'a.catid', 'category_title',
				'published', 'a.published',
				'access', 'a.access', 'access_level',
				'created', 'a.created',
				'created_by', 'a.created_by',
				'modified', 'a.modified',
				'ordering', 'a.ordering',
				'language', 'a.language',
				'hits', 'a.hits',
				'publish_up', 'a.publish_up',
				'publish_down', 'a.publish_down',
				'author', 'a.author'
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 *
	 * @since   2.5
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('site');
		$pk = JRequest::getInt('id');

		$this->setState('category.id', $pk);

		// Load the parameters. Merge Global and Menu Item params into new object
		$params     = $app->getParams();
		$menuParams = new JRegistry;

		if ($menu = $app->getMenu()->getActive()) {
			$menuParams->loadString($menu->params);
		}

		$mergedParams = clone $menuParams;
		$mergedParams->merge($params);
		$this->setState('params', $mergedParams);

		// Optional filter text
		$this->setState('list.filter', JRequest::getString('filter_search'));

		// List state information
		if((int) $params->get('display_num') != (int) $app->getCfg('list_limit')) :
			$limit = $app->getUserStateFromRequest('list.limit', 'limit', $params->get('display_num'), 'uint');
		else:
			$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'), 'uint');
		endif;
		$this->setState('list.limit', $limit);

		$limitstart = JRequest::getUInt('limitstart', 0);
		$this->setState('list.start', $limitstart);

		$orderCol = JRequest::getCmd('filter_order', 'ordering');
		if (!in_array($orderCol, $this->filter_fields))
		{
			$orderCol = 'ordering';
		}
		$this->setState('list.ordering', $orderCol);

		$listOrder = JRequest::getCmd('filter_order_Dir', 'ASC');
		if (!in_array(strtoupper($listOrder), array('ASC', 'DESC', '')))
		{
			$listOrder = 'ASC';
		}
		$this->setState('list.direction', $listOrder);

		$user = JFactory::getUser();
		if ((!$user->authorise('core.edit.state', 'category')) &&  (!$user->authorise('core.edit', 'category')))
		{
			// Limit to published for people who can't edit or edit.state.
			$this->setState('filter.published',	1);

			// Filter by start and end dates.
			$this->setState('filter.publish_date', true);
		}

		$this->setState('filter.language', $app->getLanguageFilter());
	}

	/**
	 * Method to get a list of items.
	 *
	 * @return  mixed  An array of objects on success, false on failure.
	 *
	 * @since   2.5
	 */
	public function getItems()
	{
		// Invoke the parent getItems method to get the main list
		$items = parent::getItems();

		// Convert the params field into an object, saving original in _params
		for ($i = 0, $n = count($items); $i < $n; $i++)
		{
			$item = &$items[$i];
			if (!isset($this->_params))
			{
				$params = new JRegistry;
				$item->params = $params;
				$params->loadString($item->params);
			}

			// get display date
			switch ($item->params->get('list_show_date'))
			{
				case 'modified':
					$item->displayDate = $item->modified;
					break;

				case 'published':
					$item->displayDate = ($item->publish_up == 0) ? $item->created : $item->publish_up;
					break;

				case 'created':
				default:
					$item->displayDate = $item->created;
					break;
			}
		}

		return $items;
	}

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return  string  An SQL query
	 *
	 * @since   2.5
	 */
	protected function getListQuery()
	{
		// Initialiase variables.
		$user   = JFactory::getUser();
		$groups = implode(', ', $user->getAuthorisedViewLevels());

		// Create a new query object.
		$db     = $this->getDbo();
		$query  = $db->getQuery(true);

		// Select required fields from the categories.
		$query->select(
			$this->getState(
				'list.select',
				'a.id, a.title, a.alias, a.checked_out, a.checked_out_time, ' .
				'a.catid, a.created, a.created_by, a.created_by_alias, ' .
				// use created if modified is 0
				'CASE WHEN a.modified = 0 THEN a.created ELSE a.modified END as modified, ' .
				'a.modified_by, uam.name as modified_by_name,' .
				// use created if publish_up is 0
				'CASE WHEN a.publish_up = 0 THEN a.created ELSE a.publish_up END as publish_up,' .
				'a.publish_down, a.access, a.hits'
			)
		);
		$query->from($db->quoteName('#__service') . ' AS a');
		$query->where('a.access IN (' . $groups . ')');

		// Filter by category.
		if ($categoryId = $this->getState('category.id'))
		{
			$query->where('a.catid = ' . (int) $categoryId);
			// Join over the categories.
			$query->select('c.title AS category_title, c.access AS category_access, c.alias AS category_alias');
			$query->join('LEFT', '#__categories AS c ON c.id = a.catid');
			$query->where('c.access IN (' . $groups . ')');
		}

		// Join over the users for the author and modified_by names.
		$query->select("CASE WHEN a.created_by_alias > ' ' THEN a.created_by_alias ELSE ua.name END AS author");
		$query->select("ua.email AS author_email");

		$query->join('LEFT', '#__users AS ua ON ua.id = a.created_by');
		$query->join('LEFT', '#__users AS uam ON uam.id = a.modified_by');

		// Filter by published
		$published = $this->getState('filter.published');

		if (is_numeric($published))
		{
			$query->where('a.published = ' . (int) $published);
		}

		// Filter by start and end dates.
		$nullDate = $db->quote($db->getNullDate());
		$date = JFactory::getDate();
		$nowDate = $db->quote($date->toSql());

		if ($this->getState('filter.publish_date'))
		{
			$query->where('(a.publish_up = ' . $nullDate . ' OR a.publish_up <= ' . $nowDate . ')');
			$query->where('(a.publish_down = ' . $nullDate . ' OR a.publish_down >= ' . $nowDate . ')');
		}

		// process the filter for list views with user-entered filters
		$params = $this->getState('params');

		if ((is_object($params)) && ($params->get('filter_field') != 'hide') && ($filter = $this->getState('list.filter'))) {
			// clean filter variable
			$filter = JString::strtolower($filter);
			switch ($params->get('filter_field'))
			{
				case 'author':
					if(stripos($filter, 'id:') === 0)
					{
						$query->where('a.created_by = ' . (int) substr($filter, 3));
					}
					else
					{
						$filter = $db->Quote('%' . $db->escape($filter, true) . '%');
						$query->where('(LOWER(a.created_by_alias) LIKE ' . $filter . ' OR LOWER(ua.name) LIKE '. $filter .') ');
					}
					break;
				case 'hits':
					$hitsFilter = intval($filter);
					$query->where('a.hits >= '.$hitsFilter.' ');
					break;
				default: // default to 'title' if parameter is not valid
				case 'title':
					if(stripos($filter, 'id:') === 0)
					{
						$query->where('a.id = ' . (int) substr($filter, 3));
					}
					else
					{
						$filter = $db->Quote('%' . $db->escape($filter, true) . '%');
						$query->where('(LOWER(a.title) LIKE ' . $filter . ' OR LOWER(a.alias) LIKE '. $filter .') ');
					}
					break;
			}
		}

		// Filter by language
		if ($this->getState('filter.language'))
		{
			$query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ', ' . $db->quote('*') . ')');
		}

		// Add the list ordering clause.
		$query->order($db->escape($this->getState('list.ordering', 'a.ordering')) . ' ' . $db->escape($this->getState('list.direction', 'ASC')));

		return $query;
	}

	/**
	 * Method to get category data for the current category
	 *
	 * @return  object
	 *
	 * @since   2.5
	 */
	public function getCategory()
	{
		if(!is_object($this->_item))
		{
			$app = JFactory::getApplication();
			$menu = $app->getMenu();
			$active = $menu->getActive();
			$params = new JRegistry;
			if ($active)
			{
				$params->loadString($active->params);
			}

			$options = array();
			$options['countItems'] = $params->get('show_cat_num_items', 1) || $params->get('show_empty_categories', 0);
			$categories = JCategories::getInstance('Service', $options);
			$this->_item = $categories->get($this->getState('category.id', 'root'));

			// Compute selected asset permissions.
			if (is_object($this->_item))
			{
				$user	= JFactory::getUser();
				$userId	= $user->get('id');
				$asset	= 'com_service.category.' . $this->_item->id;

				// Check general create permission.
				if ($user->authorise('core.create', $asset)) {
					$this->_item->getParams()->set('access-create', true);
				}

				$this->_children = $this->_item->getChildren();
				$this->_parent = false;
				if ($this->_item->getParent())
				{
					$this->_parent = $this->_item->getParent();
				}
				$this->_rightsibling = $this->_item->getSibling();
				$this->_leftsibling = $this->_item->getSibling(false);
			}
			else
			{
				$this->_children = false;
				$this->_parent = false;
			}
		}

		return $this->_item;
	}

	/**
	 * Get the parent category.
	 *
	 * @return  mixed  An array of categories or false if an error occurs.
	 *
	 * @since   2.5
	 */
	public function getParent()
	{
		if (!is_object($this->_item))
		{
			$this->getCategory();
		}

		return $this->_parent;
	}

	/**
	 * Get the sibling (adjacent) categories.
	 *
	 * @return  mixed  An array of categories or false if an error occurs.
	 *
	 * @since   2.5
	 */
	function &getLeftSibling()
	{
		if (!is_object($this->_item))
		{
			$this->getCategory();
		}

		return $this->_leftsibling;
	}

	/**
	 * Get the sibling (adjacent) categories.
	 *
	 * @return  mixed  An array of categories or false if an error occurs.
	 *
	 * @since   2.5
	 */
	function &getRightSibling()
	{
		if (!is_object($this->_item))
		{
			$this->getCategory();
		}

		return $this->_rightsibling;
	}

	/**
	 * Get the child categories.
	 *
	 * @return  mixed  An array of categories or false if an error occurs.
	 *
	 * @since   2.5
	 */
	function &getChildren()
	{
		if (!is_object($this->_item))
		{
			$this->getCategory();
		}

		return $this->_children;
	}

	/**
	 * Method to get a JPagination object for the data set.
	 *
	 * @return  JPagination  A JPagination object for the data set.
	 *
	 * @since   2.5
	 */
	function getPagination()
	{
		if(empty($this->_pagination)) :
			require_once (JPATH_COMPONENT . DS . 'helpers/html/pagination.php');
			$limit = (int) $this->getState('list.limit') - (int) $this->getState('list.links');
			$this->_pagination = new ServicePagination($this->getTotal(), $this->getStart(), $limit);
		endif;

		return $this->_pagination;
	}
}