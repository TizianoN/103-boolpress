<!DOCTYPE html>
<html lang="en">

  <head>
    <style>
      body {
        background: lightblue;
        text-align: center;
        font-family: 'Segoe UI', Arial, Helvetica, sans-serif
      }
    </style>
  </head>

  <body>
    <h1>E' stato {{ $post->published ? 'pubblicato' : 'rimosso' }} un post!</h1>
    <h2>{{ $post->title }}</h2>

  </body>

</html>
