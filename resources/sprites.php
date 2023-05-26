<?php
function getSprites($name){
  global $sprites;
  return $sprites[$name];
}
$sprites = [
//// SPRITES TITLE //////////////////////////////////////////////////////////////////////////
  'title' => 
'                            ,"\
   _.---.      ____       ,"  _\___    ___    __     
,-"      `.   |    |  /`. \,-" |   \  /   |  |    \  |`.
     __    \  "-.  | /   `. ___|    \/    |  "-.   \ |  |
\.   \ \   |    |  |/    ,,"_   )         | _  |    \|  |
  \   \/   / __ |      ,"/ / / |         ," _`.|     |  |
   \    ,-/," _`.    ,"  | \/ /|,`.     /  /   \  |     |
    \   \ /  /   |   `-. \    `   |    |   \_/ |  |\    |
     \   \   \_/ |      ` `.___ -"|\  /|\      /  | |   |
      \   \      / |`-._    `| |__| \/ | `.__,|   | |   |
       \_."`.__,|__|    `-._ |         "-.|    "-.| |   |
                            `"                      "-._|',
  'effectTitle' => 
'          xxx xxx x     ___--
          x         x   L-_- \
         _-xx        x   <  <\ \                _
         -"" xxxxxxxxx   `-   | \            ( ` )
       -"---        xxxxx--"    ||\          ) ""-
',
  'effectFireTitle' => '
    x
   xx
  x x
 x   x
 x x x
x xxx x
x x x x',
  'effectFireTitle2' =>'
     xxx
 xx xx
x   x
x   x
 x   x
 x x  x
x xxx x
x xxx x',
//// SPRITES ITEMS //////////////////////////////////////////////////////////////////////////
'Pokeball' => 
'






           ____
          /    \
         /      \
         │--()--│
         \      /
          \____/

',
'Pokeball_2' =>
'









          _
         / \
         \/ \
          \_/',
'Pokeball_3'=>
'









              _
             / \
            / \/
            \_/',
'Pokeball_1'=>
'









          ┌───┐
          │___│
          │   │
          └───┘',
'Versus' =>
'____            ____
\   \          /   /
 \   \        /   /
  \   \      /   /
   \   \   ┌─────────┐
    \   \  │         │
     \   \/│   ──────┤
      \    │         │
       \   ├──────   │
        \  │         │
         \/└─────────┘',
//// SPRITES PLACES ///////////////////////////////////////////////////////////////////////////
'Town' => 
'         ___________________
        /                   \
       /                     \
       [_____________________]
        │                   │
     ___│_________   ┌────┐ │
    /      _      \  │SHOP│ │
   /      / \      \ └────┘ │
 /       ( @ )       \______│
/         \_/         \
[_____________________]
 │                   │
 │   ┌──┐     ┌────┐ │
 │   │  │     │POKE│ │
 │   │  │     └────┘ │
 │   │  │            │',
//// SPRITES PERSONS //////////////////////////////////////////////////////////////////////////
  'trainer' => 
'        _-""""-_
       (______  \
       (  -  -"")
        | @  @  |
        (  .    )
         \_--__/
        /  V    \   _
       /|  I     \ / )
      / |  I    \ V /
      \ |  I    |\_/
       \|__I ___│
        │  /\   │
        │  │ │  │
        │  │ │  │
       /___] [___\ ',
'trainer_test' =>
'  _-""""-_
 (______  \
 (  -  -"")
  | @  @  |
  (  .    )
   \_--__/
  /  V    \   _
 /|  I     \ / )
/ |  I    \ V /
\ |  I    |\_/
 \|  I    │
  │  /\   │
  │  │ │  │
  │  │ │  │
 /___] [___\ ',
'rival' => 
'         _-.v.-/
        \_   __ /
        <\~Vv~ \//
         |~  @  /
         ( /    )
          \--__/_____^
         / \/   ______]
        /|     / 
       / |     |
      / /|___ _|
     [__]|   V │
         │ /\  │
         │ │ │ │
         │ │ │ │
        [__] [__\ ',
'trainerBack' => 
'
          ____
       _-"    "\
     _/         |
    "    _______\___
    \ __/    |  }--"
     {      _/  \"
     \_____/     }
   ___}____  ___/
  /        \- \_    __
  |         | / \  /  \
 /--_┌─┐____| |  \|-   ]
