# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [2.3.1](https://github.com/ptrkcsk/fa-wp-admin-menu-icons/compare/v2.3.0...v2.3.1) - 2018-03-29

### Changed

- Update README.txt changelog

## [2.3.0](https://github.com/ptrkcsk/fa-wp-admin-menu-icons/compare/v2.2.1...v2.3.0) - 2018-03-29

### Changed

- Bump Font Awesome version from 5.0.8 to 5.0.9

## [2.2.1](https://github.com/ptrkcsk/fa-wp-admin-menu-icons/compare/v2.2.0...v2.2.1) - 2018-03-25

### Fixed

- Fix styles action

## [2.2.0](https://github.com/ptrkcsk/fa-wp-admin-menu-icons/compare/v2.1.0...v2.2.0) - 2018-03-25

### Added

- Add support for Font Awesome versions. Icons are now cached with their Font Awesome version so they can be updated when the Font Awesome version changes.

## [2.1.0](https://github.com/ptrkcsk/fa-wp-admin-menu-icons/compare/v2.0.1...v2.1.0) - 2018-03-19

### Added

- Add links to changelog
- Add links to readme badges
- Integrate Travis and Code Climate test coverage

### Changed

- Instead of storing all icons in the plugin, get them remotely, as needed, and cache them in the database for future use
- Make hooks code DRYer
- Stop using static methods, to make testing easier
- Make icons smaller so they look better next to Dashicons
- Update Font Awesome shims

## [2.0.1](https://github.com/ptrkcsk/fa-wp-admin-menu-icons/compare/v2.0.0...v2.0.1) - 2017-12-21

### Added

- Add CC BY 4.0 attribution in `icons/README.md` to adhere to [Font Awesome license](https://fontawesome.com/license)

### Fixed

- Fix old syntax in readme examples
- Add missing 'Usage' section to `README.txt`

## [2.0.0](https://github.com/ptrkcsk/fa-wp-admin-menu-icons/compare/v1.0.4...v2.0.0) - 2017-12-20

### Added

- Add unit tests

### Changed

- Upgrade to Font Awesome 5 icons and class syntax
- Use PSR instead of WordPress for code style

### Deprecated

- Deprecate use of Font Awesome 4 class syntax

## [1.0.4](https://github.com/ptrkcsk/fa-wp-admin-menu-icons/compare/v1.0.3...v1.0.4) - 2017-10-29

### Changed

- Format code

### Removed

- Remove caveat from documentation because it no longer applies

## [1.0.3](https://github.com/ptrkcsk/fa-wp-admin-menu-icons/compare/v1.0.2...v1.0.3) - 2017-06-17

### Added

- Add more icons

## [1.0.2](https://github.com/ptrkcsk/fa-wp-admin-menu-icons/compare/v1.0.1...v1.0.2) - 2017-06-16

### Fixed

- Fix undefined index

## [1.0.1](https://github.com/ptrkcsk/fa-wp-admin-menu-icons/compare/v1.0.0...v1.0.1) - 2017-06-16

### Fixed

- Add icons to `icons/`. The directory was empty on the WordPress plugin repository.

## 1.0.0 - 2017-03-25
