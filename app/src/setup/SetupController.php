<?php

namespace Anax\Setup;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class SetupController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;


    /**
    * Initialize the controller.
    *
    * @return void
    */
    public function initialize()
    {
        $this->theme->setTitle("Setup");
    }

    public function allAction()
    {
        $this->usersAction();
        $this->postsAction();
        $this->commentsAction();
        $this->tagsAction();
        $this->votesAction();
    }
    public function usersAction()
    {
        //$app->db->setVerbose();

        $this->db->dropTableIfExists('user')->execute();

        $this->db->createTable(
            'user',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'acronym' => ['varchar(20)', 'unique', 'not null'],
                'email' => ['varchar(80)'],
                'name' => ['varchar(80)'],
                'profilecontent' => ['text'],
                'password' => ['varchar(255)'],
                'created' => ['datetime'],
                'updated' => ['datetime'],
                'deleted' => ['datetime'],
                'active' => ['datetime'],
            ]
        )->execute();

        $this->db->insert(
            'user',
            ['acronym', 'email', 'name', 'profilecontent','password', 'created', 'active']
        );

        $now = gmdate('Y-m-d H:i:s');

        $this->db->execute([
            'admin',
            'admin@dbwebb.se',
            'Administrator',
            "Jag **administrerar** denna sida",
            password_hash('admin', PASSWORD_DEFAULT),
            $now,
            $now
        ]);

        $this->db->execute([
            'doe',
            'doe@dbwebb.se',
            'John/Jane Doe',
            null,
            password_hash('doe', PASSWORD_DEFAULT),
            $now,
            $now
        ]);

        $this->db->execute([
            'Simon',
            'eddeland@gmail.com',
            'Simon Eddeland',
            "Det är jag som skapat denna sida.",
            password_hash('simon', PASSWORD_DEFAULT),
            $now,
            $now
        ]);

        $this->db->execute([
            'Gabe',
            'gabe@valve.com',
            'Gabe Newell',
            "Jag är grundare av **Valve** som har skapar Dota 2.

##### Inkomst
Väldigt stor",
            password_hash('gabe', PASSWORD_DEFAULT),
            $now,
            $now
        ]);

        $this->views->addString("Databasen för users återställdes.");
    }


    public function postsAction()
    {
        //$app->db->setVerbose();

        $this->db->dropTableIfExists('post')->execute();

        $this->db->createTable(
            'post',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'uid' => ['integer', 'not null'],
                'rootnode' => ['integer'],
                'title' => ['varchar(300)', 'not null'],            
                'content' => ['text'],                
                'created' => ['datetime'],
                'updated' => ['datetime'],
                'deleted' => ['datetime'],
                'active' => ['datetime'],
                'FOREIGN KEY(\'uid\')' => ['REFERENCES users(\'id\')'],
            ]
        )->execute();

        $this->db->insert(
            'post',
            ['rootnode', 'title', 'content', 'created', 'active', 'uid']
        );

        $now = gmdate('Y-m-d H:i:s');

        $this->db->execute([
            null,
            'Min första fråga',
            'Vad är dota 2?',
            $now,
            $now,
            1
        ]);

        $this->db->execute([
            null,
            'Vilken hero är bäst?',
            'Jag **vill** veta!',
            $now,
            $now,
            2
        ]);
        $this->db->execute([
            2,
            'Phantom Assassin!',
            '**Phantom assassin** är den bästa heron.',
            $now,
            $now,
            1
        ]);

        $this->db->execute([
            2,
            'Kunkka är bäst!',
            'Jag gillar Kunkka.',
            $now,
            $now,
            3
        ]);

        $this->views->addString("Postsdatabasen återställdes.");
    }

    public function commentsAction()
    {
        //$app->db->setVerbose();

        $this->db->dropTableIfExists('comment')->execute();

        $this->db->createTable(
            'comment',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'uid' => ['integer', 'not null'],
                'pid' => ['integer', 'not null'],       
                'content' => ['text'],                
                'created' => ['datetime'],
                'updated' => ['datetime'],
                'deleted' => ['datetime'],
                'active' => ['datetime'],
                'FOREIGN KEY(\'uid\')' => ['REFERENCES user(\'id\')'],
                'FOREIGN KEY(\'pid\')' => ['REFERENCES post(\'id\')'],
            ]
        )->execute();

        $this->db->insert(
            'comment',
            ['content', 'created', 'active', 'uid', 'pid']
        );

        $now = gmdate('Y-m-d H:i:s');

        $this->db->execute([
            'Du borde specificera vilken **position** heron ska användas till.',
            $now,
            $now,
            1,
            2
        ]);

        $this->db->execute([
            'Även med tanke på de senaste nerfsen?',
            $now,
            $now,
            3,
            3
        ]);

        $this->db->execute([
            'Nerfsen hittills har varit små.',
            $now,
            $now,
            1,
            3
        ]);

        $this->db->execute([
            'Googla på Dota 2',
            $now,
            $now,
            3,
            1
        ]);

        $this->views->addString("Kommentardatabasen återställdes.");
    }

    public function tagsAction()
    {
        //$app->db->setVerbose();

        $this->db->dropTableIfExists('post2tag')->execute();

        $this->db->createTable(
            'post2tag',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'tid' => ['integer', 'not null'],
                'pid' => ['integer', 'not null'],       
                'FOREIGN KEY(\'tid\')' => ['REFERENCES tag(\'id\')'],
                'FOREIGN KEY(\'pid\')' => ['REFERENCES post(\'id\')'],
            ]
        )->execute();

        $this->db->insert(
            'post2tag',
            ['tid', 'pid']
        );

        $this->db->execute([
            1,
            1
        ]);

        $this->db->execute([
            1,
            2
        ]);

        $this->db->execute([
            2,
            1
        ]);
        $this->db->execute([
            3,
            2
        ]);

        // Tag
        $this->db->dropTableIfExists('tag')->execute();

        $this->db->createTable(
            'tag',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'name' => ['varchar(300)', 'not null'],   
            ]
        )->execute();

        $this->db->insert(
            'tag',
            ['name']
        );

        $this->db->execute([
            'meta',
        ]);

        $this->db->execute([
            'pro-scene',
        ]);

        $this->db->execute([
            'strategy',
        ]);

        $this->views->addString("Tagdatabasen återställdes.");
    }

    public function votesAction()
    {
        //$app->db->setVerbose();

        $this->db->dropTableIfExists('vote')->execute();

        $this->db->createTable(
            'vote',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'uid' => ['integer', 'not null'],
                'pid' => ['integer', 'not null'],   
                'value' => ['integer', 'not null'],     
                'CONSTRAINT value_ok' => ['CHECK (value == -1 OR value == 1)'],
            ]
        )->execute();

        $this->db->insert(
            'vote',
            ['uid', 'pid', 'value']
        );

        $this->db->execute([
            1,
            1,
            1,
        ]);

        $this->db->execute([
            2,
            1,
            1,
        ]);

        $this->views->addString("Votedatabasen återställdes.");
    }
}
