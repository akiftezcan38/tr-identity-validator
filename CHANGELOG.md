# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2025-10-16

### Added
- TCKN (Turkish Identity Number) validation with official algorithm
- VKN (Turkish Tax Number) validation with official algorithm
- Auto-detection feature for number type
- Detailed validation results with metadata
- Comprehensive test suite with PHPUnit
- Full PHP 8.4 compatibility
- Zero external dependencies
- PSR-4 autoloading support
- Complete documentation in Turkish and English

### Features
- `TcknValidator` class for TCKN validation
- `VknValidator` class for VKN validation
- `IdentityValidator` main class with unified API
- `ValidatorInterface` for custom implementations
- Whitespace handling in input numbers
- Detailed error messages
- Type detection based on length

### Documentation
- Comprehensive README.md
- Usage examples
- API reference
- Algorithm descriptions
- Legal disclaimer

## [Unreleased]

### Planned Features
- Company information retrieval from Tax ID
- Batch validation support
- Caching mechanism for validated numbers
- Laravel integration package
- REST API example implementation
