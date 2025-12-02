<?php

declare(strict_types=1);

namespace dvrkarts\MartianActions\commands;

use CortexPE\Commando\BaseCommand;
use dvrkarts\MartianActions\commands\subcommands\GiveSubCommand;
use dvrkarts\MartianActions\commands\subcommands\ListSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as C;

final class MartianActionsCommand extends BaseCommand {

    public function prepare(): void
    {
        $this->setPermission($this->getPermission());

        $this->registerSubCommand(new GiveSubCommand($this->plugin, "give", "Give an action item to a player"));
        $this->registerSubCommand(new ListSubCommand($this->plugin, "list", "List all martian action item identifiers"));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!$sender instanceof Player) {
            return;
        }

        $lines = [
            "",
            "&r&8&l[&5&lMartian&d&lActions&8&l]",
            "&r&7A modular action-item engine for PocketMine.",
            "",
            "&r&5&l» &d/ma give <id> <player> [amount] &7- Give an action item.",
            "&r&5&l» &d/ma list &7- View all item identifiers.",
            "&r&5&l» &d/ma reload &7- Reload configuration.",
            "",
            "&r&8(&7Version&8: &d" . $this->plugin->getDescription()->getVersion() . "&8)",
            ""
        ];

        $sender->sendMessage(C::colorize(implode("\n", $lines)));
    }

    public function getPermission(): string
    {
        return "martianactions.default";
    }
}