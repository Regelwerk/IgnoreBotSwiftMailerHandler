<?php

namespace Regelwerk\IgnoreBotSwiftMailerHandlerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('regelwerk_ignore_bot')
            ->children()
                ->booleanNode('enable')
                    ->defaultTrue()
                    ->info('Enable or disable this bundle')
                ->end()
                ->scalarNode('handler')
                    ->default('main')
                    ->info('The id of the swift mailer handler (search the entry in app/config/config.yml in monolog: handlers: where the type is swift_mailer)')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
