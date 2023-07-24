# Installation

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

<details>
  <summary>Applications that use Symfony Flex</summary>

## Applications that use Symfony Flex

### Step 0: Add our recipes endpoint

Add this in your composer.json:

```json
{
  "extra": {
    "symfony": {
      "endpoint": [
        "https://api.github.com/repos/Enabel/recipes/contents/index.json?ref=flex/main",
        "flex://defaults"
      ],
      "allow-contrib": true
    }
  }
}
```
**Don't forget to run `compose update` as you have just modified his configuration.**

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute:

```bash
composer require enabel/layout-bundle
```

### Step 2: JavaScript dependencies & webpack configuration

Install the JavaScript dependencies by running:

```bash
yarn add $(cat vendor/enabel/layout-bundle/requirements.txt)
```

Edit `webpack.config.js` and uncomment/add the following lines:

```javascript
Encore
    // ...
    .addEntry('enabel', './assets/enabel.js')
    .addStyleEntry('error', './assets/scss/error.scss')
    .enableSassLoader()
    .enablePostCssLoader()
```

### Step 3: Build assets

```bash
yarn encore dev
```

</details>

<details>
  <summary>Applications that don't use Symfony Flex</summary>

## Applications that don't use Symfony Flex

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
composer require enabel/layout-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Enabel\LayoutBundle\EnabelLayoutBundle::class => ['all' => true],
];
```

### Step 3: Configure the Bundle

Create a configuration file `config/packages/enabel_layout.yaml` with the following configuration:
```yaml
# config/packages/enabel_layout.yaml

enabel_layout:
  application_name: Symfony Application
  application_short_name: SfApp
  application_description: Another Symfony application made by Enabel
  supported_locales: 'fr|en'
```

### Step 4: Import routing configuration

enable the routes by adding it to the list of registered routes
in the `config/routes.yaml` file of your project:

```yaml
# config/routes.yaml

enabel_user:
  resource: "@EnabelLayoutBundle/config/routes.yaml"
```

### Step 5: Create the js/sass configuration

Copy the javascript/sass/configuration files:
- `vendor/enabel/layout-bundle/assets/enabel.js` to `assets/enabel.js`
- `vendor/enabel/layout-bundle/assets/scss/enabel.scss` to `assets/scss/enabel.scss`
- `vendor/enabel/layout-bundle/assets/scss/error.scss` to `assets/scss/error.scss`
- `vendor/enabel/layout-bundle/postcss.config.js` to `postcss.config.js`
- `vendor/enabel/layout-bundle/.browserslistrc` to `.browserslistrc`

### Step 6: JavaScript dependencies & webpack configuration

Install the JavaScript dependencies by running:

```bash
yarn add $(cat vendor/enabel/layout-bundle/requirements.txt)
```

Edit `webpack.config.js` and uncomment/add the following lines:

```javascript
Encore
    // ...
    .addEntry('enabel', './assets/enabel.js')
    .addStyleEntry('error', './assets/scss/error.scss')
    .enableSassLoader()
    .enablePostCssLoader()    
```

### Step 7: Build assets

```bash
yarn encore dev
```

</details>

# Usage

## Extends the Enabel layout

In your base template `templates/base.html.twig`:

```twig
{% extends '@EnabelLayout/layout/bs5/base.html.twig' %}
```

## Override the navbar menu

You need to override the `menu` block in your base template `templates/base.html.twig`:
    
```twig
{% extends '@EnabelLayout/layout/bs5/base.html.twig' %}

{# Override the menu block #}
{% block menu %}
    {# Left side #}
    <ul class="navbar-nav me-auto mb-2 mb-md-0">
        {# Main Menu #}
        <li class="nav-item">
            <a class="nav-link" href="{{ path('app_home') }}"><i class="fas fa-home"></i> Home</a>
        </li>
    </ul>
    
    {# Right side #}
    <ul class="navbar-nav mb-2 mb-md-0">
        {# Theme & Locale Switch #}
        {{ component('theme-switch') }}
        {{ component('locale-switch') }}

        {# User Menu #}
        {% if is_granted('IS_AUTHENTICATED_FULLY') %}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user"></i> {{ app.user.displayName }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                    <li><a class="dropdown-item" href="{{ path('enabel_logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </li>
        {% else %}
            <li class="nav-item">
                <a class="nav-link" href="{{ path('enabel_login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
            </li>
        {% endif %}
        
    </ul>
{% endblock %}
```

## Our twig components

### Alert messages

Show an alert message with a content and style, by default the style is `success`.

```twig
    {{ component('alert', {message: 'Content of the message'}) }}
```

You can change the style by passing the `alertType` option:

```twig
    {{ component('alert', {alertType: 'error', message: 'Content of the error message'}) }}
    {{ component('alert', {alertType: 'info', message: 'Content of the info message'}) }}
    {{ component('alert', {alertType: 'warning', message: 'Content of the warning message'}) }}
    {{ component('alert', {alertType: 'success', message: 'Content of the success message'}) }}
    {{ component('alert', {alertType: 'danger', message: 'Content of the danger message'}) }}
```

### Theme switch in navbar

Show a theme switcher to choose between light and dark theme

```twig
    {{ component('theme-switch') }}
```

### Language switch in navbar

By default, the language switcher will display the language name in the current locale and redirect to the current route.

```twig
    {{ component('locale-switch') }}
```

You can change the route name and/or hide the language name by passing options:

```twig
    {{ component('locale-switch', {routeName: 'homepage'}) }}
    {{ component('locale-switch', {routeName: 'homepage', showName: false}) }}
```

### Theme switch in navbar

Show a theme switcher to choose between light and dark theme

```twig
    {{ component('theme-switch') }}
```

### User menu in navbar

By default, the user menu will display the user and a logout link if the user is authenticated, and a login link if not.
Login and logout routes are required.

```twig
    {{ component('user-menu', {loginRoute: 'enabel_login', logoutRoute: 'enabel_logout'}) }}
```
You can add some actions to the user menu by passing an array of actions:

```twig
    {{ component('user-menu', {
            loginRoute: 'enabel_login',
            logoutRoute: 'enabel_logout',
            actions: [
                {
                    icon: 'id-card',
                    label: 'app.menu.profile'|trans,
                    url: path('app_user_profile')
                },
                {
                    icon: 'screwdriver-wrench',
                    label: 'app.menu.admin'|trans,
                    url: path('admin')
                }
            ]
    }) }}
```
