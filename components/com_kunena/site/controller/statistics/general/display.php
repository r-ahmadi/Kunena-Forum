<?php
/**
 * Kunena Component
 * @package     Kunena.Site
 * @subpackage  Controller.Statistics
 *
 * @copyright   (C) 2008 - 2015 Kunena Team. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link        http://www.kunena.org
 **/
defined('_JEXEC') or die;

/**
 * Class ComponentKunenaControllerStatisticsGeneralDisplay
 *
 * @since  K4.0
 */
class ComponentKunenaControllerStatisticsGeneralDisplay extends KunenaControllerDisplay
{
	protected $name = 'Statistics/General';

	/**
	 * Prepare general statistics display.
	 *
	 * @return void
	 *
	 * @throws KunenaExceptionAuthorise
	 */
	protected function before()
	{
		parent::before();

		$this->config = KunenaConfig::getInstance();

		if (!$this->config->get('showstats'))
		{
			throw new KunenaExceptionAuthorise(JText::_('COM_KUNENA_NO_ACCESS'), '404');
		}

		if (!$this->config->statslink_allowed && JFactory::getUser()->guest)
		{
			throw new KunenaExceptionAuthorise(JText::_('COM_KUNENA_NO_ACCESS'), '401');
		}

		$statistics = KunenaForumStatistics::getInstance();
		$statistics->loadAll();
		$this->setProperties($statistics);

		$this->latestMemberLink = KunenaFactory::getUser((int) $this->lastUserId)->getLink();
		$this->userlistUrl = KunenaFactory::getProfile()->getUserListUrl();
	}

	/**
	 * Prepare document.
	 *
	 * @return void
	 */
	protected function prepareDocument()
	{
		$this->setTitle(JText::_('COM_KUNENA_STAT_FORUMSTATS'));
		$keywords = $this->config->board_title . ', ' . JText::_('COM_KUNENA_STAT_FORUMSTATS');
		$this->setKeywords($keywords);
		$description = JText::_('COM_KUNENA_STAT_FORUMSTATS') . ': ' . $this->config->board_title ;
		$this->setDescription($description);
	}
}
