# Custom views (jouw blade-templates)

Deze folder is bedoeld voor **jouw eigen Blade-views**. We raken deze folder bij
updates **nooit** aan, dus alles wat hier staat blijft bij elke `git pull` intact
zonder merge-conflicten.

## Hoe te gebruiken

Refereer in je code naar views in deze folder met de `custom.`-prefix:

```php
return view('custom.my-page', ['data' => $data]);
```

Of als layout:

```blade
@extends('custom.layouts.my-layout')
```

## Wat hier hoort

- Eigen pagina-templates voor jouw routes
- Eigen layouts of partials
- Customised versies van core-views (kopieer-en-plak van `resources/views/...`,
  voeg je wijzigingen toe, en wijs je code naar de custom-versie)

## Wat hier *niet* hoort

- Wijzigingen aan bestaande core-views in `resources/views/` —
  die zijn op eigen risico en geven mogelijk merge-conflicten bij upgrades.
- Filament's interne views (overschrijf die liever via Filament's eigen
  view-publishing mechanisme).
