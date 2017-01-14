BaconCoreBundle
===============

[![Codacy Badge](https://api.codacy.com/project/badge/grade/0fcf3272ea6f41f79afc4f11bfa77854)](https://www.codacy.com/app/adan-grg/BaconCoreBundle)
[![Latest Stable Version](https://poser.pugx.org/baconmanager/core-bundle/v/stable)](https://packagist.org/packages/baconmanager/core-bundle)
[![License](https://poser.pugx.org/baconmanager/core-bundle/license)](https://packagist.org/packages/baconmanager/core-bundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/798deed7-23b8-4fba-a6e6-cb018d11d008/mini.png)](https://insight.sensiolabs.com/projects/798deed7-23b8-4fba-a6e6-cb018d11d008)

Este bundle é responsavel por adicionar classes para abstrair algumas funções do Symfony tais como uma entidade Base com *behaviors* para criar campos padrões de **created/updated** e **Soft-Deleted**, FormHandler base para salvar, atualizar e deletar registros do banco de dados utilizando o **ORM Doctrine2**

## Instalação

Para instalar o bundle basta rodar o seguinte comando abaixo:

```bash
$ composer require bacon/core-bundle
```
Agora adicione os seguintes bundles no arquivo AppKernel.php:

```php
<?php
// app/AppKernel.php
public function registerBundles()
{
    // ...
    new Bacon\Bundle\CoreBundle\BaconCoreBundle(),
    new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
    // ...
}
```
No arquivo **app/config/config.yml** adicione as seguintes configurações:

```yaml
doctrine:
	---
    orm:
        filters:
            softdeleteable:
                class: Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter
                enabled: true
```
Adicionar as seguintes linhas no arquivo **app/config/services.yml**
services:

```yaml
services:
    gedmo.listener.softdeleteable:
        class: Gedmo\SoftDeleteable\SoftDeleteableListener
        tags:
            - { name: doctrine.event_subscriber, connection: default }
        calls:
            - [ setAnnotationReader, [ @annotation_reader ] ]

    gedmo.listener.timestampable:
        class: Gedmo\Timestampable\TimestampableListener
        tags:
            - { name: doctrine.event_subscriber, connection: default }
        calls:
            - [ setAnnotationReader, [ "@annotation_reader" ] ]
```

Para configurar o pacote KnpPaginatorBundle basta olhar na configuração do bundle no acessando o este [Link](https://github.com/KnpLabs/KnpPaginatorBundle)!


### Informações adicionais

* [TwigExtensions](https://github.com/a2c/BaconCoreBundle/tree/master/Resources/doc/TwigExtensions.md)
