<?php

namespace Orkestra\APCBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class OrkestraAPCExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
		$configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

		// For default value
		$config['web_dir'] = str_replace('%kernel.root_dir%', $container->getParameter('kernel.root_dir'), $config['web_dir']);

		// Check if the URL is valid
		if (substr($config['website_url'], 0, strlen('http://')) != 'http://') {
			$config['website_url'] = 'http://' . $config['webiste_url'];
		}

		foreach ($config as $name => $value) {
			$container->setParameter('orkestra_apc.' . $name, $value);
		}
		
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('apc_cache_services.xml');
    }
}