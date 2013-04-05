Orkestra APCBundle
==================

An APC Bundle for Symfony 2 PHP Framework

* [English version](https://github.com/Divi/OrkestraAPCBundle#english)
* [French version](https://github.com/Divi/OrkestraAPCBundle#french)

# English
This bundle contains :
* A command to delete the user or/and OPCode cache.
* A service to user APC very easily.
* An APC manager page with used memory write in PHP4 (i'm not the author, see Extra folder).

## Installation :
### Step 1: Download OrkestraAPCBundle using composer

In your composer.json, add OrkestraAPCBundle :

```js
{
    "require": {
        "orkestra/apc-bundle": "dev-master"
    }
}
```

Now, you must update your vendors using this command :

``` bash
$ php composer.phar update orkestra/apc-bundle
```

### Step 2: Add in AppKernel.php
``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
	$bundles = array(
		// ...
		new Orkestra\APCBundle\OrkestraAPCBundle()
	);
}
```

### Step 3: Configure your config.yml
**Basic configuration :**
``` yml
# app/config/config.yml
orkestra_apc:
	# Your website URL. Use by the clear command.
    website_url: http://orkestra.dev
```

**Full configuration :**
``` yml
# app/config/config.yml
orkestra_apc:
	# Your website URL. Use by the clear command.
    website_url: http://orkestra.dev
	# Location of the "web" folder. Edit this option only if you have moved this folder.
	web_dir: %kernel.root_dir%/../web
	# The clear command will create a file in your web folder, if the removal doesn't work (you will be warned), a password is safety.
    access_password: my_password
```

## How to use

### APC class usage
``` php
<?php

$apc = $this->container->get('orkestra.apc');
$apc->set('new_value', 'example', 300); // 300 seconds before timeout (auto delete)

if ($apc->exist('new_value')) {
	$apc->get('new_value');
}
$apc->delete('new_value');
```

### Finally, command usage
``` bash
Usage:
 php app/console apc:clear [--opcode] [--user]
Options:
 --opcode  Clear only the opcode cache
 --user    Clear only the user cache
Help:
 Note: without options, both caches will be deleted
```

## Issue or new feature ?

Feel free to post your issue or feature request in the [issue tracker](https://github.com/Divi/AjaxLoginBundle/issues) !


# French
Ce bundle contient :
* Une commande permettant de supprimer le cache utilisateur et/ou OPCode.
* Un service permettant d'utiliser APC très facilement.
* Une page de gestion d'APC avec la mémoire utilisée écrit en PHP4 (je ne suis pas l'auteur, voir dossier Extra).

## Installation :
### Partie 1: Télécharger OrkestraAPCBundle en utilisant composer

Dans votre composer.json, ajoutez OrkestraAPCBundle :

```js
{
    "require": {
        "orkestra/apc-bundle": "dev-master"
    }
}
```

Maintenant, vous devez mettre à jour vos vendors grâce à la commande :

``` bash
$ php composer.phar update orkestra/apc-bundle
```

### Partie 2: Ajouter dans l'AppKernel.php
``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
  $bundles = array(
		// ...
		new Orkestra\APCBundle\OrkestraAPCBundle()
	);
}
```

### Partie 3: Configurez votre config.yml
**Configuration minimale :**
``` yaml
# app/config/config.yml
orkestra_apc:
	# URL de votre site. Utilisé par la commande de clear.
    website_url: http://orkestra.dev
```

**Configuration complète :**
``` yml
# app/config/config.yml
orkestra_apc:
	# URL de votre site. Utilisé par la commande de clear.
    website_url: http://orkestra.dev
	# Emplacement du dossier "web". Modifiez cette option seulement si vous avez déplacé le dossier.
	web_dir: %kernel.root_dir%/../web
	# La commande de clear va créer un fichier dans votre dossier web, si jamais la suppression ne fonctionne pas (vous serez averti), un mot de passe est toujours plus sécurisant.
    access_password: my_password
```

## Exemples

### Utilisation de la classe APC :
``` php
<?php

$apc = $this->container->get('orkestra.apc');
$apc->set('new_value', 'example', 300); // 300 seconds before timeout (auto delete)

if ($apc->exist('new_value')) {
    $apc->get('new_value');
}
$apc->delete('new_value');
```

### Enfin, l'utilisation de la commande :
``` bash
Usage:
 php app/console apc:clear [--opcode] [--user]
Options:
 --opcode  Supprime seulement le cache OPCode
 --user    Supprime seulement le cache utilisateur
Help:
 Note: si aucune option n'est renseignée, les deux caches seront supprimés
```

## Un problème ou une nouvelle fonctionnalité ?

N'hésitez pas à poster votre problème ou votre nouvelle fonctionnalité via l'[issue tracker](https://github.com/Divi/OrkestraAPCBundle/issues) !