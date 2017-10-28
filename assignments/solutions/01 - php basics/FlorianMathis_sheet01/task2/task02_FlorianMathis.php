<!DOCTYPE html>
<html>
<head lang="en">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Shuffle my words</title>
  <style>
    textarea {
      width: 100%;
      display: block;
      margin: 10px 0;
    }
  </style>
</head>
<body>
<header>
  <h2>Shuffle my words!</h2>
</header>
<div id="container">
  <div class="card">
    <form method="post">
  <textarea placeholder="Your text here" name="text"><?php if (isset($_POST['text'])) {
      echo $_POST['text'];
    } ?></textarea>
      <button type="submit">Shuffle!</button>
    </form>
  </div>
  <?php
  // Your code goes here. Ok.
  // still open: check if it is a special char
  echo '<div class="card">';
  echo '<textarea placeholder="Your shuffled text will be here" name="textoutput">';
   if(isset($_POST['text'])) {
     //shuffled text
      $text = $_POST['text'];
      $words = split_into_words($text);
      $shuffledtext = shuffle_text($words);
      echo $shuffledtext;
   }
  echo '</textarea>';
  echo '</div>';
  // i need single words to shuffle them
 function split_into_words($text){
      return explode(" ",$text);
  }
  /* take all words and shuffle each one
    * first letter should be the first letter
    * laster letter should be the last letter
    * the position of the chars between should be random
  */
  function shuffle_text($words){
    $shuffled_text ="";
    foreach ($words as $word){
        if(strlen($word) > 3){
          $first= $word[0];
          $last= $word[strlen($word)-1];
          $between = substr($word,1,strlen($word)-2);
          $random_between = str_shuffle($between);
          $shuffled_text = $shuffled_text . $first . $random_between .$last . " ";
          }
        else $shuffled_text = $shuffled_text . $word . " ";
    }
    return $shuffled_text;
  }
  ?>
</div>
<link rel="stylesheet" href="http://www.medien.ifi.lmu.de/lehre/ws1617/mmn/uebung/material/assignments.css">
</body>
</html>
