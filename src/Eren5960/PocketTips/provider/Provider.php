<?php
/**
 *  _____                    ____   ___    __     ___  
 * | ____| _ __  ___  _ __  | ___| / _ \  / /_   / _ \ 
 * |  _|  | '__|/ _ \| '_ \ |___ \| (_) || '_ \ | | | |
 * | |___ | |  |  __/| | | | ___) |\__, || (_) || |_| |
 * |_____||_|   \___||_| |_||____/   /_/  \___/  \___/ 
 * 
 * @author Eren5960
 * @link https://github.com/Eren5960
 */
declare(strict_types=1);

namespace Eren5960\PocketTips\provider;

use Eren5960\PocketTips\Main;
use pocketmine\Player;

abstract class Provider{
    const PROVIDER_PROPERTIES = 0;
    const PROVIDER_JSON = 1;
    const PROVIDER_YAML = 2;
    const PROVIDER_SERIALIZED = 4;

    public static $formats = [
        self::PROVIDER_JSON => "json",
        self::PROVIDER_PROPERTIES => "properties",
        self::PROVIDER_YAML => "yml",
        self::PROVIDER_SERIALIZED => "sl"
    ];

    abstract public function init(): void;

    /**
     * @param Player $player
     * @return int
     */
    abstract public function getPlayerTipCount(Player $player): int;

	/**
	 * @param Player $player
	 * @param int    $count
	 */
    abstract public function setPlayerTipCount(Player $player, int $count): void;

    /**
     * @param Player $player
     */
    abstract public function initPlayerTips(Player $player): void;

    /**
     * @param Player $player
     * @return bool
     */
    abstract public function canHandleTips(Player $player): bool;

    /**
     * @param Player $player
     */
    abstract public function sendNextTip(Player $player): void;

    /**
     * @param Main $main
     * @param int $type
     * @return Provider|null
     */
    public static function getProvider(Main $main, int $type): ?Provider{
        if($type === -1 || !in_array($type, [0, 1, 2, 4]))
            throw new \InvalidArgumentException("provider-type not nothing...");

        return new MangoProvider($main, $type); // for now
    }
}