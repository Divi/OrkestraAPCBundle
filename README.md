Orkestra APCBundle
==================

An APC Bundle for Symfony 2 PHP Framework

* [French version](https://github.com/Divi/OrkestraAPCBundle#french)
* [English version](https://github.com/Divi/OrkestraAPCBundle#english)

# French
Ce bundle contient :
* Une commande permettant de supprimer le cache utilisateur et/ou OPCode.
* Un service permettant d'utiliser APC très facilement.
* Une page de gestion d'APC avec la mémoire utilisée écrit en PHP4 (je ne suis pas l'auteur, voir dossier Extra).

## Installation :
1. Ajouter dans l'AppKernel.php :
``` php
// app/AppKernel.php
public function registerBundles()
{
  $bundles = array(
		new Orkestra\APCBundle\OrkestraAPCBundle()
	);
}
```

2. Ajouter dans l'autoloader.php :
``` php
// app/autoload.php
$loader->registerNamespaces(array(
	'Orkestra' => __DIR__.'/../vendor/bundles',
);
```

3. Configurez votre config.yml :
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

4. Utilisation de la classe APC :
``` php
$apc = $this->container->get('orkestra.apc');
$apc->set('new_value', 'example', 300); // 300 seconds before timeout (auto delete)
if ($apc->exist('new_value')) {
    $apc->get('new_value');
}
$apc->delete('new_value');
```

5. Enfin, l'utilisation de la commande :
``` bash
Usage:
 php app/console apc:clear [--opcode] [--user]
Options:
 --opcode  Supprime seulement le cache OPCode
 --user    Supprime seulement le cache utilisateur
Help:
 Note: si aucune option n'est renseignée, les deux caches seront supprimés
```


# English
This bundle contains :
* A command to delete the user or/and OPCode cache.
* A service to user APC very easily.
* An APC manager page with used memory write in PHP4 (i'm not the author, see Extra folder).

## Installation :
1. Add in AppKernel.php :
``` php
// app/AppKernel.php
public function registerBundles()
{
	$bundles = array(
		new Orkestra\APCBundle\OrkestraAPCBundle()
	);
}
```

2. Add in autoloader.php :
``` php
// app/autoload.php
$loader->registerNamespaces(array(
	'Orkestra' => __DIR__.'/../vendor/bundles',
);
```

3. Configure your config.yml :
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

4. APC class usage :
``` php
$apc = $this->container->get('orkestra.apc');
$apc->set('new_value', 'example', 300); // 300 seconds before timeout (auto delete)
if ($apc->exist('new_value')) {
	$apc->get('new_value');
}
$apc->delete('new_value');
```

5. Finally, command usage :
``` bash
Usage:
 php app/console apc:clear [--opcode] [--user]
Options:
 --opcode  Clear only the opcode cache
 --user    Clear only the user cache
Help:
 Note: without options, both caches will be deleted
```