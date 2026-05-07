# Custom code (jouw uitbreidingen)

Deze folder is bedoeld voor **jouw eigen code** die niet bij BankBird's upstream hoort.
We raken deze folder bij updates **nooit** aan, dus alles wat hier staat blijft bij elke `git pull` intact zonder merge-conflicten.

## Wat hier hoort

- Eigen Filament Resources, Pages of Widgets — namespace `App\Custom\Filament\...`
- Eigen Services, Helpers, Jobs — namespace `App\Custom\...`
- Eigen Console-commando's
- Bedrijfsspecifieke logica die alleen voor jouw deployment relevant is

## Wat hier *niet* hoort

- Wijzigingen aan BankBird's core (modellen, migraties, bestaande Filament-resources) —
  die zijn op eigen risico en geven mogelijk merge-conflicten bij upgrades.
- Configuratie die ook via de UI / `app_settings` kan (logo, branding, AI-keys, etc) —
  gebruik daar liever de `Instellingen`-pagina.

## Auto-discovery

Custom Filament resources moeten zelf geregistreerd worden — voeg ze toe in een eigen
service provider in deze folder en register die in `bootstrap/providers.php`. We willen
hier niet ongevraagd auto-discovery aanzetten omdat dat ongewenste classes zou activeren.

## Voorbeelden

```
app/Custom/
├── Filament/
│   └── Resources/
│       └── ProjectResource.php       # eigen resource
├── Services/
│   └── KvkLookupService.php          # eigen service
└── CustomServiceProvider.php          # registreer hier auto-discovery indien gewenst
```
