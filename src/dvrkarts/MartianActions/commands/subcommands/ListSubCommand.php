<?php

declare(strict_types=1);

namespace dvrkarts\MartianActions\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use dvrkarts\MartianActions\Loader;
use ecstsy\MartianUtilities\utils\GeneralUtils;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as C;

final class ListSubCommand extends BaseSubCommand {

    public function prepare(): void
    {
        $this->setPermission($this->getPermission());
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return;
        }

        $config = GeneralUtils::getConfiguration(Loader::getInstance(), "items.yml")->getAll();
        $items = $config["items"] ?? [];

        if (empty($items)) {
            $sender->sendMessage(C::colorize("&cNo items defined in items.yml."));
            return;
        }

        $lines = [
            "",
            "&8&l[&5&lMartian&d&lActions&8&l] &7Available Items",
            "&7Total: &d" . count($items),
            ""
        ];

        foreach ($items as $identifier => $data) {
            $displayName = $data["name"] ?? "&7(no name)";

            $lines[] = "&5● &d{$identifier} &7→ &f" . $displayName;
        }

        $lines[] = "";

        $sender->sendMessage(C::colorize(implode("\n", $lines)));
    }

    public function getPermission(): string
    {
        return "martianactions.list";
    }
}