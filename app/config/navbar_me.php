<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
 
    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'home'  => [
            'text'  => 'Hem',
            'url'   => $this->di->get('url')->create(''),
            'title' => 'Min me-sida'
        ],

        'redovisning' => [
            'text'  => 'Redovisning',
            'url'   => $this->di->get('url')->create('redovisning'),
            'title' => 'Redovisningstexter i phpmvc'
        ],

        'source' => [
            'text'  => 'Källkod',
            'url'   => $this->di->get('url')->create('source'),
            'title' => 'Kolla på källkoden på denna webbplats'
        ],

        'kmom02' => [
            'text'  => 'Kmom02',
            'url'   => $this->di->get('url')->create('comment1'),
            'title' => 'Lämna en kommentar här',

            'submenu' => [
                'items' => [
                    'comment1' => [
                        'text'  => 'Kommentarer',
                        'url'   => $this->di->get('url')->create('comment1'),
                        'title' => 'Lämna en kommentar här'
                    ],

                    'comment2' => [
                        'text'  => 'Kommentarer 2',
                        'url'   => $this->di->get('url')->create('comment2'),
                        'title' => 'Lämna en kommentar här'
                    ],
                ]
            ]
        ],

        'kmom03' => [
            'text'  => 'Kmom03',
            'url'   => $this->di->get('url')->create('theme.php/regioner'),
            'title' => 'Ett tema med LESS',

            'submenu' => [
                'items' => [
                    'tema' => [
                        'text'  => 'Tema',
                        'url'   => $this->di->get('url')->create('theme.php/regioner'),
                        'title' => 'Ett tema med LESS'
                    ],

                    'typography' => [
                        'text'  => 'Typografi',
                        'url'   => $this->di->get('url')->create('theme.php/typography'),
                        'title' => 'Typografi-test'
                    ],

                    'font-awesome' => [
                        'text'  => 'Font-awesome',
                        'url'   => $this->di->get('url')->create('theme.php/font-awesome'),
                        'title' => 'Font-awesome'
                    ],
                ]
            ]
        ],

        'kmom04' => [
            'text'  => 'Kmom04',
            'url'   => $this->di->get('url')->create('users'),
            'title' => 'Databashantering',

            'submenu' => [
                'items' => [

                    'databas-list' => [
                        'text'  => 'Visa samtliga användare',
                        'url'   => $this->di->get('url')->create('users/list'),
                        'title' => 'Databashantering',
                    ],

                    'databas-grund' => [
                        'text'  => 'Visa aktiva användare',
                        'url'   => $this->di->get('url')->create('users/active'),
                        'title' => 'Databashantering',
                    ],

                    'databas-deleted' => [
                        'text'  => 'Visa borttagna användare',
                        'url'   => $this->di->get('url')->create('users/deleted'),
                        'title' => 'Borttagna användare',
                    ],

                    'databas-inactive' => [
                        'text'  => 'Visa inaktiva användare',
                        'url'   => $this->di->get('url')->create('users/inactive'),
                        'title' => 'Inaktiva användare',
                    ],

                    'databas-add' => [
                        'text'  => 'Lägg till en användare',
                        'url'   => $this->di->get('url')->create('users/add'),
                        'title' => 'Skapa en ny användare',
                    ],

                    'databas-users-setup' => [
                        'text'  => 'Setup av users',
                        'url'   => $this->di->get('url')->create('setup/users'),
                        'title' => 'Databas-setup',
                    ],

                    'comment1' => [
                        'text'  => 'Kommentarer',
                        'url'   => $this->di->get('url')->create('comment1'),
                        'title' => 'Lämna en kommentar här'
                    ],

                    'comment2' => [
                        'text'  => 'Kommentarer 2',
                        'url'   => $this->di->get('url')->create('comment2'),
                        'title' => 'Lämna en kommentar här'
                    ],

                    'databas-comments-setup' => [
                        'text'  => 'Setup av kommentarer',
                        'url'   => $this->di->get('url')->create('setup/comments'),
                        'title' => 'Databas-setup',
                    ],

                ]
            ]
        ],

        'kmom05' => [
            'text'  => 'Kmom05',
            'url'   => $this->di->get('url')->create('logtester'),
            'title' => 'Testar CLog',

            'submenu' => [
                'items' => [
                    'logtester' => [
                        'text'  => 'Testar CLog',
                        'url'   => $this->di->get('url')->create('logtester'),
                        'title' => 'Testar CLog'
                    ],

                ]
            ]
        ],


 
    ],
 


    /**
     * Callback tracing the current selected menu item base on scriptname
     *
     */
    'callback' => function ($url) {
        if ($url == $this->di->get('request')->getCurrentUrl(false)) {
            return true;
        }
    },



    /**
     * Callback to check if current page is a decendant of the menuitem, this check applies for those
     * menuitems that has the setting 'mark-if-parent' set to true.
     *
     */
    'is_parent' => function ($parent) {
        $route = $this->di->get('request')->getRoute();
        return !substr_compare($parent, $route, 0, strlen($parent));
    },



   /**
     * Callback to create the url, if needed, else comment out.
     *
     */
   /*
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },
    */
];
