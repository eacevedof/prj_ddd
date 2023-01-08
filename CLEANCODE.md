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
  - Las clases deben ser **final** por defecto `final class AssetsListGetController, etc`
  - Intentamos evitar la herencia siempre que sea posible. En su lugar recurrimos a los Traits.
  - Por defecto todos sus atributos y métodos son **private**. Mantener un método público tiene un costo mayor.
  - Como métodos públicos dispondremos el constructor y el método `__invoke()`
  - En el constructor se hace la inyección de dependencias y con invoke se lanza la única lógica 
  para que ha sido creada la clase. **AssetsListGet**

- ### Clases y su responsabilidad en una aplicación
  - Sufijo que identifica la responsabilidad
  - AssetsListGetController
    - Gestiona el punto de entrada, request y su resultado de post procesado response
    - https://youtu.be/o0w-jYun6AU?t=1465
  - AssetsListGetCommand 
    - DTO (Data Transfer Object)
    - Es el payload mínimo de entrada (que conoce el handler). Se extrae de la request y que se pasará al handler.
    - Se validan los tipos primitivos
  - AssetsListGetCommandHandler
    - https://youtu.be/o0w-jYun6AU?t=1492
  - AssetsListGetService 
    - Application service. Encapsula el caso de uso que se pretende resolver. En el ejemplo, obtener una lista de assets.
    - https://youtu.be/o0w-jYun6AU?t=1561 
  - AssetsListGetCommandValidator
    - En el servicio se validan las reglas de negocio que pasar el **comando** antes de ser invocado en el caso de uso
  - AssetsListRepository
    - Implementa IDomainAssetsListRepository
  - AssetsListProvider
    - Implementa IDomainAssetsListRepository
    - Es equivalente a un repositorio pero con la salvedad que el origen es un sistema externo, un micro-servicio, una api de terceros, etc.
    - También puede representar un servicio externo
  - AssetEntity (extiende de AggregateRoot)
    - https://youtu.be/o0w-jYun6AU?t=1595
  - AssetsListGetFinishedEvent
    - Los eventos siempre acompañados con una acción en pasado
  - AssetsListGetDto
    - Si el caso de uso se ha ejecutado correctamente y devuelve un resultado, este debería ser un DTO.
  - AssetsListGetApiTransformer
    - Si procede, al resultado anterior se le puede aplicar alguna transformación antes de enviar la respuesta al cliente 
    - AssetsListGetConsoleTransformer
    - AssetsListGetTemplateTransformer
    - AssetsListErrorTransformer
  - AssetsListGetTest
    - Prueba unitaria del caso de uso
    - https://youtu.be/o0w-jYun6AU?t=1634 
  - AssetsListTrait
  - IAssetsList
  - AssetsException
    - AssetsListGetException
  - AssetsXxxEnum

- ### otros
  - Al mínimo error nos salimos del contexto en el que estemos
  - No usamos literales planos en clausulas de guarda, recurrimos a enumerados o constantes.
  - Usamos comillas dobles ya que permiten la interpolación en lugar de la concatenación
  - 
  - usemos el tipado estricto siempre esto nos ahorrará conflictos de tipos
  - los arrays en plural y con valor semántico
- las variables se definen lo más cerca de donde se utilizan
    
### Flujo
- 