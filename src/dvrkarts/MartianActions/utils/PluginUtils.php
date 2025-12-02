<?php

declare(strict_types=1);

namespace dvrkarts\MartianActions\utils;

use dvrkarts\MartianActions\action\ActionRegistry;
use dvrkarts\MartianActions\action\types\GiveItemsAction;
use dvrkarts\MartianActions\action\types\MessageAction;
use dvrkarts\MartianActions\action\types\PlayEffectAction;
use dvrkarts\MartianActions\action\types\RunCommandAction;
use dvrkarts\MartianActions\commands\MartianActionsCommand;
use dvrkarts\MartianActions\item\ItemManager;
use dvrkarts\MartianActions\listeners\EventListener;
use dvrkarts\MartianActions\Loader;
use JackMD\ConfigUpdater\ConfigUpdater;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;

final class PluginUtils
{
    public static function init(): void {
        ActionRegistry::register("run_commands", new RunCommandAction());
        ActionRegistry::register("play_effect", new PlayEffectAction());
        ActionRegistry::register("message", new MessageAction());
        ActionRegistry::register("give_items", new GiveItemsAction());

        $loader = Loader::getInstance();

        $loader->saveDefaultConfig();

        ConfigUpdater::checkUpdate($loader, $loader->getConfig(), "version", 1);
        $loader->saveResource("items.yml");

        $listeners = [new EventListener()];

        foreach ($listeners as $listener) {
            $loader->getServer()->getPluginManager()->registerEvents($listener, $loader);
        }

        $loader->getServer()->getCommandMap()->registerAll("martianactions", [
            new MartianActionsCommand($loader, "martionactions", "Manage Martian Actions", ["ma"]),
        ]);

        ItemManager::init();
    }

    public static function removeOneItem($player, Item $item): void {
        $inv = $player->getInventory();
        $slot = $inv->getHeldItemIndex();

        $current = $inv->getItem($slot);
        $current->setCount($current->getCount() - 1);

        if ($current->getCount() <= 0) {
            $inv->setItem($slot, VanillaItems::AIR()); 
        } else {
            $inv->setItem($slot, $current);
        }
    }
}