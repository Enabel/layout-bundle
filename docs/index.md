# Installation

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

## Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```bash
composer require enabel/layout-bundle
```

### Step 1: JavaScript dependencies & webpack configuration

Install the JavaScript dependencies by running:

```bash
yarn add $(cat vendor/enabel/layout-bundle/requirements.txt)
```

Edit `webpack.config.js` and uncomment/add the following lines:

```javascript
Encore
    // ...
    .addEntry('enabel', './assets/enabel.js')
    .addStyleEntry('error', './assets/styles/error.scss')
    .enableSassLoader()
    .enablePostCssLoader()
```

### Step 2: Build assets

```bash
yarn encore dev
```

### Step 3: Extends the Enabel layout

Replace the content of your base template `templates/base.html.twig` with this:

```twig
{% extends '@EnabelLayout/layout/bs5/base.html.twig' %}
```

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
- `vendor/enabel/layout-bundle/assets/styles/enabel.scss` to `assets/styles/enabel.scss`
- `vendor/enabel/layout-bundle/assets/styles/error.scss` to `assets/styles/error.scss`
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
    .addStyleEntry('error', './assets/styles/error.scss')
    .enableSassLoader()
    .enablePostCssLoader()    
```

### Step 7: Build assets

```bash
yarn encore dev
```

### Step 8: Extends the Enabel layout

In your base template `templates/base.html.twig`:

```twig
{% extends '@EnabelLayout/layout/bs5/base.html.twig' %}
```
