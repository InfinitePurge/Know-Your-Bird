
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quizz</title>
<link href="{{ asset('manocss/quizz.css') }}" rel="stylesheet">
</head>
<body>

<a href="/" class="home-button"> Go Back</a>

<div class="container">
  <div class="header">Question</div>
  <div class="image-container">
    <!-- The image would go here -->
    <img src=""  style="max-width:100%;height:auto;">
  </div>
  <div class="buttons">
    <div class="button-row">
      <div class="button red">
        <span>Answer A</span>
        <span>More Text</span>
      </div>
      <div class="button blue">
        <span>Answer B</span>
        <span>More Text</span>
      </div>
    </div>
    <div class="button-row">
      <div class="button yellow">
        <span>Answer C</span>
        <span>More Text</span>
      </div>
      <div class="button green">
        <span>Answer D</span>
        <span>More Text</span>
      </div>
    </div>
  </div>
  <div class="skip-button">Skip</div>
</div>

</body>
</html>
