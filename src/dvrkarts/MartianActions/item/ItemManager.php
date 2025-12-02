<?php

declare(strict_types=1);

namespace dvrkarts\MartianActions\item;

use dvrkarts\MartianActions\Loader;
use ecstsy\MartianUtilities\utils\GeneralUtils;
use pocketmine\item\Item;

final class ItemManager {

    /** @var array<string, ItemDefinition> */
    private static array $definitions = [];

    public static function init(): void {
        $config = GeneralUtils::getConfiguration(Loader::getInstance(), "items.yml")->getAll();

        $items = $config["items"] ?? [];

        foreach($items as $key => $data){
            self::$definitions[$key] = new ItemDefinition($key, $data);
        }
    }

    public static function get(string $identifier): ?ItemDefinition {
        return self::$definitions[$identifier] ?? null;
    }

    public static function createItem(string $identifier): ?Item {
        $definition = self::$definitions[$identifier] ?? null;

        if ($definition === null){
            return null;
        }

        return ItemBuilder::build($identifier, $definition->getData());
    }

    public static function getAll(): array {
        return self::$definitions;
    }
}