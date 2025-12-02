<?php

declare(strict_types=1);

namespace dvrkarts\MartianActions\listeners;

use dvrkarts\MartianActions\action\ActionRegistry;
use dvrkarts\MartianActions\item\ItemBuilder;
use dvrkarts\MartianActions\item\ItemManager;
use dvrkarts\MartianActions\utils\PluginUtils;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerBucketEmptyEvent;
use pocketmine\event\player\PlayerBucketFillEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\utils\TextFormat as C;

final class EventListener implements Listener {

    public function onBlockPlace(BlockPlaceEvent $event): void {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $tag = $item->getNamedTag();

        if ($tag->getTag("martian:action_identifier") !== null) {
            $event->cancel();
        }
    }

    public function onPlayerItemConsume(PlayerItemConsumeEvent $event): void {
        $item = $event->getItem();
        $tag = $item->getNamedTag();

        if ($tag->getTag("martian:action_identifier") !== null) {
            $event->cancel();
        }
    }

    public function onBucketFill(PlayerBucketFillEvent $event): void {
        $item = $event->getItem();
        if ($item->getNamedTag()->getTag("martian:action_identifier") !== null) {
            $event->cancel();
        }
    }

    public function onInteract(PlayerInteractEvent $event): void {
        $item = $event->getItem();
        if ($item->getNamedTag()->getTag("martian:action_identifier") !== null) {
            $event->cancel();
        }
    }

    public function onBucketEmpty(PlayerBucketEmptyEvent $event): void {
        $item = $event->getItem();
        if ($item->getNamedTag()->getTag("martian:action_identifier") !== null) {
            $event->cancel();
        }
    }

    public function onPlayerItemUse(PlayerItemUseEvent $event): void {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $nbt = $item->getNamedTag();
        $identifier = $nbt->getString("martian:action_identifier", "");

        if ($identifier === "") {
            return; 
        }

        $definition = ItemManager::get($identifier);

        if ($definition === null) {
            $player->sendMessage(C::colorize("&c[MartianActions] Unknown item identifier: &f{$identifier}"));
            return;
        }

        $data = $definition->getData();
        $actions = $data["actions"] ?? [];

        foreach ($actions as $actionData) {
            $type = $actionData["type"] ?? null;
            if ($type === null) {
                continue;
            }

            $action = ActionRegistry::get($type);

            if ($action === null) {
                $player->sendMessage(C::colorize("&c[MartianActions] Unknown action type: &f{$type}"));
                continue;
            }

            $action->execute($player, $actionData);
        }

        if ($nbt->getByte("martian:remove_on_use", 0) === 1) {
            PluginUtils::removeOneItem($player, $item);
        }
    }
}