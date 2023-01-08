## Manifiesto cleancode

- [Video Codely - De código acoplado al framework hasta microservicios pasando por DDD](https://youtu.be/o0w-jYun6AU)
  - [Repo esqueleto en DDD Codely](https://github.com/CodelyTV/php-ddd-example/tree/main/src/Mooc/Courses)
  - [Parte del código del video](https://github.com/eacevedof/prj_phptests/tree/master/examples/eventsourcing)


### BE

- ### Endpoints:
- deberían ser user friendly y aplicando el formato slug en las urls
- usamos guiones medios y siempre minúsculas
  - https://undominio.com/categoria/otra-categoria/parametro-1 (ok)
  - https://undominio.com/Categoria/otraCategoria/Parametro_1 (nok)


- ### Encapsulación
  - las clases deben ser de base final
  - por defecto todos sus atributos private
  - todos sus métodos incialmente deben ser privados a excepción del constructor y el método `__invoke()`
  - en el constructor se hace la inyección de dependencias y con invoke se lanza la única lógica para que ha sido creada la clase
  

- ### nomenclatura
  - Sufijo que identifica su rol
    - AssetsListGetController
      - https://youtu.be/o0w-jYun6AU?t=1465
    - AssetsListGetCommand (dto, data transfer object)
    - AssetsListGetCommandHandler
      - https://youtu.be/o0w-jYun6AU?t=1492
    - AssetsListGetRequestValidator
    - AssetsListGetService (application service)
      - https://youtu.be/o0w-jYun6AU?t=1561 
    - AssetListRepository
    - AssetEntity (extiende de AggregateRoot)
      - https://youtu.be/o0w-jYun6AU?t=1595
    - AssetsListGetDoneEvent
    - AssetsListGetDto
    - AssetsListGetTransformer
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