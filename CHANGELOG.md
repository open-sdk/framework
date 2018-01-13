## [0.4.0](https://github.com/open-sdk/framework/compare/0.3.0...0.4.0) (2018-01-11)

### New features
- add `assertSubclassOf` to test case ([f0393ac](https://github.com/open-sdk/framework/commit/f0393ac298686bf82e5f09cae76efb32db1a0b92))

### Bug fixes
- update gitattributes file to ignore the new phpcs, phpstan and phpunit files ([95f0b1e](https://github.com/open-sdk/framework/commit/95f0b1ed5a89ee8feb1989f7763293ee7329fde9))
- add exact versions to dependencies including patches ([518af04](https://github.com/open-sdk/framework/commit/518af040719ed7f51e9c794ad0b7d74306eda8ac))
- extend throwable interface from sdk exception ([7aa6ba2](https://github.com/open-sdk/framework/commit/7aa6ba2e1365a3e7759afc812d12f452063afbda))

### Code refactors
- remove extraneous framework namespace ([29d94c6](https://github.com/open-sdk/framework/commit/29d94c609a66193982838dcb3a014ca262919888))
- move relay middleware stack to dedicated folder ([78a54bb](https://github.com/open-sdk/framework/commit/78a54bbe688c1bf3bf1e760fd97f1c6ca6b03d2b))
- remove extraneous -interface and -implement suffixes ([4198ecf](https://github.com/open-sdk/framework/commit/4198ecfe09292edd12cef3d639330ce2d0cdb965))
- remove exception inheritance and unify their construction parameters ([c3ac4b4](https://github.com/open-sdk/framework/commit/c3ac4b479966001da3c61602717619dbb3ff35c0))
- simplify decoders and scope it to responses only ([79b3056](https://github.com/open-sdk/framework/commit/79b3056d77fce9514b6d868e44217cf23b8230d9))
- replace old resource objects with new casting architecture ([d78fe4f](https://github.com/open-sdk/framework/commit/d78fe4f82f83961fb0e1fad842716554adf6ca96))
- replace old resource factory with the new manager and manager factory ([f906b8f](https://github.com/open-sdk/framework/commit/f906b8fc9292624562451e80a774c8987a38bee3))
- update usage of the resource manager and manager factory ([4e0b517](https://github.com/open-sdk/framework/commit/4e0b517cc07bbab3dbb4ed7cb020f3d564b6c390))

### Documentation changes
- add missing docblocks to resource classes and make them uniform ([104e709](https://github.com/open-sdk/framework/commit/104e709bf9cebf1a440d82f4bf8ee9aea86fba87))
- add description to the sdk exception interface ([728c9e6](https://github.com/open-sdk/framework/commit/728c9e6ec08f691b8b13da8499611629f7032ed4))

### Other chores
- move the static code analyser check to the first test command ([42f2848](https://github.com/open-sdk/framework/commit/42f28487a7a9058c07829e5596017a7b0a9b37e0))


## [0.3.0](https://github.com/open-sdk/framework/compare/0.2.0...0.3.0) (2018-01-03)

### New features
- phpstan with phpunit extension ([4d72ac6](https://github.com/open-sdk/framework/commit/4d72ac61a0fd8a933922c732a11f24a6bdd29cec))

### Bug fixes
- errors detected with phpstan ([9dc18af](https://github.com/open-sdk/framework/commit/9dc18af67a28faefa0f1b1579abfdd70bd890034))

### Other chores
- add php 7.2 to travis to test with ([aa7e527](https://github.com/open-sdk/framework/commit/aa7e5273c078c885076172bb56a089d1bf9b9f12))
- run phpcs, phpunit and phpstan in travis ([509ab7a](https://github.com/open-sdk/framework/commit/509ab7a0ae05ee166ccedc6b6f0f104c635bb032))
- exclude phpstan from executing for php 7.0 on travis ([95309bf](https://github.com/open-sdk/framework/commit/95309bf9b00a62bfa11450bd4caaf2bf668d6b0d))


## [0.2.0](https://github.com/open-sdk/framework/compare/0.1.0...0.2.0) (2017-10-14)

### New features
- nested resource and attribute casting ([32b7e2a](https://github.com/open-sdk/framework/commit/32b7e2aac4494e7a15bb5538dc4682524dccc35e))

### Code refactors
- rename resource to model for usage as category name ([7de268c](https://github.com/open-sdk/framework/commit/7de268c6525fd5c75a42841c33e0af6e261b4cc5))

### Documentation changes
- showing all release versions on badge in readme ([8d2e505](https://github.com/open-sdk/framework/commit/8d2e5050ea18f88cd1194bf62e5938282120ce06))


## [0.1.0](https://github.com/open-sdk/framework/compare/799d93724aca6906445ff19553628556cb0b5bb0...0.1.0) (2017-10-11)

### New features
- initial project code ([0071fc2](https://github.com/open-sdk/framework/commit/0071fc22075ea5af67c8a20246d597da6d018f3d))

### Bug fixes
- remove backwards incompatible type hints and update phpdocs ([7465429](https://github.com/open-sdk/framework/commit/746542950c5a95bf7ea860359060467b9196efa0))

### Testing updates
- add collection `each` loop break assertion ([0c3fbe5](https://github.com/open-sdk/framework/commit/0c3fbe54d925706d69da580312914ef77fffe184))

### Other chores
- initial project structure ([799d937](https://github.com/open-sdk/framework/commit/799d93724aca6906445ff19553628556cb0b5bb0))
- set php `7.0` as supported language version ([3491333](https://github.com/open-sdk/framework/commit/34913331823640c14a7a1ef170f879d7a6206d4e))
