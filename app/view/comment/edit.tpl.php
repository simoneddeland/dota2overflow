<h1>Edit a post here</h1>
<div class='comment-form'>
    <form method=post>
        <input type=hidden name="redirect" value="<?=$this->url->create($redirect)?>">
        <input type='hidden' name='id' value='<?=$id?>'>
        <fieldset>
        <legend>Ändra</legend>
        <p><label>Kommentar:<br/><textarea name='content' required><?=$content?></textarea></label></p>
        <p><label>Ditt namn:<br/><input type='text' name='name' value='<?=$name?>' required/></label></p>
        <p><label>Hemsida:<br/><input type='text' name='web' value='<?=$web?>'/></label></p>
        <p><label>Email:<br/><input type='text' name='mail' value='<?=$mail?>'/></label></p>
        <p class=buttons>
            <input type='submit' name='doEdit' value='Kommentera' onClick="this.form.action = '<?=$this->url->create("comment/edit/$id/$pageName")?>'"/>
            <input type='reset' value='Återställ' formnovalidate/>
        </p>
        <output><?=$output?></output>
        </fieldset>
    </form>
</div>
