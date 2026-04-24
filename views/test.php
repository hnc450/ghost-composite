<h1>test view</h1>

<h1>Mon formulaire</h1>

<form action="/csrf" method="post">
  <?=  Core\Security::csrf_tokken(); ?>
    <label for="name">Nom :</label>
    <input type="text" id="name" name="name">
    <br><br>
    <input type="submit" value="Envoyer">
  </form>
