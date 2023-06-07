<?php 
class Animations{
    static function translate($sprite, $posInit, $posFinal, $time=1, $laps=0.01){
        $distance = array_map(function($a, $b) { 
            return $a - $b; 
        }, $posFinal, $posInit);
        $countToExecuteAnimation = intval($time/$laps);
    
        $moveXPerLaps = $distance[1]/ $countToExecuteAnimation;
        $moveYPerLaps = $distance[0]/ $countToExecuteAnimation;;
    
        $posY = $posInit[0];
        $posX = $posInit[1];
        for($i=0;$i<$countToExecuteAnimation; ++$i){
            $posX += $moveXPerLaps;
            $posY += $moveYPerLaps;
            // CustomFunctions::debugLog("x:$posX y:$posY \n", 0);
            // Display::textArea("x:$posX y:$posY \n",[0,0]);
            Display::drawSprite($sprite, [$posY,$posX]);
            usleep($laps*1000);
            if($i != $countToExecuteAnimation-1){
                Display::clearArea(CustomFunctions::countLinesAndColumns($sprite),[$posY,$posX]);
            }
        }
    }
    
    static function pkmnAppearinBattle($isJoueur, $pkmn /*, $animPkBall = false*/){
        Display_Game::clearSpritePkmn($isJoueur);
        Display::drawSprite(getSprites('Pokeball_1'), Parameters::getPosSpritePkmn($isJoueur));
        usleep(500000);
        Display_Game::clearSpritePkmn($isJoueur, 1);
        Display_Game::drawSpritePkmn($pkmn, $isJoueur);
    }
    
    static function drawEntirePkmnBattle($pkmnTeam, $isJoueur){
        Display_Fight::drawInfoTeamCount($pkmnTeam, Parameters::getPosTeam($isJoueur));
        Display_Fight::drawPkmnInfoHUD(Parameters::getPosHealthPkmn($isJoueur), $pkmnTeam[0]);
    }
    
    static function animationCapture(){
        Display_Game::clearSpritePkmn(false,500000);
        Display::drawSprite(getSprites('Pokeball_1'),Parameters::getPosSpritePkmn(false));
        Display_Game::clearSpritePkmn(false,500000);
        Display::drawSprite(getSprites('Pokeball_2'),Parameters::getPosSpritePkmn(false));
        Display_Game::clearSpritePkmn(false,500000);
        Display::drawSprite(getSprites('Pokeball_1'),Parameters::getPosSpritePkmn(false));
        Display_Game::clearSpritePkmn(false,500000);
        Display::drawSprite(getSprites('Pokeball_3'),Parameters::getPosSpritePkmn(false));
        Display_Game::clearSpritePkmn(false,500000);
        Display::drawSprite(getSprites('Pokeball_1'),Parameters::getPosSpritePkmn(false));
    }
    
    //// ANIMATION ENTER BATTLE /////////////////////////////////////////////
    static function enterBattle(){
        Animations::enterSpirale();
    }
    
    static function enterRowByRow(){
        for($i=0;$i<6;++$i){
            for($y=0;$y<6;++$y){
                Display::drawFullBox([5,10],[1+$i*5,1+$y*10],['█','█','█']);
                usleep(50000);
            }
        } 
    }
    
    static function enterSpirale(){
        $screenScale = Parameters::getScreenScale();
        // Configuration de la taille du terminal
        $terminalHeight = $screenScale[0];
        $terminalWidth = $screenScale[1];
    
        // Position initiale de la boîte
        $boxHeight = 5;
        $boxWidth = 10;
    
        // Boucle pour afficher la spirale
        for ($i = 0; $i < 3; ++$i) {
            // Mouvement vers la droite
            for ($y = 0; $y < ($terminalWidth/$boxWidth)-$i; ++$y) {
                Display::drawFullBox([$boxHeight, $boxWidth], [$boxHeight*$i, $y*$boxWidth]);
                usleep(25000);
                $lastPos = [$boxHeight*$i, $y*$boxWidth];
            }
    
            // Mouvement vers le bas
            for ($y = 0; $y < ($terminalHeight/$boxHeight)-$i; ++$y) {
                Display::drawFullBox([$boxHeight, $boxWidth], [$boxHeight*$y, $terminalWidth-($i+1)*$boxWidth]);
                usleep(25000);
            }
    
            // Mouvement vers la gauche
            for ($y = 0; $y < ($terminalWidth/$boxWidth)-$i; ++$y) {
                Display::drawFullBox([$boxHeight, $boxWidth], [$terminalHeight-($i+1)*$boxHeight, $terminalWidth-$boxWidth*($y+1)]);
                usleep(25000);
            }
    
            // Mouvement vers le haut
            for ($y = 0; $y < ($terminalHeight/$boxHeight)-$i; ++$y) {
                Display::drawFullBox([$boxHeight, $boxWidth], [$terminalHeight-$boxHeight*($y+1), $i*$boxWidth]);
                usleep(25000);
            }
        }
    }
    
