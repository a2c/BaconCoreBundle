BaconCoreBundle
===============

[![Codacy Badge](https://api.codacy.com/project/badge/grade/0fcf3272ea6f41f79afc4f11bfa77854)](https://www.codacy.com/app/adan-grg/BaconCoreBundle)

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
