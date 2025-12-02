<?php

declare(strict_types=1);

namespace dvrkarts\MartianActions;

use dvrkarts\MartianActions\utils\PluginUtils;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

final class Loader extends PluginBase {
    use SingletonTrait;

    public function onLoad(): void
    {
        self::setInstance($this);
    }

    public function onEnable(): void
    {
        PluginUtils::init();
    }
}