|    └─┘   /  \   |\   )
|          |  /\    \_/
 \─______-/  /  \ __/',
 'trainerBackv2'=>'
              ▄▄▀▀▀▀▄▄         
         ▄▄▀▀        █        
       ▄▀             █       
       █  ▄▄▄         ▀▀▀▄    
        █▄▄▄▄▄▄▄▄█▀█▀██▀▀     
        ██████████ █ █▀       
        ▀█████████▀   █       
         ▀██████▄▄▄▄▄▀        
    ▄▄▀▀▀▀▀▀▀▀█▄ █▀▄▄         
   █         ▀▀ █   ▄▀▄  ▄▄▄  
  █▄▄▀▀▄   █    █ ▄▀   █▀   █ 
 █   ▀▀▀▀██    █▄▄▀     █▀▄  █
 ██       █▄  █  ▀▄     █ ▄█▄▀
  ▀▀▄▄▄▄▄▄▄▄▀█  ▄▀ ▀▄▄▄█▀▀    
    █▀▀     ▀   █             ',

'healer' =>
'            _____
           /     \
         /         \
       /     (0)     \
       │     ___     │
       └─***********─┘
       **************
       ***************
       *│  (0   0)  │*
  ***  (|   "   "   |)  ***
**    ** \    *    / **    **
*      *  \__~-~__/  *      *
 *   *      |   |      *   *
  *** ┌───/-|   |-\───┐ ***
     ┌┘ ||\  / \  /|| └┐
     │__||_\/   \/_||__│
     │     _______     │
      \ \           / /
      |\ \         / /|
      | \ \       / / |
      |  \ \     / /  |',
//// SPRITES POKEMON //////////////////////////////////////////////////////////////////////////
    'Bulbizarre' => "
                                
                            
                            
                            
                            
                            
                 ░░░░░▒     
          ░░ ░░░░    ░░▒▒   
 ░░░░░░░░░░░░░░░▒▒   ░░░░▒  
 ░░░░░░░░░░░░░░░▒▒░░░░░▒░░▓ 
 ░░▒░░░░░▒▓▓ ▒▒░░▒░▒▓▒▒▒▒▒  
▒░░░░░░░░░░░░░▒░▒▒░▒▒▒▒▒▒   
  ░░▒▒▒▒▒▒▒▒▒▒░░░░▒▒▒▒▒▒▒▒  
  ░▒░░▒▒▒░░░░▒░░░░░▓▒░░░░▓░ 
 ░░ ▒▒    ░▓▓▓▒▓░░▒░░▒▒▓▒   ",
    'Pikachu' => 
'   
      ,___          .-;
      `"-.`\_...._/`.`
          \        /
   .----, / ()   ()\
   `\   \| 0    .  0|
    /^^^/\      ^  /
   /   / /     __  |
   \_  \   \       \
     \>    \_)     \_)
      `--    ,    /
        \    /\  <
         ". <`"-,_)
           "._)',
    'Rattata' =>
'



         /\  /\
        /^ \/ ^\
       (  \  /  )
       (  0  0  )
        \      /
         \ "" /
          \vv/
           


',
    'Rattatac' => 
'



         /\  /\
        /^ \/ ^\
      (   \  /   )
      (   0  0   )
      -_\      /_-
       _-\ "" /-_
          \vv/
           ^^


',
'ball'=>
'




        xxxxxxxx
      xx        xx
     x  /\        x
    x   \/         x
    x              x
    xxx          xxx
    x  xxxxxxxxxx  x
     x            x
      xx        xx
        xxxxxxxx',
'standard' => 
'  ________"""""_______
  \   MM        MM   /
   \  "          "  /
    |   MM ,,, MM   |
    |   MMM,,,MMM   |
    |----_______----|
     \             /
 /---_\-\_______/-/_---\
 |                     |
 \---^│  _______  │^---/
      │ /       \ │
      |/         \|
     / \_________/ \
     |    _____    |
     \___/     \___/',
'Bug'=>
'
        ──    ──
          │  │
          ├──┤
        ──┘  └──
       [@@]  [@@]
    ┌──[@@]  [@@]──┐
  ──┘   ==    ==   └──
       │|─┐xx┌─|│
     ──┤||└──┘||├──
       ├┐||||||┌┤
       └┼──────┼┘
      ┼ │||||||│ ┼
     │   ──||──   │
     │     ──     │',
