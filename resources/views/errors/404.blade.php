<link href="{{ asset('css/404error.css') }}" rel="stylesheet">


<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>MyGarden</title>
      <link rel="stylesheet" href="style.css">
   </head>
   <body>
      <div id="error-page">
         <div class="content">
            <h2 class="header" data-text="404">
               404
            </h2>
            <h4 data-text="Opps! Page not found">
               Opps! Page not found
            </h4>
            <p>
               Sorry, the page you're looking for doesn't exist. Click on the button bellow to return to the homepage.
            </p>
            <div class="btns">
               <a href="{{route('homepage')}}">return home</a>
            </div>
         </div>
      </div>
   </body>
</html>