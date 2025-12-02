<?php

declare(strict_types=1);

namespace dvrkarts\MartianActions\action\types;

use dvrkarts\MartianActions\action\Action;
use ecstsy\MartianUtilities\utils\ItemUtils;
use pocketmine\player\Player;

final class GiveItemsAction implements Action {

    public function execute(Player $player, array $data): void
    {
        if (!isset($data["items"]) || !is_array($data["items"])) {
            return;
        }

        $items = ItemUtils::setupItems($data["items"], $player);

        foreach ($items as $rewardItem) {
            $player->getInventory()->addItem($rewardItem);
        }
    }
}
