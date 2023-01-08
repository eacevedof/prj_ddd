## Manifiesto cleancode

- [Repo ejemplo Codely](https://github.com/CodelyTV/php-ddd-example/tree/main/src/Mooc/Courses)
  - [Parte del código del video](https://github.com/eacevedof/prj_phptests/tree/master/examples/eventsourcing)
- Los endpoints:
  - deberían ser user friendly y aplicando el formato slug en las urls
  - usamos guiones medios y siempre minúsculas
    - https://undominio.com/categoria/otra-categoria/parametro-1 (ok)
    - https://undominio.com/Categoria/otraCategoria/Parametro_1 (nok)

### BE

- ### encapsulación
  - las clases deben ser de base final
  - por defecto todos sus atributos private
  - todos sus métodos incialmente deben ser privados a excepción del constructor y el método `__invoke()`
  - en el constructor se hace la inyección de dependencias y con invoke se lanza la única lógica para que ha sido creada la clase
  

- ### nomenclatura
  - Sufijo que identifica su rol
    - GetAssetsListController
      - https://youtu.be/o0w-jYun6AU?t=1465
    - GetAssetsListCommand (dto)
    - GetAssetsListCommandHandler
      - https://youtu.be/o0w-jYun6AU?t=1492
    - GetAssetsListRequestValidator
    - GetAssetsListService (application service)
      - https://youtu.be/o0w-jYun6AU?t=1561 
    - AssetListRepository
    - AssetEntity (extiende de AggregateRoot)
      - https://youtu.be/o0w-jYun6AU?t=1595
    - GetAssetsListRecoveredEvent
    - GetAssetsListDto
    - GetAssetsListTransformer
    - GetAssetsListTest
      - https://youtu.be/o0w-jYun6AU?t=1634 

- ### tipado
  - usamos comillas dobles ya que permiten la interpolación en lugar de la concatenación
  - 
  - usemos el tipado estricto siempre esto nos ahorrará conflictos de tipos
  - los arrays en plural y con valor semántico
  - las variables se definen lo más cerca de donde se utilizan
    
### Flujo
- 