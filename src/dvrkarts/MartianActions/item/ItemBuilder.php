<?php

declare(strict_types=1);

namespace dvrkarts\MartianActions\item;

use pocketmine\item\Item;
use pocketmine\item\StringToItemParser;
use pocketmine\utils\TextFormat;

final class ItemBuilder {

    public static function build(string $identifier, array $data): ?Item
    {
        $material = $data["material"] ?? null;
        if($material === null){
            return null;
        }

        $item = StringToItemParser::getInstance()->parse($material);
        if($item === null){
            return null;
        }

        if(isset($data["name"])){
            $item->setCustomName(TextFormat::colorize($data["name"]));
        }

        if(isset($data["lore"])){
            $formattedLore = [];
            foreach($data["lore"] as $line){
                $formattedLore[] = TextFormat::colorize($line);
            }
            $item->setLore($formattedLore);
        }

        $item->setCount($data["amount"] ?? 1);

        $nbt = $item->getNamedTag();
        $nbt->setString("martian:action_identifier", $identifier);

        if(isset($data["remove-on-use"]) && $data["remove-on-use"] === true){
            $nbt->setByte("martian:remove_on_use", 1);
        }

        return $item;
    }
}