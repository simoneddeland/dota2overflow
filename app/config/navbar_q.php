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

        'addquestion'  => [
            'text'  => 'Ny fråga',
            'url'   => $this->di->get('url')->create('post/addquestion'),
            'title' => 'Ställ en ny fråga'
        ],

        'listquestion'  => [
            'text'  => 'Frågor',
            'url'   => $this->di->get('url')->create('post/viewall'),
            'title' => 'Visa alla frågor'
        ],

        'taggar' => [
            'text'  => 'Taggar',
            'url'   => $this->di->get('url')->create('tag/list'),
            'title' => 'Taggar'
        ],

        'Användare' => [
            'text'  => 'Användare',
            'url'   => $this->di->get('url')->create('users'),
            'title' => 'Användare',
        ],

        'Authenticator' => [
            'text'  => 'Ditt konto',
            'url'   => $this->di->get('url')->create('authenticate/login'),
            'title' => 'Loggga in',

            'submenu' => [
                'items' => [
                    'inlogging' => [
                        'text'  => 'Logga in',
                        'url'   => $this->di->get('url')->create('authenticate/login'),
                        'title' => 'Logga in',
                    ],

                    'Skapa konto' => [
                        'text'  => 'Skapa konto',
                        'url'   => $this->di->get('url')->create('users/add'),
                        'title' => 'Skapa konto',
                    ],
                    'Ändra profil' => [
                        'text'  => 'Ändra din profil',
                        'url'   => $this->di->get('url')->create('users/update'),
                        'title' => 'Skapa konto',
                    ],
                    'logga ut' => [
                        'text'  => 'Logga ut',
                        'url'   => $this->di->get('url')->create('authenticate/logout'),
                        'title' => 'Logga ut',
                    ],

                ]
            ]            
        ],

        'about' => [
            'text'  => 'Om sidan',
            'url'   => $this->di->get('url')->create('about'),
            'title' => 'Om sidan',
        ],

        'Setup' => [
            'text'  => 'Setup',
            'url'   => $this->di->get('url')->create(''),
            'title' => 'Databas-setup',

            'submenu' => [
                'items' => [
                    'all-setuo' => [
                        'text'  => 'Setup av allt',
                        'url'   => $this->di->get('url')->create('setup/all'),
                        'title' => 'Databas-setup',
                    ],
                    'users-setup' => [
                        'text'  => 'Setup av users',
                        'url'   => $this->di->get('url')->create('setup/users'),
                        'title' => 'Databas-setup',
                    ],
                    'databas-comments-setup' => [
                        'text'  => 'Setup av kommentarer',
                        'url'   => $this->di->get('url')->create('setup/comments'),
                        'title' => 'Databas-setup',
                    ],
                    'databas-posts-setup' => [
                        'text'  => 'Setup av posts',
                        'url'   => $this->di->get('url')->create('setup/posts'),
                        'title' => 'Databas-setup',
                    ],
                    'databas-tags-setup' => [
                        'text'  => 'Setup av tags',
                        'url'   => $this->di->get('url')->create('setup/tags'),
                        'title' => 'Databas-setup',
                    ],
                    'databas-votes-setup' => [
                        'text'  => 'Setup av votes',
                        'url'   => $this->di->get('url')->create('setup/votes'),
                        'title' => 'Databas-setup',
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
