<?php

declare(strict_types=1);

namespace kim\present\lifetime\listener;

use kim\present\lifetime\Lifetime;
use pocketmine\entity\Entity;
use pocketmine\entity\object\ItemEntity;
use pocketmine\entity\projectile\Arrow;
use pocketmine\event\entity\EntitySpawnEvent;
use pocketmine\event\Listener;

class EntityEventListener implements Listener{

	/** @var Lifetime */
	private $owner = null;

	/** @var \ReflectionProperty */
	private $property = null;

	public function __construct(Lifetime $owner){
		$this->owner = $owner;

		$reflection = new \ReflectionClass(Entity::class);
		$this->property = $reflection->getProperty('age');
		$this->property->setAccessible(true);
	}

	/** @param EntitySpawnEvent $event */
	public function onEntitySpawnEvent(EntitySpawnEvent $event){
		$entity = $event->getEntity();
		if($entity instanceof ItemEntity){
			$this->property->setValue($entity, (int) (6000 - ((float) $this->owner->getConfig()->get('item-lifetime')) * 20));
		}elseif($entity instanceof Arrow){
			$this->property->setValue($entity, (int) (1200 - ((float) $this->owner->getConfig()->get('arrow-lifetime')) * 20));
		}
	}
}