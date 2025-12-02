<?php

declare(strict_types=1);

namespace dvrkarts\MartianActions\action;

final class ActionRegistry {

    /** @var array<string, Action> */
    private static array $actions = [];

    public static function register(string $identifier, Action $action): void {
        self::$actions[$identifier] = $action;
    }

    public static function get(string $identifier): ?Action {
        return self::$actions[$identifier] ?? null;
    }
}