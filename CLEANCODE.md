## Manifiesto cleancode

- [Video Codely - De código acoplado al framework hasta microservicios pasando por DDD](https://youtu.be/o0w-jYun6AU)
  - [Repo esqueleto en DDD Codely](https://github.com/CodelyTV/php-ddd-example/tree/main/src/Mooc/Courses)
  - [Parte del código del video](https://github.com/eacevedof/prj_phptests/tree/master/examples/eventsourcing)


### BE

- ### Endpoints:
- Deberían ser user friendly y aplicando el formato slug en las urls
- usamos guiones medios y siempre minúsculas
  - https://undominio.com/assets/get-list/parametro-1 (ok)
  - https://undominio.com/Assets/getList/Parametro_1 (nok)


- ### Encapsulación
  - las clases deben ser **final** por defecto `final class AssetsListGetController`
  - por defecto todos sus atributos y métodos **private**
  - todos sus métodos incialmente deben ser privados a excepción del constructor y el método `__invoke()`
  - en el constructor se hace la inyección de dependencias y con invoke se lanza la única lógica 
  para que ha sido creada la clase. **AssetsListGet**

- ### Clases y su responsabilidad en una aplicación
  - Sufijo que identifica la responsabilidad
  - AssetsListGetController
    - Gestiona el punto de entrada, request y su resultado de post procesado response
    - https://youtu.be/o0w-jYun6AU?t=1465
  - AssetsListGetCommand 
    - DTO (Data Transfer Object)
    - El payload mínimo de entrada que se extrae de la request y que se pasará al handler.
  - AssetsListGetCommandHandler
    - https://youtu.be/o0w-jYun6AU?t=1492
  - AssetsListGetService 
    - Application service. Encapsula el caso de uso que se pretende resolver. En el ejemplo, obtener una lista de assets.
    - https://youtu.be/o0w-jYun6AU?t=1561 
  - AssetsListGetRequestValidator
    - 
  - AssetsListRepository
    - Implementa IDomainAssetsListRepository
  - AssetsListProvider
    - Implementa IDomainAssetsListRepository
    - Es equivalente a un repositorio pero con la salvedad que el origen es un sistema externo, un micro-servicio, una api de terceros, etc.
    - También puede representar un servicio externo
  - AssetEntity (extiende de AggregateRoot)
    - https://youtu.be/o0w-jYun6AU?t=1595
  - AssetsListGetDoneEvent
  - AssetsListGetDto
  - AssetsListGetApiTransformer
  - AssetsListGetConsoleTransformer
  - AssetsListGetTemplateTransformer
  - AssetsListGetTest
    - https://youtu.be/o0w-jYun6AU?t=1634 

- ### tipado
  - usamos comillas dobles ya que permiten la interpolación en lugar de la concatenación
  - 
  - usemos el tipado estricto siempre esto nos ahorrará conflictos de tipos
  - los arrays en plural y con valor semántico
  - las variables se definen lo más cerca de donde se utilizan
    
### Flujo
- 