# Version 2.0.0
- This version does not include `Locator` nor `DownloaderInterface` implementations.
  That functionality is actually outside the scope of this library and that is the reason
  why it was removed. A new library was created to implement this, take a look in
  `eclipxe/xmlresourceretriever` https://github.com/eclipxe13/XmlResourceRetriever/
- Constructor of `SchemaValidator` and `Schemas` changed.
- Add new method `SchemaValidator::validateWithSchemas` that do the same
  thing than `SchemaValidator::validate` but you must provide the `Schemas` collection
- Change from `protected` to `public` the method `SchemaValidator::buildSchemas`,
  it's usefull when used with `SchemaValidator::validateWithSchemas` to change
  XSD remote locations to local or other places.
- Add `XmlSchemaValidator::LibXmlException`. It contains a method to exec a callable
  isolating the use internal errors setting and other to collect libxml errors
  and throw it like an exception.
- Rename `Schemas::getXsd` to `Schemas::getImporterXsd`
- Remove compatibility with PHP 5.6, minimum version is now PHP 7.0
- Add scalar type declarations
- Remove test assets from Mexican SAT
- Tests: Move files served by php built-in web server to from assets to public

# Version 1.1.4
- Fix implementation of libxml use internal errors on `SchemaValidator::validate`
- When creating the dom document avoid warnings (fix using the correct constant)
- Avoid using versions `@stable` in `composer.json`
- Install scrutinizer/ocular only on travis and PHP 7.1

# Version 1.1.3
- Fix test were fialing on php 7.0 and 7.1
    - class PHPUnit_Framework_TestCase is deprecated
    - wait for 0.5 seconds after run the php server

# Version 1.1.2
- Fix project name in README.md
- Add composer.json tag xmlschema

# Version 1.1.1
- Remove typo on .travis.yml

# Version 1.1.0
- This change does not introduce any break with previous versions but add a new interface and objects
  to perform the download
- Library
    - Add the interface `XmlSchemaValidator\Downloader\DownloaderInterface` and implementations
      `XmlSchemaValidator\Downloader\CurlDownloader`,
      `XmlSchemaValidator\Downloader\NullDownloader` and
      `XmlSchemaValidator\Downloader\PhpDownloader`.
    - Make `XmlSchemaValidator\Locator` use the `DownloaderInterface`
    - Add tests for the Locator constructor and downloader getter.
- Tests
    - Add tests for the Locator constructor and downloader getter.
    - Add tests for `XmlSchemaValidator\Downloader`
    - Start php internal server to run tests on downloaders (bootstrap.php)
    - Default tests for locator uses a faker test to avoid external downloads
- Continuous Integration
    - Add 7.1
    - Drop hhvm
- Standarization
    - Rename folder `sources` to `src`
    - Rename `.php_cs` to `.php_cs.dist` require dev `friendsofphp/php-cs-fixer`
    - Add `phpcs.xml.dist`
    - Apply code style fixes from `phpcbf` and `php-cs-fixer`
- Documentation
    - Add basic usage to the validator
    - Add `CHANGELOG.md`, `TODO.md`, `CODE_OF_CONDUCT.md`, `CONTRIBUTING.md`
    - Fix badges
    - Drop coveralls

# Version 1.0.0
- Follow recommendations from sensiolabs
- Project does not depends on zip extension
- Include SensioLabs Insight
