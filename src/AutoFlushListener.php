<?php

namespace TwentyFifth\Doctrine\Listener;

use Doctrine\ORM\EntityManager;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;

class AutoFlushListener
	implements ListenerAggregateInterface
{
	/**
	 * Attaches a flush and clear listener to the appropriate events
	 * @param EventManagerInterface $events
	 */
	public function attach(EventManagerInterface $events)
	{
		$events->attach(MvcEvent::EVENT_FINISH, array($this, 'flush'));
		$events->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'clear'));
	}

	/**
	 * Detaches the previously attached events
	 * @param EventManagerInterface $events
	 */
	public function detach(EventManagerInterface $events)
	{
		$events->detach(array($this, 'flush'));
		$events->detach(array($this, 'clear'));
	}

	/**
	 * Flushes the EntityManager's state after finishing the request
	 * @param MvcEvent $e
	 */
	public function flush(MvcEvent $e)
	{
		/** @var EntityManager $em */
		$em = $e->getApplication()->getServiceManager()->get('Doctrine\ORM\EntityManager');
		$em->flush();
	}

	/**
	 * Clears the EntityManager's state because of an occured error
	 * @param MvcEvent $e
	 */
	public function clear(MvcEvent $e)
	{
		/** @var EntityManager $em */
		$em = $e->getApplication()->getServiceManager()->get('Doctrine\ORM\EntityManager');
		$em->clear();
	}
}
