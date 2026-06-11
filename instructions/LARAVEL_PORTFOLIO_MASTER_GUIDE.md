# Laravel Portfolio Master Guide

Guida unica per ricostruire da zero un progetto Laravel 11 analogo a `laravel-portfolio`, con Breeze, Bootstrap, autenticazione, area admin, CRUD, relazioni, seeder, Faker, upload immagini, API e workflow Git.

Questa guida sostituisce checklist, appunti MVC e startup notes separati. È pensata per due usi:

1. **rifare il progetto passo dopo passo**, nello stesso ordine logico del portfolio finale;
2. **cercare velocemente un comando o una procedura**, grazie al sommario profondo e alla quick reference.

---

# Sommario

## Consultazione rapida

- [0. Come usare questa guida](#0-come-usare-questa-guida)
- [1. Quick reference comandi](#1-quick-reference-comandi)
  - [1.1 Nuovo progetto Laravel](#11-nuovo-progetto-laravel)
  - [1.2 Avvio progetto clonato o template](#12-avvio-progetto-clonato-o-template)
  - [1.3 Server locale e Vite](#13-server-locale-e-vite)
  - [1.4 Git base](#14-git-base)
  - [1.5 Composer](#15-composer)
  - [1.6 NPM e asset frontend](#16-npm-e-asset-frontend)
  - [1.7 Artisan: comandi frequenti](#17-artisan-comandi-frequenti)
  - [1.8 Database, migration e seeder](#18-database-migration-e-seeder)
  - [1.9 Model, controller e resource](#19-model-controller-e-resource)
  - [1.10 Breeze, Bootstrap e autenticazione](#110-breeze-bootstrap-e-autenticazione)
  - [1.11 Storage e immagini](#111-storage-e-immagini)
  - [1.12 API](#112-api)
  - [1.13 Test e controlli](#113-test-e-controlli)

## Costruzione completa del progetto Portfolio

- [2. Obiettivo e architettura finale del progetto](#2-obiettivo-e-architettura-finale-del-progetto)
  - [2.1 Cosa contiene il portfolio finale](#21-cosa-contiene-il-portfolio-finale)
  - [2.2 Struttura cartelle rilevante](#22-struttura-cartelle-rilevante)
  - [2.3 Entità principali](#23-entità-principali)
  - [2.4 Relazioni finali](#24-relazioni-finali)
- [3. Creazione progetto da zero](#3-creazione-progetto-da-zero)
  - [3.1 Comando create-project](#31-comando-create-project)
  - [3.2 Entrare nella cartella progetto](#32-entrare-nella-cartella-progetto)
  - [3.3 Installare dipendenze PHP e Node](#33-installare-dipendenze-php-e-node)
  - [3.4 Creare e configurare `.env`](#34-creare-e-configurare-env)
  - [3.5 Generare APP_KEY](#35-generare-app_key)
  - [3.6 Configurare database](#36-configurare-database)
  - [3.7 Primo avvio](#37-primo-avvio)
  - [3.8 Primo commit Git](#38-primo-commit-git)
- [4. Git workflow consigliato](#4-git-workflow-consigliato)
  - [4.1 Commit piccoli](#41-commit-piccoli)
  - [4.2 Branch di prova](#42-branch-di-prova)
  - [4.3 Tornare indietro a un commit pulito](#43-tornare-indietro-a-un-commit-pulito)
  - [4.4 Leggere la cronologia](#44-leggere-la-cronologia)
- [5. Frontend: Vite, Sass e Bootstrap](#5-frontend-vite-sass-e-bootstrap)
  - [5.1 Problema reale: Vite 8 incompatibile](#51-problema-reale-vite-8-incompatibile)
  - [5.2 Versioni finali package.json](#52-versioni-finali-packagejson)
  - [5.3 Installare Bootstrap e Bootstrap Icons](#53-installare-bootstrap-e-bootstrap-icons)
  - [5.4 Configurare `resources/scss/app.scss`](#54-configurare-resourcesscssappscss)
  - [5.5 Configurare `resources/js/app.js`](#55-configurare-resourcesjsappjs)
  - [5.6 Usare Vite nel layout Blade](#56-usare-vite-nel-layout-blade)
- [6. Breeze + Bootstrap authentication](#6-breeze--bootstrap-authentication)
  - [6.1 Installare Breeze](#61-installare-breeze)
  - [6.2 Installare preset Bootstrap](#62-installare-preset-bootstrap)
  - [6.3 Cosa introduce Breeze](#63-cosa-introduce-breeze)
  - [6.4 Cosa introduce il preset Bootstrap](#64-cosa-introduce-il-preset-bootstrap)
  - [6.5 PHPUnit e Pest](#65-phpunit-e-pest)
  - [6.6 Migration auth](#66-migration-auth)
  - [6.7 Rotte auth](#67-rotte-auth)
- [7. MVC: flusso mentale Laravel](#7-mvc-flusso-mentale-laravel)
  - [7.1 Route](#71-route)
  - [7.2 Controller](#72-controller)
  - [7.3 Model](#73-model)
  - [7.4 Migration](#74-migration)
  - [7.5 Seeder](#75-seeder)
  - [7.6 View Blade](#76-view-blade)
  - [7.7 Componenti Blade](#77-componenti-blade)
- [8. Layout, partials e Blade](#8-layout-partials-e-blade)
  - [8.1 Layout app](#81-layout-app)
  - [8.2 Layout admin](#82-layout-admin)
  - [8.3 Header partial](#83-header-partial)
  - [8.4 `@yield`, `@section`, `@extends`](#84-yield-section-extends)
  - [8.5 `@include`](#85-include)
  - [8.6 `@guest`, `@auth`, `Auth::user()`](#86-guest-auth-authuser)
  - [8.7 Active link nella navbar](#87-active-link-nella-navbar)
  - [8.8 CSRF nei form](#88-csrf-nei-form)
  - [8.9 Method spoofing PUT/PATCH/DELETE](#89-method-spoofing-putpatchdelete)
- [9. Area admin protetta](#9-area-admin-protetta)
  - [9.1 Creare DashboardController](#91-creare-dashboardcontroller)
  - [9.2 Rotte admin con prefix, name e middleware](#92-rotte-admin-con-prefix-name-e-middleware)
  - [9.3 View homepage admin](#93-view-homepage-admin)
- [10. Entità Project](#10-entità-project)
  - [10.1 Creare model Project](#101-creare-model-project)
  - [10.2 Creare migration projects](#102-creare-migration-projects)
  - [10.3 Struttura tabella projects](#103-struttura-tabella-projects)
  - [10.4 Creare seeder ProjectsTableSeeder](#104-creare-seeder-projectstableseeder)
  - [10.5 Faker nel ProjectsTableSeeder](#105-faker-nel-projectstableseeder)
  - [10.6 Registrare seeder in DatabaseSeeder](#106-registrare-seeder-in-databaseseeder)
  - [10.7 Creare ProjectController resource](#107-creare-projectcontroller-resource)
  - [10.8 Route resource projects](#108-route-resource-projects)
  - [10.9 Index projects](#109-index-projects)
  - [10.10 Show project](#1010-show-project)
  - [10.11 Create e store project](#1011-create-e-store-project)
  - [10.12 Edit e update project](#1012-edit-e-update-project)
  - [10.13 Destroy project](#1013-destroy-project)
  - [10.14 Modal di cancellazione](#1014-modal-di-cancellazione)
- [11. Entità Type e relazione 1:N](#11-entità-type-e-relazione-1n)
  - [11.1 Creare Type model e migration](#111-creare-type-model-e-migration)
  - [11.2 Migration types](#112-migration-types)
  - [11.3 Aggiungere type_id a projects](#113-aggiungere-type_id-a-projects)
  - [11.4 Relazione Project belongsTo Type](#114-relazione-project-belongsto-type)
  - [11.5 Relazione Type hasMany Projects](#115-relazione-type-hasmany-projects)
  - [11.6 TypesTableSeeder](#116-typestableseeder)
  - [11.7 TypeController resource](#117-typecontroller-resource)
  - [11.8 Route resource types](#118-route-resource-types)
  - [11.9 Select type nel form project](#119-select-type-nel-form-project)
- [12. Entità Technology e relazione N:N](#12-entità-technology-e-relazione-nn)
  - [12.1 Creare Technology model e migration](#121-creare-technology-model-e-migration)
  - [12.2 Migration technologies](#122-migration-technologies)
  - [12.3 Pivot project_technology](#123-pivot-project_technology)
  - [12.4 Relazioni belongsToMany](#124-relazioni-belongstomany)
  - [12.5 TechnologiesTableSeeder](#125-technologiestableseeder)
  - [12.6 Seeder pivot tramite attach](#126-seeder-pivot-tramite-attach)
  - [12.7 TechnologyController resource](#127-technologycontroller-resource)
  - [12.8 Route resource technologies](#128-route-resource-technologies)
  - [12.9 Checkbox technologies nel form project](#129-checkbox-technologies-nel-form-project)
  - [12.10 `attach`, `sync`, `detach`](#1210-attach-sync-detach)
- [13. Database, migration, seeder e Faker](#13-database-migration-seeder-e-faker)
  - [13.1 Migration: cosa sono](#131-migration-cosa-sono)
  - [13.2 Comandi migration](#132-comandi-migration)
  - [13.3 Seeder: cosa sono](#133-seeder-cosa-sono)
  - [13.4 Comandi seeder](#134-comandi-seeder)
  - [13.5 Registrare più seeder in DatabaseSeeder](#135-registrare-più-seeder-in-databaseseeder)
  - [13.6 Ordine dei seeder](#136-ordine-dei-seeder)
  - [13.7 Faker: cosa fa](#137-faker-cosa-fa)
  - [13.8 Faker con dependency injection](#138-faker-con-dependency-injection)
  - [13.9 Factory: extra utile](#139-factory-extra-utile)
  - [13.10 Seeder vs Factory](#1310-seeder-vs-factory)
- [14. CRUD Resource completo](#14-crud-resource-completo)
  - [14.1 Tabella azioni resource](#141-tabella-azioni-resource)
  - [14.2 `index`](#142-index)
  - [14.3 `create`](#143-create)
  - [14.4 `store`](#144-store)
  - [14.5 `show`](#145-show)
  - [14.6 `edit`](#146-edit)
  - [14.7 `update`](#147-update)
  - [14.8 `destroy`](#148-destroy)
  - [14.9 Redirect con route name](#149-redirect-con-route-name)
  - [14.10 Route model binding](#1410-route-model-binding)
- [15. Validazione e Form Request](#15-validazione-e-form-request)
  - [15.1 Validazione inline nel controller](#151-validazione-inline-nel-controller)
  - [15.2 Creare Form Request](#152-creare-form-request)
  - [15.3 Regole StoreProjectRequest](#153-regole-storeprojectrequest)
  - [15.4 Regole UpdateProjectRequest](#154-regole-updateprojectrequest)
  - [15.5 Messaggi di errore Blade](#155-messaggi-di-errore-blade)
  - [15.6 Mass assignment e fillable](#156-mass-assignment-e-fillable)
- [16. Upload immagini e Storage](#16-upload-immagini-e-storage)
  - [16.1 Configurare FILESYSTEM_DISK](#161-configurare-filesystem_disk)
  - [16.2 Creare storage link](#162-creare-storage-link)
  - [16.3 Aggiungere colonna image](#163-aggiungere-colonna-image)
  - [16.4 Form con enctype](#164-form-con-enctype)
  - [16.5 Input file](#165-input-file)
  - [16.6 Salvare immagine in store](#166-salvare-immagine-in-store)
  - [16.7 Mostrare immagine in Blade](#167-mostrare-immagine-in-blade)
  - [16.8 Sostituire immagine in update](#168-sostituire-immagine-in-update)
  - [16.9 Cancellare immagine in destroy](#169-cancellare-immagine-in-destroy)
  - [16.10 Validare immagini](#1610-validare-immagini)
- [17. API pubblica](#17-api-pubblica)
  - [17.1 Installare API scaffolding](#171-installare-api-scaffolding)
  - [17.2 Sanctum e personal access tokens](#172-sanctum-e-personal-access-tokens)
  - [17.3 Creare Api ProjectController](#173-creare-api-projectcontroller)
  - [17.4 Rotte API](#174-rotte-api)
  - [17.5 Risposta JSON index](#175-risposta-json-index)
  - [17.6 Risposta JSON show](#176-risposta-json-show)
  - [17.7 Eager loading con `with` e `load`](#177-eager-loading-con-with-e-load)
  - [17.8 CORS](#178-cors)
- [18. Middleware e protezione rotte](#18-middleware-e-protezione-rotte)
  - [18.1 `auth`](#181-auth)
  - [18.2 `verified`](#182-verified)
  - [18.3 Middleware su gruppo](#183-middleware-su-gruppo)
  - [18.4 Middleware su resource](#184-middleware-su-resource)
- [19. Eloquent: query e relazioni](#19-eloquent-query-e-relazioni)
  - [19.1 Query base](#191-query-base)
  - [19.2 Collection vs model singolo](#192-collection-vs-model-singolo)
  - [19.3 `with` per evitare N+1](#193-with-per-evitare-n1)
  - [19.4 Relazioni nullable e `nullOnDelete`](#194-relazioni-nullable-e-nullondelete)
  - [19.5 Cascade delete sulla pivot](#195-cascade-delete-sulla-pivot)
- [20. Componenti Blade e riuso markup](#20-componenti-blade-e-riuso-markup)
  - [20.1 Creare component](#201-creare-component)
  - [20.2 Slot](#202-slot)
  - [20.3 Props](#203-props)
  - [20.4 Component modal](#204-component-modal)
- [21. Troubleshooting](#21-troubleshooting)
  - [21.1 Errore npm ERESOLVE Vite](#211-errore-npm-eresolve-vite)
  - [21.2 `.env` mancante](#212-env-mancante)
  - [21.3 APP_KEY mancante](#213-app_key-mancante)
  - [21.4 Migration fallite](#214-migration-fallite)
  - [21.5 Immagini non visibili](#215-immagini-non-visibili)
  - [21.6 Rotte non trovate](#216-rotte-non-trovate)
  - [21.7 Classi non trovate](#217-classi-non-trovate)
- [22. Sequenza reale dei commit del portfolio](#22-sequenza-reale-dei-commit-del-portfolio)
  - [22.1 Base, Breeze e Bootstrap](#221-base-breeze-e-bootstrap)
  - [22.2 Admin e Project CRUD](#222-admin-e-project-crud)
  - [22.3 Type e relazione 1:N](#223-type-e-relazione-1n)
  - [22.4 Technology e relazione N:N](#224-technology-e-relazione-nn)
  - [22.5 API, CORS e upload immagini](#225-api-cors-e-upload-immagini)
- [23. Checklist finale per rifare il progetto](#23-checklist-finale-per-rifare-il-progetto)
- [24. Appendice: comandi completi](#24-appendice-comandi-completi)
  - [24.1 Composer](#241-composer)
  - [24.2 NPM](#242-npm)
  - [24.3 Artisan progetto](#243-artisan-progetto)
  - [24.4 Artisan make](#244-artisan-make)
  - [24.5 Artisan database](#245-artisan-database)
  - [24.6 Artisan route/cache/config](#246-artisan-routecacheconfig)
  - [24.7 Git](#247-git)

---

# 0. Come usare questa guida

Usala in tre modi:

- **Per rifare il portfolio da zero:** parti dalla sezione [3](#3-creazione-progetto-da-zero) e segui in ordine fino alla [17](#17-api-pubblica).
- **Per cercare comandi velocemente:** usa la [Quick reference](#1-quick-reference-comandi) o l'[appendice comandi](#24-appendice-comandi-completi).
- **Per capire un concetto Laravel:** vai alle sezioni didascaliche MVC, CRUD, Eloquent, Storage, API, Validation.

Convenzione importante: i comandi sono pensati per terminale da cartella root del progetto, cioè dove si trovano `artisan`, `composer.json` e `package.json`.

---

# 1. Quick reference comandi

Questa sezione serve per trovare subito il comando giusto. Le spiegazioni complete sono nelle sezioni successive.

## 1.1 Nuovo progetto Laravel

```bash
composer create-project --prefer-dist laravel/laravel:^11.0 nome-progetto
```

Crea un nuovo progetto Laravel 11 scaricando lo skeleton ufficiale.

```bash
cd nome-progetto
```

Entra nella cartella del progetto.

```bash
composer install
```

Installa le dipendenze PHP indicate in `composer.json`. In un progetto appena creato spesso sono già presenti, ma è utile ricordarlo.

```bash
npm install
```

Installa le dipendenze frontend indicate in `package.json`.

```bash
copy .env.example .env
```

Crea il file `.env` su Windows PowerShell/CMD a partire da `.env.example`.

Su macOS/Linux/Git Bash:

```bash
cp .env.example .env
```

```bash
php artisan key:generate
```

Genera la chiave applicativa `APP_KEY`, necessaria per sessioni, cookie e sicurezza.

## 1.2 Avvio progetto clonato o template

Dopo clone da GitHub o copia di un template:

```bash
composer install
npm install
copy .env.example .env
php artisan key:generate
```

Poi configura database in `.env` e lancia:

```bash
php artisan migrate --seed
```

Crea le tabelle e popola il database con i seeder.

## 1.3 Server locale e Vite

```bash
php artisan serve
```

Avvia il server Laravel, di solito su `http://127.0.0.1:8000`.

```bash
npm run dev
```

Avvia Vite in modalità sviluppo: compila asset e resta in ascolto delle modifiche.

```bash
npm run build
```

Compila gli asset per produzione dentro `public/build`.

## 1.4 Git base

```bash
git init
git add .
git commit -m "nuovo progetto laravel"
```

Inizializza Git e salva il primo snapshot.

```bash
git status
```

Mostra file modificati, nuovi o cancellati.

```bash
git diff --name-status
```

Mostra l'elenco dei file modificati con stato: aggiunto, modificato, eliminato.

```bash
git checkout -b nome-branch
```

Crea un branch di prova.

```bash
git reset --hard HEAD
```

Scarta tutte le modifiche non committate e torna all'ultimo commit.

## 1.5 Composer

```bash
composer require laravel/breeze --dev
```

Installa Breeze come dipendenza di sviluppo.

```bash
composer require pacificdev/laravel_9_preset
```

Installa il preset Bootstrap usato nel corso per generare auth Bootstrap.

```bash
composer require nome/pacchetto
```

Installa un pacchetto PHP e aggiorna `composer.json` + `composer.lock`.

```bash
composer install
```

Installa esattamente le dipendenze bloccate in `composer.lock`.

```bash
composer update
```

Aggiorna le dipendenze entro i vincoli di `composer.json`. Usalo con cautela.

## 1.6 NPM e asset frontend

```bash
npm install
```

Installa dipendenze Node.

```bash
npm install bootstrap @popperjs/core bootstrap-icons
```

Installa Bootstrap, Popper e Bootstrap Icons.

```bash
npm run dev
```

Avvia Vite.

```bash
npm run build
```

Genera build produzione.

## 1.7 Artisan: comandi frequenti

```bash
php artisan route:list
```

Mostra tutte le rotte registrate.

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

Pulisce cache di config, applicazione, view e rotte.

```bash
php artisan test
```

Esegue i test PHPUnit.

## 1.8 Database, migration e seeder

```bash
php artisan migrate
```

Esegue le migration non ancora applicate.

```bash
php artisan migrate:rollback
```

Annulla l'ultimo batch di migration.

```bash
php artisan migrate:fresh
```

Elimina tutte le tabelle e le ricrea da zero.

```bash
php artisan migrate:fresh --seed
```

Elimina tutte le tabelle, le ricrea e lancia i seeder.

```bash
php artisan db:seed
```

Esegue `DatabaseSeeder`.

```bash
php artisan db:seed --class=ProjectsTableSeeder
```

Esegue un seeder specifico.

## 1.9 Model, controller e resource

```bash
php artisan make:model Project
```

Crea un model.

```bash
php artisan make:model Project -m
```

Crea model e migration.

```bash
php artisan make:controller Admin/ProjectController --resource
```

Crea un controller resource con metodi CRUD già predisposti.

```bash
php artisan make:migration create_projects_table
```

Crea una migration.

```bash
php artisan make:seeder ProjectsTableSeeder
```

Crea un seeder.

## 1.10 Breeze, Bootstrap e autenticazione

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
```

Installa lo scaffolding auth Breeze con Blade.

```bash
composer require pacificdev/laravel_9_preset
php artisan preset:ui bootstrap --auth
```

Applica preset Bootstrap auth come da corso.

## 1.11 Storage e immagini

```bash
php artisan storage:link
```

Crea link simbolico `public/storage` verso `storage/app/public`.

```php
Storage::putFile('projects', $request->file('image'));
```

Salva un file nel disco configurato.

```php
Storage::delete($project->image);
```

Cancella un file salvato.

## 1.12 API

```bash
php artisan install:api
```

Installa scaffolding API di Laravel 11, incluso Sanctum e `routes/api.php`.

```bash
php artisan make:controller Api/ProjectController
```

Crea controller per API.

## 1.13 Test e controlli

```bash
php artisan test
```

Esegue test.

```bash
php artisan route:list
```

Controlla che le rotte siano presenti.

```bash
npm run build
```

Controlla che la build frontend funzioni.

---

# 2. Obiettivo e architettura finale del progetto

## 2.1 Cosa contiene il portfolio finale

Il progetto finale `laravel-portfolio` contiene:

- Laravel 11;
- Breeze per autenticazione;
- Bootstrap via preset del corso;
- area admin protetta da login;
- CRUD completo per `Project`;
- CRUD completo per `Type`;
- CRUD completo per `Technology`;
- relazione 1:N tra `Type` e `Project`;
- relazione N:N tra `Project` e `Technology` con tabella pivot;
- seeder con Faker;
- upload immagini con `Storage`;
- API pubblica per lista e dettaglio progetti;
- CORS configurato per frontend esterno;
- layout admin con partial header.

## 2.2 Struttura cartelle rilevante

```txt
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   ├── ProjectController.php
│   │   │   ├── TypeController.php
│   │   │   └── TechnologyController.php
│   │   ├── Api/
│   │   │   └── ProjectController.php
│   │   ├── Auth/
│   │   └── ProfileController.php
│   └── Requests/
├── Models/
│   ├── Project.php
│   ├── Type.php
│   ├── Technology.php
│   └── User.php
└── View/
    └── Components/

resources/
├── js/
├── scss/
└── views/
    ├── admin/
    ├── auth/
    ├── crud/
    ├── layouts/
    ├── partials/
    └── profile/

routes/
├── web.php
├── api.php
└── auth.php

database/
├── migrations/
└── seeders/
```

## 2.3 Entità principali

### Project

Rappresenta un progetto del portfolio.

Campi principali:

```txt
id
name
type_id
customer
description
start_date
end_date
image
created_at
updated_at
```

### Type

Rappresenta la categoria/tipologia del progetto.

Campi:

```txt
id
name
description
created_at
updated_at
```

### Technology

Rappresenta una tecnologia usata nei progetti.

Campi:

```txt
id
name
color
created_at
updated_at
```

### Pivot project_technology

Collega progetti e tecnologie.

Campi:

```txt
id
project_id
technology_id
created_at
updated_at
```

## 2.4 Relazioni finali

```txt
Type 1 ---- N Project
Project N ---- N Technology
```

In Eloquent:

```php
// Project.php
public function type()
{
    return $this->belongsTo(Type::class);
}

public function technologies()
{
    return $this->belongsToMany(Technology::class)->withTimestamps();
}
```

```php
// Type.php
public function projects()
{
    return $this->hasMany(Project::class);
}
```

```php
// Technology.php
public function projects()
{
    return $this->belongsToMany(Project::class)->withTimestamps();
}
```

---

# 3. Creazione progetto da zero

## 3.1 Comando create-project

```bash
composer create-project --prefer-dist laravel/laravel:^11.0 laravel-portfolio
```

Crea un nuovo progetto Laravel 11 chiamato `laravel-portfolio`.

- `composer create-project`: crea un progetto partendo da un pacchetto Composer.
- `--prefer-dist`: scarica archivio distribuito invece del repository completo.
- `laravel/laravel:^11.0`: usa lo skeleton Laravel versione 11.
- `laravel-portfolio`: nome cartella progetto.

## 3.2 Entrare nella cartella progetto

```bash
cd laravel-portfolio
```

Tutti i comandi successivi vanno lanciati dentro questa cartella.

## 3.3 Installare dipendenze PHP e Node

```bash
composer install
npm install
```

`composer install` installa le librerie PHP in `vendor/`.

`npm install` installa le librerie frontend in `node_modules/`.

Non pushare mai `vendor/` e `node_modules/` su GitHub.

## 3.4 Creare e configurare `.env`

Windows:

```bash
copy .env.example .env
```

macOS/Linux/Git Bash:

```bash
cp .env.example .env
```

Il file `.env` contiene configurazioni locali: nome app, database, mail, filesystem, ecc.

## 3.5 Generare APP_KEY

```bash
php artisan key:generate
```

Genera `APP_KEY` dentro `.env`.

Senza questa chiave Laravel può dare errori su sessioni, login, cookie e cifratura.

## 3.6 Configurare database

Esempio MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_portfolio
DB_USERNAME=root
DB_PASSWORD=root
```

Il valore di `DB_DATABASE` deve corrispondere a un database realmente creato nel DBMS.

## 3.7 Primo avvio

In un terminale:

```bash
php artisan serve
```

In un altro terminale:

```bash
npm run dev
```

Apri il browser su:

```txt
http://127.0.0.1:8000
```

## 3.8 Primo commit Git

```bash
git init
git add .
git commit -m "nuovo progetto laravel"
```

Salva lo stato iniziale del progetto. Questo è utile per confrontare tutto ciò che verrà generato dopo.

---

# 4. Git workflow consigliato

## 4.1 Commit piccoli

Ogni commit dovrebbe rappresentare una sola modifica logica.

Esempi buoni:

```bash
git commit -m "add breeze and bootstrap"
git commit -m "create Project model"
git commit -m "add projects resource routes"
git commit -m "add image upload in project form"
```

Esempi meno buoni:

```bash
git commit -m "varie"
git commit -m "fix"
git commit -m "aggiornamenti"
```

## 4.2 Branch di prova

```bash
git checkout -b prova-breeze
```

Crea un ramo per testare comandi che potrebbero modificare molti file.

Tornare al ramo principale:

```bash
git checkout master
```

oppure:

```bash
git checkout main
```

## 4.3 Tornare indietro a un commit pulito

Se hai modifiche non committate e vuoi scartarle:

```bash
git reset --hard HEAD
```

Se vuoi tornare a un commit specifico:

```bash
git reset --hard codice_commit
```

Attenzione: `reset --hard` cancella le modifiche locali non salvate.

## 4.4 Leggere la cronologia

```bash
git log --oneline --reverse
```

Mostra i commit in ordine dal più vecchio al più recente.

```bash
git diff commit1..commit2
```

Mostra le differenze tra due commit.

```bash
git diff --name-status commit1..commit2
```

Mostra solo la lista dei file cambiati.

---

# 5. Frontend: Vite, Sass e Bootstrap

## 5.1 Problema reale: Vite 8 incompatibile

Nel progetto è emerso questo errore:

```txt
npm error ERESOLVE could not resolve
Found: vite@8.0.14
peer vite ^5.0.0 || ^6.0.0 from laravel-vite-plugin@1.3.0
```

Significa che `laravel-vite-plugin` accettava Vite 5 o 6, ma il progetto aveva Vite 8.

Soluzione usata:

```json
"vite": "^6.0.0"
```

Poi pulizia e reinstallazione:

Windows PowerShell:

```powershell
Remove-Item -Recurse -Force node_modules
Remove-Item -Force package-lock.json
npm install
```

macOS/Linux/Git Bash:

```bash
rm -rf node_modules package-lock.json
npm install
```

## 5.2 Versioni finali package.json

Versioni rilevanti del progetto finale:

```json
{
  "scripts": {
    "dev": "vite",
    "build": "vite build"
  },
  "devDependencies": {
    "autoprefixer": "^10.4.2",
    "axios": "^1.6.4",
    "laravel-vite-plugin": "^1.0",
    "sass": "^1.93.3",
    "vite": "^6.0.0"
  },
  "dependencies": {
    "@popperjs/core": "^2.11.8",
    "bootstrap": "^5.3.8",
    "bootstrap-icons": "^1.13.1"
  }
}
```

## 5.3 Installare Bootstrap e Bootstrap Icons

```bash
npm install bootstrap @popperjs/core bootstrap-icons
```

- `bootstrap`: framework CSS/JS.
- `@popperjs/core`: necessario per dropdown, tooltip, popover.
- `bootstrap-icons`: set di icone Bootstrap.

## 5.4 Configurare `resources/scss/app.scss`

Nel progetto finale:

```scss
@import "~bootstrap/scss/bootstrap";

img {
    max-width: 300px !important;
}
```

Questa riga importa Bootstrap nel file Sass principale.

## 5.5 Configurare `resources/js/app.js`

Nel progetto finale:

```js
import "./bootstrap";
import "~icons/bootstrap-icons.scss";
import * as bootstrap from "bootstrap";
import.meta.glob(["../img/**"]);
```

Spiegazione:

- importa bootstrap JS dell'app;
- importa icone Bootstrap;
- rende disponibili componenti JS Bootstrap;
- include asset immagini gestiti da Vite.

## 5.6 Usare Vite nel layout Blade

Nel layout admin finale:

```blade
@vite(['resources/scss/app.scss', 'resources/js/app.js'])
```

Questa direttiva dice a Laravel di caricare asset compilati da Vite.

---

# 6. Breeze + Bootstrap authentication

## 6.1 Installare Breeze

```bash
composer require laravel/breeze --dev
```

Installa Breeze come dipendenza dev.

```bash
php artisan breeze:install blade
```

Genera scaffolding auth con Blade.

Nel tuo caso non ha chiesto PHPUnit/Pest: va bene. Il progetto finale usa PHPUnit.

## 6.2 Installare preset Bootstrap

```bash
composer require pacificdev/laravel_9_preset
```

Installa il pacchetto del preset usato nel corso.

```bash
php artisan preset:ui bootstrap --auth
```

Converte/genera auth UI in Bootstrap.

Poi:

```bash
npm install
npm run dev
php artisan migrate
```

## 6.3 Cosa introduce Breeze

Breeze introduce tipicamente:

```txt
app/Http/Controllers/Auth/
app/Http/Requests/Auth/LoginRequest.php
app/Http/Controllers/ProfileController.php
app/Http/Requests/ProfileUpdateRequest.php
resources/views/auth/
resources/views/profile/
resources/views/dashboard.blade.php
routes/auth.php
tests/Feature/Auth/
tests/Feature/ProfileTest.php
```

Introduce anche rotte per:

- login;
- logout;
- registrazione;
- reset password;
- verifica email;
- profilo utente.

## 6.4 Cosa introduce il preset Bootstrap

Il preset Bootstrap serve per avere view auth già in Bootstrap, evitando di convertire manualmente classi Tailwind.

Nel progetto finale si lavora con:

```txt
resources/scss/app.scss
resources/js/app.js
resources/views/layouts/app.blade.php
resources/views/auth/
```

## 6.5 PHPUnit e Pest

Per controllare se Pest è installato:

```bash
composer show pestphp/pest
```

Se dice `package not found`, non è installato.

Per controllare PHPUnit:

```bash
dir phpunit.xml
```

oppure:

```bash
ls phpunit.xml
```

Eseguire test:

```bash
php artisan test
```

## 6.6 Migration auth

Laravel 11 include migration base:

```txt
0001_01_01_000000_create_users_table.php
0001_01_01_000001_create_cache_table.php
0001_01_01_000002_create_jobs_table.php
```

Breeze usa tabella `users` per autenticazione.

## 6.7 Rotte auth

Nel file `routes/web.php` va lasciato:

```php
require __DIR__.'/auth.php';
```

Questa riga importa le rotte definite in `routes/auth.php`.

---

# 7. MVC: flusso mentale Laravel

## 7.1 Route

La route intercetta un URL.

```php
Route::get('/', function () {
    return view('welcome');
});
```

Oppure collega URL a controller:

```php
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
```

## 7.2 Controller

Il controller contiene la logica.

```php
public function index()
{
    $projects = Project::all();
    return view('crud.projects-index', compact('projects'));
}
```

## 7.3 Model

Il model rappresenta una tabella e permette di interrogare il database.

```php
$projects = Project::all();
```

## 7.4 Migration

La migration definisce struttura database.

```php
Schema::create('projects', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->timestamps();
});
```

## 7.5 Seeder

Il seeder popola il database con dati iniziali o finti.

```php
$newProject = new Project();
$newProject->name = fake()->sentence(3);
$newProject->save();
```

## 7.6 View Blade

La view mostra HTML.

```blade
@foreach ($projects as $project)
    <h2>{{ $project->name }}</h2>
@endforeach
```

## 7.7 Componenti Blade

I componenti permettono di riusare markup.

```blade
<x-modal />
```

---

# 8. Layout, partials e Blade

## 8.1 Layout app

`resources/views/layouts/app.blade.php` è il layout base generato/gestito dalla parte auth.

Contiene:

```blade
<title>{{ config('app.name', 'Laravel') }}</title>
```

Questa è una buona pratica: il nome app arriva da `.env` tramite `config/app.php`, non è hardcoded.

In `.env`:

```env
APP_NAME="Laravel Portfolio"
```

## 8.2 Layout admin

Nel progetto finale è stato creato un layout admin:

```txt
resources/views/layouts/admin.blade.php
```

Esempio:

```blade
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        @include('partials.header')
        <main>
            <div class="container py-4">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
```

## 8.3 Header partial

La navbar è stata spostata in:

```txt
resources/views/partials/header.blade.php
```

Questa scelta è utile perché mantiene il layout più pulito.

Inclusione:

```blade
@include('partials.header')
```

## 8.4 `@yield`, `@section`, `@extends`

Nel layout:

```blade
@yield('content')
```

Nella view figlia:

```blade
@extends('layouts.admin')

@section('content')
    <h1>Admin homepage</h1>
@endsection
```

## 8.5 `@include`

```blade
@include('partials.header')
```

Include un file Blade parziale.

Laravel cerca:

```txt
resources/views/partials/header.blade.php
```

## 8.6 `@guest`, `@auth`, `Auth::user()`

Nel menu auth:

```blade
@guest
    <a href="{{ route('login') }}">Login</a>
@else
    {{ Auth::user()->name }}
@endguest
```

- `@guest`: utente non loggato.
- `@auth`: utente loggato.
- `Auth::user()`: oggetto utente autenticato.

## 8.7 Active link nella navbar

Nel progetto:

```blade
<a class="nav-link {{ request()->routeIs('types.*') ? 'active' : '' }}" href="{{ route('types.index') }}">
    Types
</a>
```

`request()->routeIs('types.*')` restituisce true se la rotta corrente inizia con `types.`.

## 8.8 CSRF nei form

Ogni form POST/PATCH/DELETE deve contenere:

```blade
@csrf
```

Protegge da attacchi Cross-Site Request Forgery.

## 8.9 Method spoofing PUT/PATCH/DELETE

HTML supporta solo GET e POST. Laravel simula altri metodi così:

```blade
@method('PUT')
```

oppure:

```blade
@method('DELETE')
```

Esempio delete:

```blade
<form action="{{ route('projects.destroy', $project) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit">Delete</button>
</form>
```

---

# 9. Area admin protetta

## 9.1 Creare DashboardController

```bash
php artisan make:controller Admin/DashboardController
```

Crea:

```txt
app/Http/Controllers/Admin/DashboardController.php
```

Esempio:

```php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.homepage');
    }
}
```

## 9.2 Rotte admin con prefix, name e middleware

Nel progetto finale:

```php
Route::middleware(['auth', 'verified'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
    });
```

Spiegazione:

- `middleware(['auth', 'verified'])`: solo utenti loggati e verificati.
- `prefix('admin')`: URL iniziano con `/admin`.
- `name('admin.')`: nomi rotte iniziano con `admin.`.
- `name('index')`: nome finale `admin.index`.

## 9.3 View homepage admin

File:

```txt
resources/views/admin/homepage.blade.php
```

Esempio:

```blade
@extends('layouts.admin')

@section('content')
    <h1>Admin homepage</h1>
@endsection
```

---

# 10. Entità Project

## 10.1 Creare model Project

```bash
php artisan make:model Project
```

Crea:

```txt
app/Models/Project.php
```

Variante consigliata quando sai già che serve migration:

```bash
php artisan make:model Project -m
```

## 10.2 Creare migration projects

```bash
php artisan make:migration create_projects_table
```

Crea un file in:

```txt
database/migrations/
```

## 10.3 Struttura tabella projects

Migration finale:

```php
Schema::create('projects', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('customer');
    $table->text('description');
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->timestamps();
});
```

Eseguire:

```bash
php artisan migrate
```

## 10.4 Creare seeder ProjectsTableSeeder

```bash
php artisan make:seeder ProjectsTableSeeder
```

Crea:

```txt
database/seeders/ProjectsTableSeeder.php
```

## 10.5 Faker nel ProjectsTableSeeder

Nel portfolio finale Faker viene iniettato nel metodo `run`:

```php
use Faker\Generator as Faker;

public function run(Faker $faker): void
{
    for ($i = 0; $i < 10; $i++) {
        $startDate = $faker->dateTimeBetween('-2 years', 'now');
        $endDate = $faker->dateTimeBetween($startDate, '+6 months');

        $newProject = new Project();
        $newProject->name = $faker->sentence(3);
        $newProject->type_id = rand(1, 8);
        $newProject->customer = $faker->company();
        $newProject->description = $faker->paragraph(5);
        $newProject->start_date = $startDate;
        $newProject->end_date = $endDate;
        $newProject->save();
    }
}
```

Faker serve a generare dati realistici ma finti.

## 10.6 Registrare seeder in DatabaseSeeder

File:

```txt
database/seeders/DatabaseSeeder.php
```

Esempio:

```php
public function run(): void
{
    $this->call([
        TypesTableSeeder::class,
        TechnologiesTableSeeder::class,
        ProjectsTableSeeder::class,
    ]);
}
```

L'ordine è importante: prima `Type` e `Technology`, poi `Project`, perché i progetti usano `type_id` e tecnologie.

Eseguire:

```bash
php artisan db:seed
```

oppure reset completo:

```bash
php artisan migrate:fresh --seed
```

## 10.7 Creare ProjectController resource

```bash
php artisan make:controller Admin/ProjectController --resource
```

Crea controller con metodi:

```txt
index
create
store
show
edit
update
destroy
```

## 10.8 Route resource projects

In `routes/web.php`:

```php
use App\Http\Controllers\Admin\ProjectController;

Route::resource('projects', ProjectController::class)
    ->middleware(['auth', 'verified']);
```

Genera automaticamente rotte CRUD.

Controlla con:

```bash
php artisan route:list
```

## 10.9 Index projects

Controller:

```php
public function index()
{
    $projects = Project::all();
    return view('crud.projects-index', compact('projects'));
}
```

View:

```txt
resources/views/crud/projects-index.blade.php
```

## 10.10 Show project

Controller con Route Model Binding:

```php
public function show(Project $project)
{
    return view('crud.projects-show', compact('project'));
}
```

Laravel riceve `{project}` dalla rotta e recupera automaticamente il model.

## 10.11 Create e store project

`create` mostra il form:

```php
public function create()
{
    $types = Type::all();
    $technologies = Technology::all();

    return view('crud.projects-create', compact('types', 'technologies'));
}
```

`store` salva:

```php
public function store(Request $request)
{
    $data = $request->all();

    $newProject = new Project();
    $newProject->name = $data['name'];
    $newProject->type_id = $data['type_id'];
    $newProject->customer = $data['customer'];
    $newProject->description = $data['description'];
    $newProject->start_date = $data['start_date'];
    $newProject->end_date = $data['end_date'];
    $newProject->save();

    if ($request->has('technologies')) {
        $newProject->technologies()->attach($data['technologies']);
    }

    return redirect()->route('projects.show', $newProject);
}
```

## 10.12 Edit e update project

`edit` mostra form precompilato:

```php
public function edit(Project $project)
{
    $types = Type::all();
    $technologies = Technology::all();

    return view('crud.projects-edit', compact('project', 'types', 'technologies'));
}
```

`update` modifica record:

```php
public function update(Request $request, Project $project)
{
    $data = $request->all();

    $project->name = $data['name'];
    $project->type_id = $data['type_id'];
    $project->customer = $data['customer'];
    $project->description = $data['description'];
    $project->start_date = $data['start_date'];
    $project->end_date = $data['end_date'];

    $project->update();

    if ($request->has('technologies')) {
        $project->technologies()->sync($data['technologies']);
    } else {
        $project->technologies()->detach();
    }

    return redirect()->route('projects.show', $project);
}
```

## 10.13 Destroy project

```php
public function destroy(Project $project)
{
    $project->delete();

    return redirect()->route('projects.index');
}
```

Nel progetto finale, prima di eliminare il progetto viene eliminata anche l'immagine associata.

## 10.14 Modal di cancellazione

Il progetto usa una modal per confermare la cancellazione.

File rilevanti:

```txt
resources/views/crud/modal.blade.php
resources/views/components/modal.blade.php
app/View/Components/Modal.php
```

Uso tipico: evitare delete immediata e chiedere conferma all'utente.

---

# 11. Entità Type e relazione 1:N

## 11.1 Creare Type model e migration

```bash
php artisan make:model Type -m
```

Crea:

```txt
app/Models/Type.php
database/migrations/..._create_types_table.php
```

## 11.2 Migration types

```php
Schema::create('types', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description')->nullable();
    $table->timestamps();
});
```

## 11.3 Aggiungere type_id a projects

```bash
php artisan make:migration add_type_id_to_projects_table --table=projects
```

Migration:

```php
Schema::table('projects', function (Blueprint $table) {
    $table->foreignId('type_id')
        ->nullable()
        ->after('name')
        ->constrained()
        ->nullOnDelete();
});
```

Rollback:

```php
Schema::table('projects', function (Blueprint $table) {
    $table->dropForeign(['type_id']);
    $table->dropColumn('type_id');
});
```

Spiegazione:

- `foreignId('type_id')`: crea colonna unsigned big integer per foreign key.
- `nullable()`: un progetto può non avere tipo.
- `constrained()`: collega automaticamente a `types.id`.
- `nullOnDelete()`: se il type viene cancellato, `type_id` diventa null.

## 11.4 Relazione Project belongsTo Type

Nel model dipendente `Project`:

```php
public function type()
{
    return $this->belongsTo(Type::class);
}
```

Un progetto appartiene a un solo tipo.

## 11.5 Relazione Type hasMany Projects

Nel model indipendente `Type`:

```php
public function projects()
{
    return $this->hasMany(Project::class);
}
```

Un tipo può avere molti progetti.

## 11.6 TypesTableSeeder

```php
use Faker\Generator as Faker;

public function run(Faker $faker): void
{
    $types = [
        'Web Design',
        'UI/UX Design',
        'Front End Development',
        'Back End Development',
        'Full Stack Development',
        'Graphic Design',
        'Mobile Development',
        'E-Commerce',
    ];

    foreach ($types as $type) {
        $newType = new Type();
        $newType->name = $type;
        $newType->description = $faker->sentence();
        $newType->save();
    }
}
```

## 11.7 TypeController resource

```bash
php artisan make:controller Admin/TypeController --resource
```

Metodi principali:

```php
public function index()
{
    $types = Type::all();
    return view('crud.types-index', compact('types'));
}

public function create()
{
    return view('crud.types-create');
}

public function store(Request $request)
{
    $data = $request->all();

    $newType = new Type();
    $newType->name = $data['name'];
    $newType->description = $data['description'];
    $newType->save();

    return redirect()->route('types.show', $newType);
}
```

## 11.8 Route resource types

```php
Route::resource('types', TypeController::class)
    ->middleware(['auth', 'verified']);
```

## 11.9 Select type nel form project

Nel form create/edit project:

```blade
<select name="type_id" class="form-select">
    @foreach ($types as $type)
        <option value="{{ $type->id }}">
            {{ $type->name }}
        </option>
    @endforeach
</select>
```

In edit, selezionare quello già associato:

```blade
<option value="{{ $type->id }}" {{ $project->type_id == $type->id ? 'selected' : '' }}>
    {{ $type->name }}
</option>
```

---

# 12. Entità Technology e relazione N:N

## 12.1 Creare Technology model e migration

```bash
php artisan make:model Technology -m
```

## 12.2 Migration technologies

```php
Schema::create('technologies', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('color', 7);
    $table->timestamps();
});
```

`color` contiene un valore esadecimale tipo `#ff0000`.

## 12.3 Pivot project_technology

```bash
php artisan make:migration create_project_technology_table
```

Migration finale:

```php
Schema::create('project_technology', function (Blueprint $table) {
    $table->id();
    $table->foreignId('project_id')->constrained()->cascadeOnDelete();
    $table->foreignId('technology_id')->constrained()->cascadeOnDelete();
    $table->timestamps();
});
```

Spiegazione:

- nome tabella pivot in ordine alfabetico singolare: `project_technology`;
- `cascadeOnDelete()`: se elimino project o technology, elimina righe pivot collegate;
- `timestamps()`: consente `withTimestamps()` nei model.

## 12.4 Relazioni belongsToMany

In `Project.php`:

```php
public function technologies()
{
    return $this->belongsToMany(Technology::class)->withTimestamps();
}
```

In `Technology.php`:

```php
public function projects()
{
    return $this->belongsToMany(Project::class)->withTimestamps();
}
```

## 12.5 TechnologiesTableSeeder

```php
use Faker\Generator as Faker;

public function run(Faker $faker): void
{
    $technologies = [
        'HTML',
        'CSS',
        'Bootstrap',
        'JavaScript',
        'Vue.js',
        'React',
        'PHP',
        'Laravel',
        'MySQL',
        'Docker',
    ];

    foreach ($technologies as $technology) {
        $newTech = new Technology();
        $newTech->name = $technology;
        $newTech->color = $faker->hexColor();
        $newTech->save();
    }
}
```

## 12.6 Seeder pivot tramite attach

Nel seeder dei progetti:

```php
$technologies = Technology::inRandomOrder()
    ->limit(rand(1, 4))
    ->pluck('id');

$newProject->technologies()->attach($technologies);
```

Spiegazione:

- prende tecnologie casuali;
- estrae solo gli id;
- collega il progetto alle tecnologie nella pivot.

## 12.7 TechnologyController resource

```bash
php artisan make:controller Admin/TechnologyController --resource
```

Store:

```php
public function store(Request $request)
{
    $data = $request->all();

    $newTech = new Technology();
    $newTech->name = $data['name'];
    $newTech->color = $data['color'];
    $newTech->save();

    return redirect()->route('technologies.show', $newTech);
}
```

## 12.8 Route resource technologies

```php
Route::resource('technologies', TechnologyController::class)
    ->middleware(['auth', 'verified']);
```

## 12.9 Checkbox technologies nel form project

Create:

```blade
@foreach ($technologies as $technology)
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="technologies[]" value="{{ $technology->id }}">
        <label class="form-check-label">
            {{ $technology->name }}
        </label>
    </div>
@endforeach
```

Edit con checkbox già selezionate:

```blade
@foreach ($technologies as $technology)
    <input
        type="checkbox"
        name="technologies[]"
        value="{{ $technology->id }}"
        {{ $project->technologies->contains($technology->id) ? 'checked' : '' }}
    >
@endforeach
```

## 12.10 `attach`, `sync`, `detach`

```php
$newProject->technologies()->attach($data['technologies']);
```

Aggiunge collegamenti senza rimuovere eventuali precedenti.

```php
$project->technologies()->sync($data['technologies']);
```

Aggiorna l'elenco: aggiunge quelli nuovi e rimuove quelli non presenti.

```php
$project->technologies()->detach();
```

Rimuove tutti i collegamenti dalla pivot.

---

# 13. Database, migration, seeder e Faker

## 13.1 Migration: cosa sono

Le migration sono file PHP versionati che descrivono modifiche al database.

Servono a rendere ripetibile la creazione delle tabelle.

## 13.2 Comandi migration

```bash
php artisan make:migration create_projects_table
```

Crea migration.

```bash
php artisan migrate
```

Esegue migration non ancora applicate.

```bash
php artisan migrate:rollback
```

Annulla ultimo batch.

```bash
php artisan migrate:fresh
```

Cancella tutto e ricrea.

```bash
php artisan migrate:fresh --seed
```

Cancella tutto, ricrea e popola.

## 13.3 Seeder: cosa sono

I seeder inseriscono dati nel database.

Uso tipico:

- dati finti in sviluppo;
- dati iniziali obbligatori;
- categorie, ruoli, tecnologie, stati.

## 13.4 Comandi seeder

```bash
php artisan make:seeder NomeSeeder
```

Crea seeder.

```bash
php artisan db:seed
```

Esegue `DatabaseSeeder`.

```bash
php artisan db:seed --class=NomeSeeder
```

Esegue solo un seeder.

## 13.5 Registrare più seeder in DatabaseSeeder

```php
public function run(): void
{
    $this->call([
        TypesTableSeeder::class,
        TechnologiesTableSeeder::class,
        ProjectsTableSeeder::class,
    ]);
}
```

Se un seeder dipende dai dati di un altro, l'ordine è fondamentale.

## 13.6 Ordine dei seeder

Nel portfolio:

1. `TypesTableSeeder`: crea tipi;
2. `TechnologiesTableSeeder`: crea tecnologie;
3. `ProjectsTableSeeder`: crea progetti e associa type/technologies.

Se inverti l'ordine, `ProjectsTableSeeder` può provare ad associare record inesistenti.

## 13.7 Faker: cosa fa

Faker genera dati casuali ma plausibili.

Esempi:

```php
$faker->sentence(3);
$faker->paragraph(5);
$faker->company();
$faker->hexColor();
$faker->dateTimeBetween('-2 years', 'now');
```

Oppure helper moderno:

```php
fake()->sentence(3);
fake()->company();
```

## 13.8 Faker con dependency injection

Nel seeder:

```php
use Faker\Generator as Faker;

public function run(Faker $faker): void
{
    $name = $faker->sentence(3);
}
```

Laravel risolve automaticamente `$faker` dal service container.

## 13.9 Factory: extra utile

Nel portfolio è stato usato Faker direttamente nei seeder. In progetti più grandi puoi usare Factory.

Creare factory:

```bash
php artisan make:factory ProjectFactory --model=Project
```

Esempio:

```php
public function definition(): array
{
    return [
        'name' => fake()->sentence(3),
        'customer' => fake()->company(),
        'description' => fake()->paragraph(5),
        'start_date' => fake()->date(),
        'end_date' => fake()->optional()->date(),
    ];
}
```

Nel model serve trait:

```php
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
}
```

Uso nel seeder:

```php
Project::factory()->count(10)->create();
```

## 13.10 Seeder vs Factory

- **Seeder:** decide cosa inserire e in che ordine.
- **Factory:** descrive come generare un singolo record finto.

In pratica:

```txt
Seeder = orchestratore
Factory = generatore di record
```

---

# 14. CRUD Resource completo

## 14.1 Tabella azioni resource

`Route::resource('projects', ProjectController::class)` genera:

| Metodo HTTP | URL | Nome rotta | Metodo controller | Scopo |
|---|---|---|---|---|
| GET | `/projects` | `projects.index` | `index` | lista |
| GET | `/projects/create` | `projects.create` | `create` | form creazione |
| POST | `/projects` | `projects.store` | `store` | salva nuovo |
| GET | `/projects/{project}` | `projects.show` | `show` | dettaglio |
| GET | `/projects/{project}/edit` | `projects.edit` | `edit` | form modifica |
| PUT/PATCH | `/projects/{project}` | `projects.update` | `update` | aggiorna |
| DELETE | `/projects/{project}` | `projects.destroy` | `destroy` | elimina |

## 14.2 `index`

```php
public function index()
{
    $projects = Project::all();
    return view('crud.projects-index', compact('projects'));
}
```

Mostra elenco record.

## 14.3 `create`

```php
public function create()
{
    return view('crud.projects-create');
}
```

Mostra form vuoto.

## 14.4 `store`

```php
public function store(Request $request)
{
    $data = $request->all();
    // crea model
    // salva
    return redirect()->route('projects.show', $newProject);
}
```

Riceve dati dal form e salva.

## 14.5 `show`

```php
public function show(Project $project)
{
    return view('crud.projects-show', compact('project'));
}
```

Mostra dettaglio.

## 14.6 `edit`

```php
public function edit(Project $project)
{
    return view('crud.projects-edit', compact('project'));
}
```

Mostra form precompilato.

## 14.7 `update`

```php
public function update(Request $request, Project $project)
{
    $data = $request->all();
    // aggiorna model
    $project->update();
    return redirect()->route('projects.show', $project);
}
```

Aggiorna record esistente.

## 14.8 `destroy`

```php
public function destroy(Project $project)
{
    $project->delete();
    return redirect()->route('projects.index');
}
```

Elimina record.

## 14.9 Redirect con route name

```php
return redirect()->route('projects.show', $project);
```

Meglio di scrivere URL manuali perché se cambia la rotta, il nome resta gestibile.

## 14.10 Route model binding

Invece di:

```php
public function show($id)
{
    $project = Project::find($id);
}
```

usa:

```php
public function show(Project $project)
{
    // $project è già recuperato
}
```

Laravel associa `{project}` al model `Project`.

---

# 15. Validazione e Form Request

Nel portfolio finale la validazione non è stata portata al livello più avanzato in ogni punto, ma per un template riusabile conviene conoscerla e usarla.

## 15.1 Validazione inline nel controller

```php
$data = $request->validate([
    'name' => 'required|string|max:255',
    'customer' => 'required|string|max:255',
    'description' => 'required|string',
    'start_date' => 'required|date',
    'end_date' => 'nullable|date|after_or_equal:start_date',
]);
```

`validate()` valida e restituisce solo dati validati.

## 15.2 Creare Form Request

```bash
php artisan make:request StoreProjectRequest
php artisan make:request UpdateProjectRequest
```

Crea file in:

```txt
app/Http/Requests/
```

## 15.3 Regole StoreProjectRequest

```php
public function authorize(): bool
{
    return true;
}

public function rules(): array
{
    return [
        'name' => 'required|string|max:255',
        'type_id' => 'nullable|exists:types,id',
        'customer' => 'required|string|max:255',
        'description' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'technologies' => 'nullable|array',
        'technologies.*' => 'exists:technologies,id',
        'image' => 'nullable|image|max:2048',
    ];
}
```

Nel controller:

```php
public function store(StoreProjectRequest $request)
{
    $data = $request->validated();
}
```

## 15.4 Regole UpdateProjectRequest

Spesso simili allo store:

```php
public function rules(): array
{
    return [
        'name' => 'required|string|max:255',
        'type_id' => 'nullable|exists:types,id',
        'customer' => 'required|string|max:255',
        'description' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'technologies' => 'nullable|array',
        'technologies.*' => 'exists:technologies,id',
        'image' => 'nullable|image|max:2048',
    ];
}
```

## 15.5 Messaggi di errore Blade

Singolo campo:

```blade
@error('name')
    <div class="text-danger">{{ $message }}</div>
@enderror
```

Tutti gli errori:

```blade
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
```

Valore precedente dopo errore:

```blade
<input type="text" name="name" value="{{ old('name', $project->name ?? '') }}">
```

## 15.6 Mass assignment e fillable

Se vuoi usare:

```php
Project::create($data);
$project->update($data);
```

nel model devi definire:

```php
protected $fillable = [
    'name',
    'type_id',
    'customer',
    'description',
    'start_date',
    'end_date',
    'image',
];
```

`$fillable` protegge da assegnazione massiva indesiderata.

Nel portfolio si è usato spesso assegnamento manuale campo per campo, quindi `$fillable` non era strettamente necessario.

---

# 16. Upload immagini e Storage

## 16.1 Configurare FILESYSTEM_DISK

Nel progetto finale `config/filesystems.php` usa default pubblico:

```php
'default' => env('FILESYSTEM_DISK', 'public'),
```

In `.env`:

```env
FILESYSTEM_DISK=public
```

Così `Storage::putFile()` salva su disco pubblico.

## 16.2 Creare storage link

```bash
php artisan storage:link
```

Crea:

```txt
public/storage -> storage/app/public
```

Senza questo link, le immagini salvate non sono visibili dal browser.

## 16.3 Aggiungere colonna image

```bash
php artisan make:migration add_image_to_projects_table --table=projects
```

Migration:

```php
Schema::table('projects', function (Blueprint $table) {
    $table->text('image')->nullable()->after('end_date');
});
```

Rollback:

```php
Schema::table('projects', function (Blueprint $table) {
    $table->dropColumn('image');
});
```

## 16.4 Form con enctype

Per upload file, il form deve avere:

```blade
<form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
```

Senza `enctype="multipart/form-data"`, il file non arriva correttamente al backend.

## 16.5 Input file

```blade
<input type="file" name="image" class="form-control">
```

## 16.6 Salvare immagine in store

Nel progetto:

```php
if (array_key_exists('image', $data)) {
    $img_url = Storage::putFile('projects', $data['image']);
    $newProject->image = $img_url;
}
```

Versione più robusta:

```php
if ($request->hasFile('image')) {
    $img_url = Storage::putFile('projects', $request->file('image'));
    $newProject->image = $img_url;
}
```

`Storage::putFile('projects', ...)` salva il file in una sottocartella `projects` del disco configurato.

## 16.7 Mostrare immagine in Blade

```blade
@if ($project->image)
    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}">
@endif
```

Oppure:

```blade
<img src="{{ Storage::url($project->image) }}" alt="{{ $project->name }}">
```

Se usi `Storage::url()`, importa/fai riferimento corretto alla facade se serve.

## 16.8 Sostituire immagine in update

Nel progetto:

```php
if (array_key_exists('image', $data)) {
    if ($project->image) {
        Storage::delete($project->image);
    }

    $img_url = Storage::putFile('projects', $data['image']);
    $project->image = $img_url;
}
```

Versione robusta:

```php
if ($request->hasFile('image')) {
    if ($project->image) {
        Storage::delete($project->image);
    }

    $project->image = Storage::putFile('projects', $request->file('image'));
}
```

## 16.9 Cancellare immagine in destroy

```php
public function destroy(Project $project)
{
    if ($project->image) {
        Storage::delete($project->image);
    }

    $project->delete();

    return redirect()->route('projects.index');
}
```

Così eviti file orfani nello storage.

## 16.10 Validare immagini

```php
'image' => 'nullable|image|max:2048'
```

Spiegazione:

- `nullable`: campo non obbligatorio;
- `image`: deve essere immagine valida;
- `max:2048`: massimo 2 MB.

---

# 17. API pubblica

## 17.1 Installare API scaffolding

```bash
php artisan install:api
```

In Laravel 11 installa/configura API route file e Sanctum.

Nel progetto finale ha introdotto anche migration:

```txt
create_personal_access_tokens_table.php
```

## 17.2 Sanctum e personal access tokens

Sanctum serve per autenticazione API token-based o SPA. Nel portfolio l'API è pubblica, quindi non richiede token, ma Sanctum viene installato dallo scaffolding API.

Eseguire migration dopo installazione:

```bash
php artisan migrate
```

## 17.3 Creare Api ProjectController

```bash
php artisan make:controller Api/ProjectController
```

Crea:

```txt
app/Http/Controllers/Api/ProjectController.php
```

## 17.4 Rotte API

File:

```txt
routes/api.php
```

Rotte finali:

```php
use App\Http\Controllers\Api\ProjectController;

Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{project}', [ProjectController::class, 'show']);
```

URL tipici:

```txt
/api/projects
/api/projects/1
```

## 17.5 Risposta JSON index

```php
public function index()
{
    $projects = Project::with('type', 'technologies')->get();

    return response()->json([
        'success' => true,
        'data' => $projects,
    ]);
}
```

## 17.6 Risposta JSON show

```php
public function show(Project $project)
{
    $project->load('type', 'technologies');

    return response()->json([
        'success' => true,
        'data' => $project,
    ]);
}
```

## 17.7 Eager loading con `with` e `load`

```php
Project::with('type', 'technologies')->get();
```

Carica relazioni insieme alla query iniziale.

```php
$project->load('type', 'technologies');
```

Carica relazioni su un model già esistente.

Serve a evitare il problema N+1.

## 17.8 CORS

File:

```txt
config/cors.php
```

Nel progetto:

```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_methods' => ['*'],
'allowed_origins' => [
    'http://localhost:5174',
],
'allowed_headers' => ['*'],
```

Serve a permettere a un frontend esterno, ad esempio Vue su porta 5174, di chiamare le API Laravel.

---

# 18. Middleware e protezione rotte

## 18.1 `auth`

```php
->middleware('auth')
```

Permette accesso solo a utenti loggati.

## 18.2 `verified`

```php
->middleware(['auth', 'verified'])
```

Permette accesso solo a utenti loggati con email verificata.

## 18.3 Middleware su gruppo

```php
Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
    });
```

Tutte le rotte nel gruppo ereditano middleware, prefix e name.

## 18.4 Middleware su resource

```php
Route::resource('projects', ProjectController::class)
    ->middleware(['auth', 'verified']);
```

Tutte le rotte resource `projects.*` sono protette.

---

# 19. Eloquent: query e relazioni

## 19.1 Query base

```php
Project::all();
```

Tutti i record.

```php
Project::find($id);
```

Record per ID o `null`.

```php
Project::where('customer', 'ACME')->get();
```

Filtra.

```php
Project::orderBy('name', 'asc')->get();
```

Ordina.

```php
Project::limit(10)->get();
```

Limita risultati.

## 19.2 Collection vs model singolo

Restituiscono collection:

```php
Project::all();
Project::get();
```

Restituiscono model singolo:

```php
Project::first();
Project::find($id);
```

## 19.3 `with` per evitare N+1

Problema N+1: cicli sui progetti e per ogni progetto Laravel fa query extra per type/technologies.

Soluzione:

```php
$projects = Project::with('type', 'technologies')->get();
```

## 19.4 Relazioni nullable e `nullOnDelete`

```php
$table->foreignId('type_id')
    ->nullable()
    ->constrained()
    ->nullOnDelete();
```

Se cancello un type, i project restano ma `type_id` diventa `NULL`.

## 19.5 Cascade delete sulla pivot

```php
$table->foreignId('project_id')->constrained()->cascadeOnDelete();
$table->foreignId('technology_id')->constrained()->cascadeOnDelete();
```

Se elimino un progetto o una tecnologia, le righe pivot relative vengono eliminate.

---

# 20. Componenti Blade e riuso markup

## 20.1 Creare component

```bash
php artisan make:component Modal
```

Crea:

```txt
app/View/Components/Modal.php
resources/views/components/modal.blade.php
```

## 20.2 Slot

Uso:

```blade
<x-modal>
    Contenuto modal
</x-modal>
```

Nel componente:

```blade
<div class="modal">
    {{ $slot }}
</div>
```

## 20.3 Props

Uso:

```blade
<x-modal title="Conferma eliminazione" />
```

Nel componente:

```blade
@props(['title'])

<h5>{{ $title }}</h5>
```

## 20.4 Component modal

Una modal è utile per confermare azioni distruttive.

Pattern:

- bottone apre modal;
- modal contiene form DELETE;
- form contiene `@csrf` e `@method('DELETE')`.

---

# 21. Troubleshooting

## 21.1 Errore npm ERESOLVE Vite

Errore:

```txt
Found: vite@8.0.14
peer vite ^5.0.0 || ^6.0.0 from laravel-vite-plugin
```

Soluzione:

1. Modifica `package.json`:

```json
"vite": "^6.0.0"
```

2. Pulisci e reinstalla:

```powershell
Remove-Item -Recurse -Force node_modules
Remove-Item -Force package-lock.json
npm install
```

3. Rilancia:

```bash
npm run dev
```

## 21.2 `.env` mancante

Errore tipico: Laravel non trova configurazioni.

Soluzione:

```bash
copy .env.example .env
php artisan key:generate
```

## 21.3 APP_KEY mancante

Errore tipico: `No application encryption key has been specified`.

Soluzione:

```bash
php artisan key:generate
```

## 21.4 Migration fallite

Controlla:

- database esiste?
- credenziali `.env` corrette?
- MySQL avviato?
- migration in ordine corretto?

Comandi utili:

```bash
php artisan migrate:status
php artisan migrate:fresh --seed
```

## 21.5 Immagini non visibili

Controlla:

```bash
php artisan storage:link
```

Controlla `.env`:

```env
FILESYSTEM_DISK=public
```

Controlla path Blade:

```blade
asset('storage/' . $project->image)
```

## 21.6 Rotte non trovate

Controlla elenco:

```bash
php artisan route:list
```

Pulisci cache:

```bash
php artisan route:clear
```

Controlla `name()` nella route.

## 21.7 Classi non trovate

Esempi:

```txt
Class App\Models\Project not found
```

Soluzioni:

```bash
composer dump-autoload
```

Controlla namespace e `use` nel file PHP.

---

# 22. Sequenza reale dei commit del portfolio

Questa è la ricostruzione logica della cronologia del progetto finale.

## 22.1 Base, Breeze e Bootstrap

```txt
nuovo progetto laravel
add breeze and bootstrap
```

Operazioni:

```bash
composer create-project --prefer-dist laravel/laravel:^11.0 laravel-portfolio
composer require laravel/breeze --dev
php artisan breeze:install blade
composer require pacificdev/laravel_9_preset
php artisan preset:ui bootstrap --auth
npm install
npm run dev
php artisan migrate
```

## 22.2 Admin e Project CRUD

Commit logici:

```txt
add DashboardController
add admin homepage
add admin info and layout
create Project Model
create create_projects_table Migration
create ProjectsTableSeeder Seeder
create ProjectController (--resource) Controller
add projects resource routes
add ProjectController->index
add projects-index view
add ProjectController->show
add projects-show view
add ProjectController->create and store
add projects-create view
add ProjectController->edit and update
add projects-edit view
add ProjectController->destroy
add Delete Project modal
```

## 22.3 Type e relazione 1:N

```txt
add Type entity and relationship with Project
add view and functionalities to handle Projects Type
add crud operations for Type Model
```

Operazioni principali:

```bash
php artisan make:model Type -m
php artisan make:migration add_type_id_to_projects_table --table=projects
php artisan make:seeder TypesTableSeeder
php artisan make:controller Admin/TypeController --resource
```

## 22.4 Technology e relazione N:N

```txt
add Technology model, technologies table and seeder
add ManyToMany relationship
add pivot table
add timestamps handler in pivot table
add onDelete behaviour in pivot table
add initial pivot table seeder
add pivot table handler in ProjectController and in relative views
add crud operations for Technology Model
```

Operazioni principali:

```bash
php artisan make:model Technology -m
php artisan make:migration create_project_technology_table
php artisan make:seeder TechnologiesTableSeeder
php artisan make:controller Admin/TechnologyController --resource
```

## 22.5 API, CORS e upload immagini

```txt
add API with php artisan install:api
add Api/ProjectController
add API: projects index and show
add CORS file
add cors allowed origins
change FILESYSTEM_DISK in public
perform php artisan storage:link, add enctype in creation form, add file input
add image storage in store function
add image column in projects table
add image in show view
add enctype in edit form, add file input
add image substitution in update function
add delete image in destroy function
add max-width to images
```

Operazioni principali:

```bash
php artisan install:api
php artisan make:controller Api/ProjectController
php artisan storage:link
php artisan make:migration add_image_to_projects_table --table=projects
```

---

# 23. Checklist finale per rifare il progetto

## Fase 1 — Progetto base

```bash
composer create-project --prefer-dist laravel/laravel:^11.0 laravel-portfolio
cd laravel-portfolio
npm install
copy .env.example .env
php artisan key:generate
```

Configura `.env`, poi:

```bash
git init
git add .
git commit -m "nuovo progetto laravel"
```

## Fase 2 — Fix Vite se necessario

In `package.json`:

```json
"vite": "^6.0.0"
```

Poi:

```bash
npm install
git add package.json package-lock.json
git commit -m "fix vite compatibility"
```

## Fase 3 — Breeze + Bootstrap

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
composer require pacificdev/laravel_9_preset
php artisan preset:ui bootstrap --auth
npm install
npm run dev
php artisan migrate
```

```bash
git add .
git commit -m "add breeze and bootstrap"
```

## Fase 4 — Admin

```bash
php artisan make:controller Admin/DashboardController
```

Crea layout admin, partial header e rotta admin protetta.

## Fase 5 — Project

```bash
php artisan make:model Project -m
php artisan make:seeder ProjectsTableSeeder
php artisan make:controller Admin/ProjectController --resource
```

Crea migration, seeder, controller, route resource e view CRUD.

## Fase 6 — Type 1:N

```bash
php artisan make:model Type -m
php artisan make:migration add_type_id_to_projects_table --table=projects
php artisan make:seeder TypesTableSeeder
php artisan make:controller Admin/TypeController --resource
```

Aggiungi relazioni e select nei form Project.

## Fase 7 — Technology N:N

```bash
php artisan make:model Technology -m
php artisan make:migration create_project_technology_table
php artisan make:seeder TechnologiesTableSeeder
php artisan make:controller Admin/TechnologyController --resource
```

Aggiungi relazioni, pivot, checkbox e attach/sync/detach.

## Fase 8 — Database seed completo

In `DatabaseSeeder`:

```php
public function run(): void
{
    $this->call([
        TypesTableSeeder::class,
        TechnologiesTableSeeder::class,
        ProjectsTableSeeder::class,
    ]);
}
```

Poi:

```bash
php artisan migrate:fresh --seed
```

## Fase 9 — API

```bash
php artisan install:api
php artisan make:controller Api/ProjectController
```

Definisci rotte in `routes/api.php`.

## Fase 10 — Upload immagini

```bash
php artisan make:migration add_image_to_projects_table --table=projects
php artisan migrate
php artisan storage:link
```

Configura form, store, update, destroy e show.

## Fase 11 — Controlli finali

```bash
php artisan route:list
php artisan test
npm run build
```

---

# 24. Appendice: comandi completi

## 24.1 Composer

```bash
composer install
```

Installa dipendenze da `composer.lock`.

```bash
composer require vendor/package
```

Installa pacchetto.

```bash
composer require vendor/package --dev
```

Installa pacchetto solo in sviluppo.

```bash
composer update
```

Aggiorna dipendenze.

```bash
composer dump-autoload
```

Rigenera autoload classi.

## 24.2 NPM

```bash
npm install
```

Installa dipendenze.

```bash
npm install nome-pacchetto
```

Installa pacchetto.

```bash
npm run dev
```

Avvia Vite.

```bash
npm run build
```

Build produzione.

## 24.3 Artisan progetto

```bash
php artisan serve
```

Server locale.

```bash
php artisan key:generate
```

Genera APP_KEY.

```bash
php artisan test
```

Esegue test.

## 24.4 Artisan make

```bash
php artisan make:model Project
```

Crea model.

```bash
php artisan make:model Project -m
```

Crea model + migration.

```bash
php artisan make:controller Admin/ProjectController --resource
```

Crea controller resource.

```bash
php artisan make:migration create_projects_table
```

Crea migration.

```bash
php artisan make:migration add_image_to_projects_table --table=projects
```

Crea migration per modificare tabella esistente.

```bash
php artisan make:seeder ProjectsTableSeeder
```

Crea seeder.

```bash
php artisan make:factory ProjectFactory --model=Project
```

Crea factory per model.

```bash
php artisan make:request StoreProjectRequest
```

Crea Form Request.

```bash
php artisan make:component Modal
```

Crea componente Blade class-based.

## 24.5 Artisan database

```bash
php artisan migrate
```

Esegue migration.

```bash
php artisan migrate:rollback
```

Rollback ultimo batch.

```bash
php artisan migrate:fresh
```

Reset database.

```bash
php artisan migrate:fresh --seed
```

Reset + seed.

```bash
php artisan db:seed
```

Esegue DatabaseSeeder.

```bash
php artisan db:seed --class=ProjectsTableSeeder
```

Esegue seeder specifico.

```bash
php artisan migrate:status
```

Mostra stato migration.

## 24.6 Artisan route/cache/config

```bash
php artisan route:list
```

Lista rotte.

```bash
php artisan route:clear
```

Pulisce cache rotte.

```bash
php artisan config:clear
```

Pulisce cache config.

```bash
php artisan cache:clear
```

Pulisce cache app.

```bash
php artisan view:clear
```

Pulisce view compilate.

## 24.7 Git

```bash
git status
```

Controlla stato.

```bash
git add .
```

Aggiunge modifiche allo staging.

```bash
git commit -m "messaggio"
```

Crea commit.

```bash
git log --oneline
```

Mostra cronologia compatta.

```bash
git checkout -b nome-branch
```

Crea branch.

```bash
git checkout master
```

Torna a master.

```bash
git reset --hard HEAD
```

Scarta modifiche non committate.

```bash
git diff --name-status
```

Mostra file modificati.

---

# Fine guida

Questa guida è pensata come documento vivo: quando un progetto futuro introdurrà nuove pratiche, aggiungi una sezione dedicata nel sommario e una ricetta nel cookbook/appendice, senza cancellare i passaggi storici del portfolio.
