<?php



function getWords($number_of_letters)
{
    $wordsFound = [];
    $file = fopen("words.txt", "rb");

    while ($word = fgets($file))
    {
        if(strlen(trim($word))==$number_of_letters)
            $wordsFound[] = trim($word);
    }
    fclose($file);
    return $wordsFound;
}

function replaceAll($guessString, $guessWord, $thisLetter){
    foreach(array_keys($guessWord,$thisLetter) as $index){
        $guessString[$index] = $thisLetter;
    }
    return $guessString;
}
const LIVES = 6;
$lives = LIVES;
$alphabet_left = array(25);


$number_of_letters = readline("Enter the word length: ");
$words = getWords($number_of_letters);
printf ("There are %s words with %s letters\n", count($words),
    $number_of_letters);
$guessWord = str_split($words[rand(0, count($words)-1)]);
printf ("Guessing the word: %s\n", implode("",$guessWord));
$guessString = array_fill(0, $number_of_letters, "_");

while($lives > 0){
    $thisLetter = readline("Guess a letter: ");
    alphabetLeft($alphabet_left, $thisLetter);
    if (in_array($thisLetter,$guessWord)){
        $guessString = replaceAll($guessString, $guessWord,
            $thisLetter);
        if (implode($guessString) == implode($guessWord)){
            printf("You guessed the word!\n");
            break;
        }
    } else {
        $lives = $lives-1;
        printf("Letter not found. Lives remaining %s \n", $lives);
    }
    print(implode($guessString) . " \n");
}
if ($lives > 0) {
    $player = readline("Enter player name for high score table: ");
    $fout = fopen("hangmanScores.txt","ab");
    $score = $lives * $number_of_letters;
    $scoreText = "$player\t$score\n";
    print($scoreText);
    fwrite($fout, $scoreText);
    fclose($fout);
}

function alphabetLeft($alphabet, $letter)
{
    if (in_array($letter, $alphabet))
    {
        print "True";
    }
    else{
        print "False";
        array_push($alphabet, $letter);
        print_r($alphabet);
    }
}

