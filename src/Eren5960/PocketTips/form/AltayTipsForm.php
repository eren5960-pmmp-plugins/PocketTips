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

namespace Eren5960\PocketTips\form;

use Eren5960\PocketTips\Main;
use pocketmine\form\Form;
use pocketmine\form\ModalForm;
use pocketmine\Player;

class AltayTipsForm extends ModalForm{
    use TipsTrait;

    /** @var Main */
    private $main;

    /**
     * @param Main $main
     * @param Player $player
     * @param int $tip
     */
    public function __construct(Main $main, Player $player, int $tip){
        $this->main = $main;
        $config = $main->getConfig();

        parent::__construct(
            (string) $config->get("form-title"),
            (string) $this->replace($main->getConfig()->get("tips")[$tip], $player),
            (string) $config->get("form-next"),
            (string) $config->get("form-disable-tips")
        );
    }

    /**
     * @param Player $player
     * @return Form|null
     */
    public function onSubmit(Player $player): ?Form{
        if($this->getChoice()){
            $this->main->getProvider()->sendNextTip($player);
        }else{
            $this->main->getProvider()->setPlayerTipCount($player, -1);
        }

        return null;
    }
}