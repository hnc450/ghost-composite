<?php
   namespace Tests;

use App\View;

   class ViewTest 
   {
       public function testViewRendersTemplate()
       {
          View::view('index');
          View::view('admin.index');
       }
   }
?>