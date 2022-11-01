# Integrate-Vue3-Inertia-Bootstrap-with-Laravel9

Before we dive in deep, we just want to make sure we have all the tools we need. We'll be using PHP 8, so make sure you have that installed, Composer and NPM. I'll briefly go over how to install Composer and NPM.

# 1. Installing Laravel

Please note that I'm using Laravel 9.37.0 and PHP 8.0.24.

Making sure we are in the desired folder we're going to require the Laravel's installer globally and then use it to create a new app called "**laravel9-vue3-inertia-adminLTE**" (this will automatically create the folder with the same name).

### 1.1 Create Project

*Using this command:*

    composer create-project laravel/laravel laravel9-vue3-inertia-bootstrap

### 1.2 Change Directory

*Using this command:*

    cd laravel9-vue3-inertia-bootstrap

### 1.3 Install: npm

*Using this command:*

    npm install
    
*Using this command:*  

    npm install --save @types/node

See more: https://laravel.com/

# 2. Install Vue.js

### 2.1 Install: vue

We'll be using version 3 of Vue. Let's add Vue 3.  

*Using this command:*

    npm install vue@next
    
### 2.2 Install: vue-loader and vue-template-compiler

Unless you are an advanced user using your own forked version of Vue's template compiler, you should install `vue-loader` and `vue-template-compiler` together:  

*Using this command:*

    npm install -D vue-loader vue-template-compiler

The reason `vue-template-compiler` has to be installed separately is so that you can individually specify its version.

Every time a new version of `vue` is released, a corresponding version of `vue-template-compiler` is released together. The compiler's version must be in sync with the base `vue` package so that `vue-loader` produces code that is compatible with the runtime. This means **every time you upgrade vue in your project, you should upgrade** `vue-template-compiler` **to match it as well.**
    
See more: https://vue-loader.vuejs.org/guide/#vue-cli

# 3. Installing vitejs

In laravel 9 latest release install `vitejs/plugin-vue` plugin for installing vue3 or vue in laravel. This plugin provides required dependencies to run the vuejs application on vite. Vite is a build command that bundles your code with Rollup and runs of `localhost:4000` port to give hot refresh feature.

    npm install --save-dev vite
    npm install @vitejs/plugin-vue
    
See more: https://www.npmjs.com/package/@vitejs/plugin-vue  

# 4. Installing Inertia

Inertia is a new approach to building classic server-driven web apps. We call it the modern monolith.

Inertia allows you to create fully client-side rendered, single-page apps, without much of the complexity that comes with modern SPAs. It does this by leveraging existing server-side frameworks.

Inertia has no client-side routing, nor does it require an API. Simply build controllers and page views like you've always done!

See the [who is it](https://inertiajs.com/who-is-it-for) for and [how it works](https://inertiajs.com/how-it-works) pages to learn more.

See more: https://inertiajs.com/

### 4.1 Server-side setup

The first step when installing Inertia is to configure your server-side framework. Inertia ships with official server-side adapters for Laravel and Rails.

##### Install dependencies

Install the Inertia server-side adapters using the preferred package manager for that language or framework.

*Using this command:*

    composer require inertiajs/inertia-laravel
 
##### Middleware

Next, setup the Inertia middleware. In the Rails adapter, this is configured automatically for you. However, in Laravel you need to publish the `HandleInertiaRequests` middleware to your application, which can be done using this artisan command:

*Using this command:*

    php artisan inertia:middleware

Once generated, register the `HandleInertiaRequests` middleware in your `App\Http\Kernel.php`, as the last item in your `web` middleware group.

    'web' => [
        // ...
        \App\Http\Middleware\HandleInertiaRequests::class,
    ],

This middleware provides a version() method for setting your asset version, and a share() method for setting shared data. Please see those pages for more information.

### 4.2 Client-side setup

Once you have your server-side framework configured, you then need to setup your client-side framework. Inertia currently provides support for React, Vue, and Svelte.

##### Install dependencies

Install the Inertia client-side adapters using NPM command.

*Using this command:*

    npm install @inertiajs/inertia @inertiajs/inertia-vue3

##### Progress indicator

Since Inertia requests are made via XHR, there's no default browser loading indicator when navigating from one page to another. To solve this, Inertia provides an optional progress library, which shows a loading bar whenever you make an Inertia visit. To use it, start by installing it.

*Using this command:*

    npm install @inertiajs/progress

# 5. Install Ziggy

Ziggy provides a JavaScript `route()` helper function that works like Laravel's, making it easy to use your Laravel named routes in JavaScript.

Install Ziggy into your Laravel app with.

    composer require tightenco/ziggy

Add the `@routes` Blade directive to your main layout (_before_ your application's JavaScript), and the `route()` helper function will now be available globally!

> By default, the output of the `@routes` Blade directive includes a list of all your application's routes and their parameters. This route list is included in the HTML of the page and can be viewed by end users. To configure which routes are included in this list, or to show and hide different routes on different pages, see Filtering Routes.

See more: https://github.com/tighten/ziggy

# 6. Connect everything together

Now we have everything installed and ready to be used. We have installed **Laravel 9, Vue 3, Inertia** and **Ziggy**.

### 6.1 Setup - vite.config.js

Vite is a module bundler for modern JavaScript applications. Open `vite.config.js` and copy-paste the following code. First invoice defineConfig from vite at the top of the file and also import `laravel-vite-plugin`. Here plugins() take the path of the js and CSS file and create bundles for your application. you need to add `vue()` in the plugins array.

    import {defineConfig} from 'vite';
    import laravel from 'laravel-vite-plugin';
    import vue from '@vitejs/plugin-vue';
    
    export default defineConfig({
        plugins: [
            laravel({
                input: ['resources/js/app.js'],
                refresh: true,
            }),
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                },
            }),
        ],
        resolve: {
            alias: {
                'ziggy': '/vendor/tightenco/ziggy/src/js',
                'ziggy-vue': '/vendor/tightenco/ziggy/src/js/vue'
            },
        }
    });