'thumbnail' =>
'           ______
        /──┐    ┌──\
       <|||└────┘|||>
       /\-||    ||-/\
      │  │        │  │
      │  │ ┌─  ─┐ │  │
      │  │ │@  @│ │  │
      │  │        │  │
      │  \│  /\  │/  │
      │   │  \/  │   │
      └┐  \──  ──/  ┌┘
       │   _\──/_   │
       │  │      │  │
       │xx│      │xx│
       \__/      \__/',
'Grass'=> 
'          ____
        ┌─    ─┐
      ┌─┘      └─┐
     ┌┘  \    /  └┐
     │ ┌──\  /──┐ │
     │ │  xxxx  │ │
     │ └─@ xx @─┘ │
     └┐          ┌┘
      └─┐      ┌─┘
        │------│
   ┌──-__\    /__-──┐
  <│    \  xx  /    │>
   └┐    \ xx /    ┌┘
    └─--\______/--─┘
        __|  |__',
'Wazo' => 
'  {\                /}
  / \              / \
  "  \            / "\
  "   \  ^^^^,   /   \
   ",  \/ " " \ / "  "\
     " |@  @   /      \
      ^<-     / "   "\
        "" " "/^"^"^\
       /      │ " "
       │ "  " │
       │  "   /\
       \     /  \
       /^^\ /    \
      W    | "^"^"
           W',
'Wazo legendary' => 
'  {\         ****   /}
  / \    ****  *   / \
 /   \  **    **  /   \
/ [   \ *^^^^,*  /   ] \
|   [  \/     \ /  ]    |
| [    |/  @   /     ]  |
\   [  /-     /    ]    /
 "    ^ "" " "/^       /
  "^"^ /      | "^"^"^"
       | "  " |
       |  "   |
       \_____/
      //     |\
     /W      W \
     ^v^v^v^v^v^',
    'Cat' => 
'  



( \
\ \
/ /             |\\
/ /    .-`````-. / ^ -.
\ \   /         / _{|} `o
\ \  /   .---.   _\ ,--"
\ \/   /     \,   ^^^
\   \/\      (\   )
 \   ) \     ) \  \
  /  ) /__  /_  )( \
 (___)))__))(__))(__)))',
//// SPRITES TESTS //////////////////////////////////////////////////////////////////////////

    // les limites de 'zone' sont compris dans le sprite
    'Zone' => 
'████████████████████████████
████████████████████████████
████████████████████████████
████████████████████████████
██████████████░█████████████
█████████████░█░████████████
██████████████░█████████████
████████████████████████████
████████████████████████████
████████████████████████████
████████████████████████████
████████████████████████████
████████████████████████████
████████████████████████████
████████████████████████████',
    'ZoneHorsLimite' =>
'┌─────────────────────────┐
│                         │
│                         │
│                         │
│                         │
│                         │
│                         │
│                         │
│                         │
│                         │
│                         │
│                         │
│                         │
│                         │
│                         │
│                         │
└─────────────────────────┘',
    'Charizard' =>
'                        ___--
                        L-_- \
         _--             <  <\ \                _
         -""             `-   | \            ( ` )
       -"---            _--"    ||\          ) ""-
       --" \ \         -"---`--_-" 1|        -  _-_`-
      -"/   \ \       `" " `--/   | \       / /   --\"
    -" /     \ -        |\__ - _ -"` `     / /       \"
    | "       --\        `-----"  | `-"   / /        \\
    | /        |L__          |    |      / /         "|
   - /         -   -         |    |    _/ /          |\
 / -        \"`_/- `-_ \_--""       `-" _-           |\
-  "       --     -"   `                              \\
" /        `-"    |     -"             "--             `|
|"      _-"` `-    \ _-"               "   \  `-""`-- -\|\
||    -"     `- `-___"       _-----_    \   \`  |    `/ "|
||  -"         `- ;------" -"       `-   `-  `-"  --"  "||
\| "             V      / /          `-  | `-__-"      |/
 |          -" --   -" | /             \  --          "
           -"    `"-"    |              |    `-
          /      /-      |              |      \
        -`-    |         `-            /        |
          \ `---\   _     -"--       -"         /
           `--__ `-  `"   -  _->----""-  _  __  /
                -"        /""          |  ""   "_
               /_|--"\ -"-             "-"`__"-( \
                 / -"""\-"               `/  `--|"'
];
?>