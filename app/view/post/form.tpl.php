<div class='comment-form'>
    <form method=post>
        <input type=hidden name="redirect" value="<?=$this->url->create($redirect)?>">
        <fieldset>
        <legend>Lämna en kommentar</legend>
        <p><label>Kommentar:<br/><textarea name='content' required><?=$content?></textarea></label></p>
        <p><label>Ditt namn:<br/><input type='text' name='name' value='<?=$name?>'/ required></label></p>
        <p><label>Hemsida:<br/><input type='text' name='web' value='<?=$web?>'/></label></p>
        <p><label>Email:<br/><input type='text' name='mail' value='<?=$mail?>'/></label></p>
        <p class=buttons>
            <input type='submit' name='doCreate' value='Kommentera' onClick="this.form.action = '<?=$this->url->create("comment/add/$pageName")?>'"/>
            <input type='reset' value='Återställ'/>
            <input type='submit' name='doRemoveAll' value='Ta bort alla kommentarer' onClick="this.form.action = '<?=$this->url->create("comment/remove-all/$pageName")?>'" formnovalidate/>
        </p>
        <output><?=$output?></output>
        </fieldset>
    </form>
</div>
