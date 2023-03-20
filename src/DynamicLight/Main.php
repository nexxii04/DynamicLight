<?php

namespace DynamicLight;

use pocketmine\plugin\PluginBase;

final class Main extends PluginBase
{
	public function onEnable() : void
	{
		$this->getServer()->getPluginManager()->registerEvents(new Listeners(), $this);
	}
}