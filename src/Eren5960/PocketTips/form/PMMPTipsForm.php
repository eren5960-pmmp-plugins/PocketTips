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
use pocketmine\Player;

class PMMPTipsForm{
    use TipsTrait;

    /** @var Main  */
    private $main;

    /**
     * @param Main $main
     * @param Player $player
     * @param int $tip
     */
    public function __construct(Main $main, Player $player, int $tip){
        $this->main = $main;

        $form = new jojoe77777\FormAPI\ModalForm(function(Player $player, $out){
            if ($out !== null){
                if($out){
                    $this->main->getProvider()->sendNextTip($player);
                }else{
                    $this->main->getProvider()->setPlayerTipCount($player, -1);
                }
            }
        });

        $form->setTitle($main->getConfig()->get("form-title"));
        $form->setContent($this->replace($main->getConfig()->get("tips")[$tip], $player));
        $form->setButton1($main->getConfig()->get("form-next"));
        $form->setButton2($main->getConfig()->get("form-disable-tips"));
        $form->sendToPlayer($player);
    }
}