    static function versusLeader($spriteName){
        Display::clearGameScreen();
        Display_Game::drawGameCadre();
        if(is_null($spriteName)){
            $sprite = getSprites('trainer');
        }else{
            $sprite = getSprites($spriteName);
        }
    
        $screenScale = Parameters::getScreenScale();
        $posY = 8;
        Display::drawBox([2,$screenScale[1]-2],[$screenScale[0]-6,2], '|','-',true,['-','-','-','-']);
        Display::drawBox([2,$screenScale[1]-2],[$screenScale[0]-23,2], '|','-',true,['-','-','-','-']);
    
        $scaleSprite = CustomFunctions::countLinesAndColumns($sprite);
        $scaleSpriteVersus = CustomFunctions::countLinesAndColumns(getSprites('Versus'));
    
        $posInit = [$posY+1, $screenScale[1]-$scaleSprite[1]];
        $posFinal = [$posY+1, $scaleSpriteVersus[1]/2+5]; // Weird stuff
    
        Display::drawSprite(getSprites('Versus'),[$posY+3,3]);
        Display::setColor('reset');
        Animations::translate($sprite, $posInit, $posFinal, 2);
    
        // TRANSITION TO GREY
        Display::setColor('grey');
        Display::drawBox([2,$screenScale[1]-2],[$screenScale[0]-6,2], '|','-',true,['-','-','-','-']);
        Display::drawBox([2,$screenScale[1]-2],[$screenScale[0]-23,2], '|','-',true,['-','-','-','-']);
        Display::drawSprite($sprite,$posFinal);
        Display::drawSprite(getSprites('Versus'),[$posY+3,3]);
        Display::setColor('reset');
        sleep(1);
        Display::clearArea([$screenScale[0]-2,$screenScale[1]-2],[2,2]);
        
        sleep(1);
    }
    
    
    //// ANIAMTIONS BATTLE //////////////////////////////////////////////////
    
    static function charactersenterBattle($spriteJoueur, $spriteEnemy){
        $screenScale = Parameters::getScreenScale();
        $posJoueur = Parameters::getPosSpritePkmn(true);
        $posEnemy = Parameters::getPosSpritePkmn(false);
    
        // Set animation enemy if exist
        $isArray = is_array($spriteEnemy);
        // CustomFunctions::debugLog(getSprites($spriteEnemy[0]));
        $spritetranslateEnemyStart = $isArray ? getSprites($spriteEnemy[0]) : getSprites($spriteEnemy);
        $spritetranslateEnemyEnd = $isArray ? getSprites($spriteEnemy[count($spriteEnemy)-1]) : getSprites($spriteEnemy);
    
        $distance = $screenScale[1]-1-Parameters::getScaleSpritePkmn()[1];
    
        for($i=0;$i<$distance;++$i){
            Display::drawSprite($spritetranslateEnemyStart, [$posEnemy[0], 2+$i]);
            Display::drawSprite($spriteJoueur, [$posJoueur[0], $screenScale[1]-$i-Parameters::getScaleSpritePkmn()[1]]);
            usleep(1000);
            Display_Game::clearGameplayScreen();
        }
    
        if($isArray){
            $y = 0;
            for($i=0;$i<count($spriteEnemy);++$i){
                Display_Game::clearSpritePkmn(false);
                Display::drawSprite(getSprites($spriteEnemy[$y]),Parameters::getPosSpritePkmn(false));
                ++$y;
                if ($y >= count($spriteEnemy)) {
                    $y = 0;
                }
                usleep(250000);
            }
        }
        Display::drawSprite($spriteJoueur, Parameters::getPosSpritePkmn(true));
        Display::drawSprite($spritetranslateEnemyEnd, Parameters::getPosSpritePkmn(false));
    }
    
    static function attack($pkmn, $isJoueur){
        $pos = Parameters::getPosSpritePkmn($isJoueur);
        $decalage = $isJoueur ? 1 : -1;
    
        Display_Game::clearSpritePkmn($isJoueur);
        Display::drawSprite(getSprites($pkmn['Sprite']),[$pos[0],$pos[1]+$decalage]);
        usleep(150000);
        Display::clearSprite([$pos[0]-1,$pos[1]+$decalage]);
        Display_Game::drawSpritePkmn($pkmn, $isJoueur);
    }
    
    static function attackDown($pkmn, $isJoueur){
        $pos = Parameters::getPosSpritePkmn($isJoueur);
        $scaleSprite = Parameters::getScaleSpritePkmn();
        for($i=0;$i<3;++$i){
            Display_Game::clearSpritePkmn($isJoueur);
            Display::drawSprite(getSprites($pkmn['Sprite']),$pos);
    
            Display::setColor('red');
            Display::drawSprite(getSprites('down'), [$pos[0]+($i+1)*2+intval($scaleSprite[0]/4),$pos[1]+intval($scaleSprite[1]/2)-6]);
            Display::setColor('reset');
            usleep(150000);
        }
        Display_Game::clearSpritePkmn($isJoueur);
        Display::drawSprite(getSprites($pkmn['Sprite']),$pos);
    }
    
    static function attackUp($pkmn, $isJoueur){
        $pos = Parameters::getPosSpritePkmn($isJoueur);
        $scaleSprite = Parameters::getScaleSpritePkmn();
        for($i=0;$i<3;++$i){
            Display_Game::clearSpritePkmn($isJoueur);
            Display::drawSprite(getSprites($pkmn['Sprite']),$pos);
    
            Display::setColor('green');
            Display::drawSprite(getSprites('up'), [$pos[0]+$scaleSprite[0]-($i+1)*2-intval($scaleSprite[0]/4),$pos[1]+intval($scaleSprite[1]/2)-6]);
            Display::setColor('reset');
            usleep(150000);
        }
        Display_Game::clearSpritePkmn($isJoueur);
        Display::drawSprite(getSprites($pkmn['Sprite']),$pos);
    }
    
    static function takeDamage($pkmn, $isJoueur){
        usleep(250000);
        Display_Game::clearSpritePkmn($isJoueur);
        usleep(250000);
        Display_Game::drawSpritePkmn($pkmn, $isJoueur);
        usleep(250000);
        Display_Game::clearSpritePkmn($isJoueur);
        usleep(250000);
        Display_Game::drawSpritePkmn($pkmn, $isJoueur);
        usleep(250000);
    }
}

?>