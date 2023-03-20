<?php

namespace DynamicLight;

use pocketmine\block\VanillaBlocks;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\convert\RuntimeBlockMapping;
use pocketmine\network\mcpe\protocol\types\BlockPosition;
use pocketmine\network\mcpe\protocol\UpdateBlockSyncedPacket;
use pocketmine\plugin\PluginBase;

final class Main extends PluginBase
{
	public function onEnable() : void
	{
		$this->getServer()->getPluginManager()->registerEvents(new Listeners(), $this);
	}
}