### 6.2 Setup - app.blade.php

Let's start by setting up our one and only **blade** template. We're going to rename the `welcome.blade.php` to `app.blade.php` inside `resources/views`. We're also going to remove all its content and replace it with the following:

    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
    
            @routes
            @vite(['resources/js/app.js'])
            <title>Integrate-Vue3-Inertia-Bootstrap-with-Laravel9</title>
            @inertiaHead
        </head>
    
        <body>
            @inertia
        </body>
    
    </html>

So first of all you will notice we don't have any `<title>`. This is because we need it to be dynamic and we can set that using Inertia's `<Head>` component. That's why you can see that we've also added the `@inertiaHead` directive.

We have added the `@routes` directive to pass the Laravel's routes in the document's `<head>`.

We are importing our `app.css` and also a bunch of `.js` we are going to take care shortly.

In the `<body>` we only use the `@inertia` directive which renders a `div` element with a bunch of data passed to it using a `data-page` attribute.

### 6.3 Setup - Ziggy

Let's get back to Ziggy and generate the `.js` file that contains all of our routes. We'll gonna import this into our `app.js` a bit later.  

    php artisan ziggy:generate resources/js/ziggy.js

### 6.4 Setup - app.js

Let's move on by setting up our app.js file. This is our main main file we're going to load in our blade template.

Now open `resources/js/app.js` add the following chunk of code:  

    import { createApp, h } from "vue";
    import { createInertiaApp, Link, Head } from "@inertiajs/inertia-vue3";
    import { InertiaProgress } from "@inertiajs/progress";
    import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
    
    import { ZiggyVue } from "ziggy-vue";
    import { Ziggy } from "./ziggy";
    import "../css/app.css";
    
    InertiaProgress.init();
    
    createInertiaApp({
        resolve: async (name) =>
            resolvePageComponent(
                `./Pages/${name}.vue`,
                import.meta.glob("./Pages/**/*.vue")
            ),
        setup({ el, App, props, plugin }) {
            createApp({ render: () => h(App, props) })
                .use(plugin)
                .use(ZiggyVue, Ziggy)
                .component("Link", Link)
                .component("Head", Head)
                .mixin({ methods: { route: window.route } })
                .mount(el);
        },
    });

What does this is to import Vue, Inertia, Inertia Progress and Ziggy and then create the Inertia App. We're also passing the `Link` and `Head` components as globals because we're going to use them a lot.

### 6.5 Setup - Folders & Files

Inertia will load our pages from the `Pages` directory so I'm gonna create 3 demo pages in that folder (`About.vue`, `Contact.vue`,  `Home.vue`). Like so:

![](https://i.ibb.co/jhPky0G/Folders-Files.png)

*Using this command:*

    mkdir resources\js\Pages
    touch resources\js\Pages\About.vue
    touch resources\js\Pages\Contact.vue
    touch resources\js\Pages\Home.vue

Each page will container the following template. The `Homepage` text will be replaced based on the file's name:  

    <template>
        <span>
            <a :href="route('homepage')"><button>Homepage</button></a>
            <a :href="route('about')"><button>About</button></a>
            <a :href="route('contact')"><button>Contact</button></a>
        </span>
    
        <div>
            <h1>This is: {{ $page.props.title }}</h1>
        </div>
    </template>

### 6.6 Settup - web.php

We've taken care of almost everything. Not we just need to create routes for each of the Vue pages we have created.

Let's open the `routes/web.php` file and replace everything there with the following:  

    <?php
    
    use Illuminate\Support\Facades\Route;
    use Inertia\Inertia;
    
    Route::get(
        '/',
        static function () {
            return Inertia::render(
                'Home',
                [
                    'title' => 'Homepage',
                ]
            );
        }
    )->name('homepage');
    
    Route::get(
        '/about',
        static function () {
            return Inertia::render(
                'About',
                [
                    'title' => 'About',
                ]
            );
        }
    )->name('about');
    
    Route::get(
        '/contact',
        static function () {
            return Inertia::render(
                'Contact',
                [
                    'title' => 'Contact',
                ]
            );
        }
    )->name('contact');

You can notice right away that we're not returning any traditional blade view. Instead we return an `Inertia::render()` response which takes 2 parameters. The first parameter is the name of our Vue page and the 2nd is an array of properties that will be passed to the Vue page using `$page.props`.

### 6.7 Settup - .env

Open .env file and update **APP_URL** and set `APP_URL=http://localhost:8000`. It will help vite to check the js and CSS updates and changes them in the browser instantly.

    APP_URL=http://localhost:8000

# 7. Testing

The only thing left now is to compile everything and start the server:  

    npm install
    npm run build
    php artisan serve

# 8. Installing Bootstrap

Bootstrap is a powerful, feature-packed frontend toolkit. Build anything—from prototype to production—in minutes.

### 8.1 Install - bootstrap

Now we can install Bootstrap. We’ll also install Popper since our dropdowns, popovers, and tooltips depend on it for their positioning. If you don’t plan on using those components, you can omit Popper here. See more: https://getbootstrap.com/

*Using this command:*

    npm install --save bootstrap @popperjs/core
    
### 8.2 Install - additional dependency
In addition to Vite and Bootstrap, we need another dependency (Sass) to properly import and bundle Bootstrap’s CSS.

*Using this command:*
    
    npm install --save-dev sass
    
### 8.3 Install - sass-loader

*Using this command:*
    
    npm install sass-loader
    
### 8.4 Create/Edit - app.scss

Create `resources\sass\app.scss`

*Using this command:*

    mkdir resources\sass
    touch resources\sass\app.scss

and add this:

    @import '~bootstrap';

### 8.5 Edit - vite.config.js

Edit file `vite.config.js` in root project like this:

    import {defineConfig} from 'vite';
    import laravel from 'laravel-vite-plugin';
    import vue from '@vitejs/plugin-vue';
    import path from "path";
    
    export default defineConfig({
        plugins: [
            laravel({
                input: ['resources/js/app.js'],
                refresh: true,
            }),
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                },
            }),
        ],
        resolve: {
            alias: {
                'ziggy': '/vendor/tightenco/ziggy/src/js',
                'ziggy-vue': '/vendor/tightenco/ziggy/src/js/vue',
                '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            },
        }
    });
    
### 8.6 Edit - vite.config.js    

Edit file `resources\js\bootstrap.js` like this:

    import loadash from 'lodash'
    window._ = loadash
    
    import * as Popper from '@popperjs/core'
    window.Popper = Popper
    
    import 'bootstrap'
    
    /**
     * We'll load the axios HTTP library which allows us to easily issue requests
     * to our Laravel back-end. This library automatically handles sending the
     * CSRF token as a header based on the value of the "XSRF" token cookie.
     */
    
    import axios from 'axios';
    window.axios = axios;
    
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    
    /**
     * Echo exposes an expressive API for subscribing to channels and listening
     * for events that are broadcast by Laravel. Echo and event broadcasting
     * allows your team to easily build robust real-time web applications.
     */
    
    // import Echo from 'laravel-echo';
    
    // import Pusher from 'pusher-js';
    // window.Pusher = Pusher;
    
    // window.Echo = new Echo({
    //     broadcaster: 'pusher',
    //     key: import.meta.env.VITE_PUSHER_APP_KEY,
    //     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    //     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    //     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    //     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
    //     enabledTransports: ['ws', 'wss'],
    // });
    
### 8.7 Import Bootstrap SCSS in JS Folder

Now you need to import bootstrap SCSS path in you `resources/js/app.js`

    import "../sass/app.scss";
    import "./bootstrap";
    
So file `resources/js/app.js` like this:

    import { createApp, h } from "vue";
    import { createInertiaApp, Link, Head } from "@inertiajs/inertia-vue3";
    import { InertiaProgress } from "@inertiajs/progress";
    import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
    
    import { ZiggyVue } from "ziggy-vue";
    import { Ziggy } from "./ziggy";
    import "../css/app.css";
    import "../sass/app.scss";
    import "./bootstrap";
    
    InertiaProgress.init();
    
    createInertiaApp({
        resolve: async (name) =>
            resolvePageComponent(
                `./Pages/${name}.vue`,
                import.meta.glob("./Pages/**/*.vue")
            ),
        setup({ el, App, props, plugin }) {
            createApp({ render: () => h(App, props) })
                .use(plugin)
                .use(ZiggyVue, Ziggy)
                .component("Link", Link)
                .component("Head", Head)
                .mixin({ methods: { route: window.route } })
                .mount(el);
        },
    });

### 8.8 Running Vite Command to build Asset File

You need to npm run build command to create asset bootstrap

*Using this command:*
    
    npm run build
    
### 8.9 Start the Local server

Now open a new terminal and execute the following command from your terminal to run the development server.

*Using this command:*

    php artisan serve

*Example result:*

![](https://i.ibb.co/Sy1Rc6q/2022-11-01-19-45-06.png)
 
---

