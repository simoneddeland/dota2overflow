<h1>Meny för routes om användare</h1>
<p>Dessa routes kan också nås via navbaren. För att visa information om en användare trycker du på användarens användarnamn i någon av listorna</p>
<ul>
    <li><a href='<?= $this->url->create("users/list") ?>'>Visa samtliga användare</a></li>
    <li><a href='<?= $this->url->create("users/active") ?>'>Visa aktiva användare</a></li>
    <li><a href='<?= $this->url->create("users/deleted") ?>'>Visa borttagna användare (papperskorgen)</a></li>
    <li><a href='<?= $this->url->create("users/inactive") ?>'>Visa inaktiva användare</a></li>
    <li><a href='<?= $this->url->create("users/add") ?>'>Lägg till en ny användare</a></li>
    <li><a href='<?= $this->url->create("setup") ?>'>Återställ databasen med användare</a></li>
</ul>

