<?php

namespace DynamicLight;


use pocketmine\block\VanillaBlocks;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\item\ItemIds;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\convert\RuntimeBlockMapping;
use pocketmine\network\mcpe\protocol\types\BlockPosition;
use pocketmine\network\mcpe\protocol\UpdateBlockPacket;
use pocketmine\player\Player;


class Listeners implements Listener
{

	public function onInteract(PlayerItemHeldEvent $event)
	{
		if ($event->getItem()->getId() !== ItemIds::TORCH) {
			$this->removeLight($event->getPlayer(), $event->getPlayer()->getPosition());
			return;
		}

		$this->spawnLight($event->getPlayer(), $event->getPlayer()->getPosition());
	}
	public function onMove(PlayerMoveEvent $event)
	{
		if ($event->getPlayer()->getInventory()->getItemInHand()->getId() !== ItemIds::TORCH) {
			return;
		}

		$this->removeLight($event->getPlayer(), $event->getFrom()->asVector3());
		$this->spawnLight($event->getPlayer(), $event->getTo()->asVector3());
	}

	private function spawnLight(Player $player, Vector3 $vec): void
	{
		$player->getNetworkSession()->sendDataPacket(UpdateBlockPacket::create(
			BlockPosition::fromVector3($vec),
			RuntimeBlockMapping::getInstance()->toRuntimeId(VanillaBlocks::TORCH()->getFullId()),
			UpdateBlockPacket::FLAG_NETWORK,
			UpdateBlockPacket::DATA_LAYER_LIQUID
		));
	}

	private function removeLight(Player $player, Vector3 $vec): void
	{
		$player->getNetworkSession()->sendDataPacket(UpdateBlockPacket::create(
			BlockPosition::fromVector3($vec),
			RuntimeBlockMapping::getInstance()->toRuntimeId(VanillaBlocks::AIR()->getFullId()),
			UpdateBlockPacket::FLAG_NETWORK,
			UpdateBlockPacket::DATA_LAYER_LIQUID
		));
	}
}