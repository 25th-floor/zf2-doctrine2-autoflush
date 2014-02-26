ZF2 Doctrine2 AutoFlushListener
===============================

Installation
------------

Just attach an instance of the AutoFlushListener to the event manager like in the following code example:

	class Module
	{
		/**
		 * @param MvcEvent $e MVC Event
		 */
		public function onBootstrap(MvcEvent $e)
		{
			$eventManager = $e->getApplication()->getEventManager();
			$eventManager->attachAggregate(new AutoFlushListener());
		}
	}