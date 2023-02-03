<?php
$options = array("Option 1", "Option 2", "Option 3");
$selected = 0;

while (true) {
  echo "\033c";

    for ($i = 0; $i < count($options); $i++) {
        if ($i == $selected) {
            echo "> ";
        } else {
            echo "  ";
        }
        echo $options[$i] . PHP_EOL;
    }
    echo "Choisissez une option avec les flèches haut et bas, puis appuyez sur Entrée." . PHP_EOL;

    $input = "";
    $inputStreams = array(STDIN);
    $outputStreams = NULL;
    $exceptStreams = NULL;
    if (stream_select($inputStreams, $outputStreams, $exceptStreams, 0)) {
        $input = ncurses(fgets(STDIN));
        echo $input;
        switch ($input) {
            case "\033[A": // Flèche haut
                if ($selected > 0) {
                    $selected--;
                }
                break;
            case "\033[B": // Flèche bas
                if ($selected < count($options) - 1) {
                    $selected++;
                }
                break;
            default:
                break 2;
        }
    }
}

echo "Vous avez choisi : " . $options[$selected] . PHP_EOL;
?>