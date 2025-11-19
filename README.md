# Enabel: Layout Bundle

[![License](https://img.shields.io/badge/license-MIT-red.svg?style=flat-square)](LICENSE)
[![SymfonyInsight](https://insight.symfony.com/projects/cc5c511d-1ce0-480b-af3f-38e9635f2a14/mini.svg)](https://insight.symfony.com/projects/cc5c511d-1ce0-480b-af3f-38e9635f2a14)
[![codecov](https://codecov.io/gh/Enabel/layout-bundle/graph/badge.svg?token=jlik2vBpeu)](https://codecov.io/gh/Enabel/layout-bundle)
[![CI](https://github.com/Enabel/layout-bundle/actions/workflows/CI.yml/badge.svg)](https://github.com/Enabel/layout-bundle/actions/workflows/CI.yml)

> **⚠️ Deprecation Notice**
>
> This project is deprecated and no longer maintained.  
> Use the recommended alternative:  
> [Enabel UX](https://github.com/enabel/ux)

## Introduction

The bundle aims to provide basic layout and helpers for Symfony applications, including:

- Responsive Bootstrap 5 layout with Enabel styling
- Configurable Twig Components:
  - Alert messages with different types (success, danger, error, warning, info)
  - Theme switcher (light/dark mode)
  - Locale switcher for multilingual applications
  - User menu with customizable actions
- Favicon configuration and management
- Error page templates
- Email templates
- CSS theming based on Enabel's design system

## Key Features

- **Responsive Layout System**: Pre-configured Bootstrap 5 layout with Enabel branding
- **Twig Components**: Ready-to-use UI components with minimal configuration
- **Theme Support**: Built-in light/dark mode switching
- **Internationalization**: Easy locale switching for multilingual applications
- **Accessibility**: Components designed with accessibility in mind
- **User Interface**: User menu and authentication integration
- **Customization**: Configurable application name, description, and supported locales
- **Modern Frontend**: Uses AssetMapper for efficient asset management

## Installation & Usage

Full installation and usage documentation is available [here](docs/index.md)

Using Symfony Flex, don't forget to add the recipes endpoint:

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

## Requirements & Compatibility

- PHP: 8.0 or higher
- Symfony: 6.0+ and 7.0+ supported
- Twig: 3.4+
- Symfony UX Twig Component: 2.7+

The bundle uses AssetMapper for asset management and requires some packages:
- `@enabel/enabel-bootstrap-theme`: For Enabel's Bootstrap theme
- `@fontsource-variable/maven-pro`: For the Maven Pro font

The project follows [Semantic Versioning](https://semver.org/).

You can check the [changelog](CHANGELOG.md) for version history and updates.

## Contributing

Feel free to contribute, like sending [pull requests](https://github.com/enabel/layout-bundle/pulls) to add features/tests
or [creating issues](https://github.com/enabel/layout-bundle/issues)

Note there are a few helpers to maintain code quality, that you can run using these commands:

```bash
composer cs # Code style check
composer stan # Static analysis
composer insight # Code analysis 
composer test # Run tests
```

