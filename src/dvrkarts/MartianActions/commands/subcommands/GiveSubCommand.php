<?php

declare(strict_types=1);

namespace dvrkarts\MartianActions\commands\subcommands;

use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use dvrkarts\MartianActions\item\ItemManager;
use ecstsy\MartianUtilities\utils\PlayerUtils;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as C;

final class GiveSubCommand extends BaseSubCommand
{
    public function prepare(): void
    {
        $this->setPermission($this->getPermission());

        $this->registerArgument(0, new RawStringArgument("identifier", false));
        $this->registerArgument(1, new RawStringArgument("name", false));
        $this->registerArgument(2, new IntegerArgument("amount", true));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!$sender instanceof Player) {
            return;
        }

        $identifier = $args["identifier"];
        $targetName = $args["name"];
        $amount = $args["amount"] ?? 1;

        $target = PlayerUtils::getPlayerByPrefix($targetName);
        if (!$target instanceof Player) {
            $sender->sendMessage(C::colorize("&r&cPlayer &f{$targetName} &cnot found."));
            return;
        }

        $item = ItemManager::createItem($identifier);
        if ($item === null) {
            $sender->sendMessage(C::colorize("&r&cUnknown item identifier: &f{$identifier}"));
            return;
        }

        $item->setCount((int)$amount);
        $target->getInventory()->addItem($item);

        $lines = [
            "&r&8[&5Martian&dActions&8]",
            "&r&7Gave &d{$amount}x &f{$identifier} &7to &d{$target->getName()}&7.",
        ];

        $sender->sendMessage(C::colorize(implode("\n", $lines)));
    }

    public function getPermission(): string
    {
        return "martianactions.give";
    }
}