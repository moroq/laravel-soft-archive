# Laravel - Soft Archive

This is a package to extends soft delete to use to archive models.

## Installation

You can install the package via composer:

```bash
composer require felipedecampos/laravel-soft-archive
```

Optionally you can publish the configfile with:

```bash
php artisan vendor:publish --provider="FelipeDeCampos\LaravelSoftArchive\Providers\ArchiveServiceProvider" --tag="config" 
```

## Usage

Add the soft archive trait to your model, like the example below:

```php
class ArchivedModel extends Model
{
    use SoftArchives;
}
```

To archive the entity use the archive() method like the example below:

```php
ArchivedModel::withoutArchived()->find($id)->archive();
```

To activate the entity use the unarchive() method like the example below:

```php
ArchivedModel::withArchived()->find($id)->unarchive();
```

### Testing

``` bash
vendor/bin/phpunit
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email felipe.campos.programador@gmail.com instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Av. Bartholomeu de Carlos, 747 Apto. 32A - Jardim Flor da Montanha, São Paulo / Brazil.

We publish all received postcards [on our company website](http://bettorld.felipedecampos.com.br/opensource/postcards).

## Credits

- [Felipe de Campos](http://site.felipedecampos.com.br/)
- [Tudo pelo conhecimento](http://tudopeloconhecimento.com.br/)

## Support us

Bettorld is a webdesign agency based in São Paulo, Brazi. You'll find an overview of all our open source projects [on our website](http://bettorld.felipedecampos.com.br/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/bettorld). 
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
