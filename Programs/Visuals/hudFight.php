<?php

class Display_Fight{
    //// CREATE HUD INGAME //////////////////////////

    static function drawGameHUD($pkmnTeamJoueur, $pkmnTeamEnemy){
        Display::clearGameScreen();
        Display_Game::drawSkeletonHUD();

        // Afficher HUD du pkmn joueur
        Display_Fight::drawPkmnAllBattleHUD($pkmnTeamJoueur, true);
        
        // Afficher HUD du pkmn ennemi
        Display_Fight::drawPkmnAllBattleHUD($pkmnTeamEnemy, false);
    }


    //// draw INFO PKMN ///////////////////////////////////////////
    static function drawPkmnAllBattleHUD(&$pkmnTeam, $isJoueur){  
        Display_Fight::drawPkmnInfoHUD(Parameters::getPosHealthPkmn($isJoueur), $pkmnTeam[0], $isJoueur);
        Display::drawSprite(getSprites($pkmnTeam[0]['Sprite'], $isJoueur), Parameters::getPosSpritePkmn($isJoueur));
        Display_Fight::drawInfoTeamCount($pkmnTeam,Parameters::getPosTeam($isJoueur));
    }

    static function drawInfoTeamCount($pkmnTeam, $pos){
        $message = '<';
        for($i = 0; $i < 6; $i++){
            if($i < count($pkmnTeam)){
                if($pkmnTeam[$i]['Stats']['Health'] > 0){
                    $message .= '0';
                }else{
                    $message .= 'X';
                }
            }else{
                $message .= '-';
            }
        }
        $message .= '>';
        Display::textArea($message, $pos);
    }



    static function clearPkmnHUD($isJoueur){
        Display::clearArea(Parameters::getScaleHUDPkmn(),Parameters::getPosHealthPkmn($isJoueur));
    }

    static function drawPkmnInfoHUD($pos, $pkmn, $isJoueur = true){
        Display::clearArea(Parameters::getScaleHUDPkmn(),$pos);
        Display::drawBox(Parameters::getScaleHUDPkmn(),$pos,'|','-', true);

        Display::textArea(ucfirst($pkmn['Name']), [$pos[0]+1, $pos[1]+2]);
        $displayLevel = $pkmn['Status'] == null ? "Lv".$pkmn['Level'] : status($pkmn['Status']);
        Display::textArea($displayLevel, [$pos[0]+1, $pos[1]+19]);
        Display::textArea('<          >', [$pos[0]+2, $pos[1]+10]);

        Display_Fight::updateHealthPkmn($pkmn['Stats']['Health'],$pkmn['Stats']['Health Max'], $isJoueur, $pos);
        if($isJoueur){
            Display_Fight::updateExpPkmn($pos,$pkmn['exp'], $pkmn['expToLevel']);
        }
        // if(!$isJoueur){
        //     // draw info if caught or not
        // }
    } 

    static function updateHealthPkmn($health, $healthMax, $isJoueur = true, $pos=null){
        $pourcentage = $health/$healthMax;
        if(is_null($pos)){
            $pos = Parameters::getPosHealthPkmn($isJoueur);
        }
        //Set health text
        Display::clearArea([1,7],[$pos[0]+2,$pos[1]+2]); //clear pour eviter 
        if($isJoueur){
            Display::textArea($health.'/'.$healthMax,[$pos[0]+2,$pos[1]+2] );
        }
        
        //Set health graphic style + color
        Cursor::moveCursor([$pos[0]+2,$pos[1]+11]);
        
        
        if($pourcentage > 0.5){
            Display::setColor('green');
        }elseif($pourcentage < 0.2){
            Display::setColor('red');
        }
        else{
            Display::setColor('orange');
        }
        for($i=0;$i<10;++$i){
            if (($pourcentage*10) > $i){
                echo '=';
            } else {
                echo ' ';
            }
        }
        Display::setColor('reset');
    }

    static function updateExpPkmn($pos,$exp, $expMax){
        $pourcentage = $exp/$expMax;

        //Set exp text
        Display::clearArea([1,7],[$pos[0]+3,$pos[1]+3]); //clear pour eviter 
        Display::textArea('<          >', [$pos[0]+3, $pos[1]+10]);

        //Set health graphic style + color
        Cursor::moveCursor([$pos[0]+3,$pos[1]+11]);
        Display_Game::setColorByType('exp');
        for($i=0;$i<10;++$i){
            if (($pourcentage*10) > $i){
                echo '=';
            } else {
                echo ' ';
            }
        }
        Display::setColor('reset');
    }

    static function levelUpWindow($oldStats, $newStats){
        Display::drawBox([10,20], [7,39]);
        $pos = [7,39];

        $keys = array_keys($oldStats);

        $differences = [];
        for($i=0;$i<count($newStats);++$i){
            array_push($differences, $newStats[$keys[$i]]-$oldStats[$keys[$i]]);
        }

        Display_Fight::displayStats($oldStats, $pos);

        // sleep(2);
        waitForInput();
        for($i=0;$i<count($newStats);++$i){
            $phrase_alignee = str_pad($differences[$i].'->', 4, " ", STR_PAD_LEFT);
            Display::textArea($phrase_alignee, [$pos[0]+$i+1,$pos[1]+10]);
        }
        waitForInput();
        $i = 1;
        Display::clearArea([6,6], [$pos[0]+1,$pos[1]+10]);
        Display_Fight::displayStats($newStats, $pos);

        waitForInput();
        Display::clearArea([10,20], [7,39]);
    }
    
    static function displayStats($stats, $pos){
        $i = 1;
        foreach($stats as $key=>$stat){
            Display::textArea($key, [$pos[0]+$i,$pos[1]+2]);
            $phrase_alignee = str_pad($stat, 3, " ", STR_PAD_LEFT);
            Display::textArea($phrase_alignee, [$pos[0]+$i,$pos[1]+15]);
            ++$i;
        }
    }

    //// draw MENU ///////////////////////////////////

    static function drawPkmnTeam($pkmnTeam){
        Display::clearGameScreen();
        
        for($i=0;$i<count($pkmnTeam);++$i){
            $x = ($i % 2 == 0) ? 3 : 33;
            $y = ($i+1) * 3;
            $pos = [$y,$x];
            Display_Fight::drawPkmnInfoHUD($pos, $pkmnTeam[$i]);
        }
    }

    // MENU INTERFACE CHOICE PLAYER
    static function interfaceCapacities($capacites){
        $posYInit = 25;
        $posXInit = 5;
        for($i=0;$i<4;++$i){
            if(isset($capacites[$i]['Name']))
            {
                $posY = $posYInit;
                $posX = $posXInit;
                if ($i == 1) {
                    $posX = $posXInit + 20;
                }elseif ($i == 2) {
                    $posY = $posY + 3;
                }elseif ($i == 3) {
                    $posY = $posYInit +3;
                    $posX = $posXInit +20;
                }
                Display::textAreaLimited(($i+1).' : ',23,[$posY,$posX]);
                Display_Game::setColorByType($capacites[$i]['Type']);
                Display::textAreaLimited($capacites[$i]['Name'],23,[$posY,$posX+4]);
                Display::setColor('reset');
                Display::textAreaLimited('PP : '.$capacites[$i]['PP'].'/'.$capacites[$i]['PP Max'],23,[$posY+1,$posX]);
            }
        }
    }

    static function interfaceMenu(){
        $screenScale = Parameters::getScreenScale();
        $posYInit = $screenScale[0] - 6;
        $posXInit = $screenScale[1] - 14;
        $posY = $screenScale[0] - 5;
        $posX = $screenScale[1] - 12;
        Display::drawBox([7,15],[$posYInit,$posXInit]); // cadre des choix

        Display::textArea( '1 : ATTACK', [$posY,$posX]);
        Display::textArea('2 : PKMN', [$posY+1,$posX]);
        Display::textArea('3 : BAG', [$posY+2,$posX]);
    }
}

?>