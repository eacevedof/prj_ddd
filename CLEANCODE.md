## Manifiesto cleancode

- [Video Codely - De código acoplado al framework hasta microservicios pasando por DDD](https://youtu.be/o0w-jYun6AU)
  - [Repo esqueleto en DDD Codely](https://github.com/CodelyTV/php-ddd-example/tree/main/src/Mooc/Courses)
  - [Parte del código del video](https://github.com/eacevedof/prj_phptests/tree/master/examples/eventsourcing)

### BE
- Tablas
- Los nombres de las tablas debemos de pensarlas como un conjunto de datos desacoplable del core e identificarlas con un prefijo.
- Un ejemplo son las tablas **assets_** y/o **bulk_**
- Los nombres se definen en plural (por seguir la convención del esquema heredado CEH)
- Las claves foraneas siguen el siguiente formato: **<nombre-de-tabla-destino>_id** CEH un ejemplo es **assets_id**
- Si hay que incluir una tabla de idiomas esta debe terminar con el sufijo de la que se traduce **<nombre-de-tabla-principal>_tr**
  -  

- Trabajamos con early error y con early return.
- Ejemplo:
```php
//código de un controlador
public function __invoke(Request $request): JsonResponse
{
    $this->languageManagerService->loadLocaleByHeaderLanguage();
    try {
/**
 * No usamos librerias de terceros para mapear un DTO con la request.
 * Nuestros DTOs suelen cumplir un patrón básico:  app/DTO/AbstractDto.php
*/    
        $assetFullDto = $this->assetFullUpdateDtoFromRequestBuilderService->__invoke($request);
        $this->assetFullUpdateDtoFromRequestBuilderService = null;

/**
 * aqui hacemos early error. Se valida el payload de entrada y 
*/
        
        $this->assetFullUpdateValidator->__invoke($assetFullDto);
        $this->assetFullUpdateValidator = null;

        $this->assetFilesTagChangeValidator->__invoke($assetFullDto);
        $this->assetFilesTagChangeValidator = null;

        $this->assetFullUpdateService->__invoke($assetFullDto);

        return $this->send200Response([
            "message" => trans("asset-full-tr.success.asset-successfully-saved")
        ]);
    }
    catch (AbstractAssetFullException | AssetsFilesTagException $ex) {
        return $this->sendResponseByCode($ex->getCode(), ["message" => $ex->getMessage()]);
    }
    catch (Exception $ex) {
        $this->sendExceptionToSentry($ex);
        return $this->send500Response(["message" => trans("exceptions.unexpected_500")]);
    }
}
```

- Ejemplo: Caso de uso: Obtener un listado de Assets

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
  - En el constructor se hace la inyección de dependencias (no hacemos ninguna lógica solo asignamos) y con invoke se lanza la única lógica 
  para que ha sido creada la clase. **AssetsListGet**
  - [Extremely defensive PHP](https://www.youtube.com/watch?v=Gl9td0zGLhw)

- ### Clases y su responsabilidad en una aplicación
  - Sufijo que identifica la responsabilidad
  - AssetsListGet**Controller**
    - Gestiona el punto de entrada, request y su resultado de post procesado response
    - https://youtu.be/o0w-jYun6AU?t=1465
  - AssetsListGet**Command** 
    - DTO (Data Transfer Object)
    - Es el payload mínimo de entrada (que conoce el handler). Se extrae de la request y que se pasará al handler.
    - Se validan los tipos primitivos
  - AssetsListGet**CommandHandler**
    - https://youtu.be/o0w-jYun6AU?t=1492
  - AssetsListGet**Service**
    - Application service. Encapsula el caso de uso que se pretende resolver. En el ejemplo, obtener una lista de assets.
    - https://youtu.be/o0w-jYun6AU?t=1561 
  - AssetsListGet**CommandValidator**
    - En el servicio se validan las reglas de negocio que debe pasar el **comando** antes de ser invocado en el caso de uso
  - AssetsList**Repository**
    - Implementa IDomainAssetsListRepository
    - https://youtu.be/uP1CoHtjALg?t=498
  - AssetsList**Provider**
    - Implementa IDomainAssetsListRepository
    - Es equivalente a un repositorio pero con la salvedad que el origen es un sistema externo, un micro-servicio, una api de terceros, etc.
    - También puede representar un servicio externo
  - Asset**Entity** (extiende de AggregateRoot)
    - En singular 
    - [Sobre named constructors en lugar de usar new AssetEntity](https://youtu.be/J0SFLG5B3wo?t=142)
    - https://youtu.be/o0w-jYun6AU?t=1595
  - AssetsListGetFinished**Event**
    - DTO
    - Los eventos siempre acompañados de una acción en pasado
  - AssetsListGet**Dto**
    - Si el caso de uso se ha ejecutado correctamente y devuelve un resultado, este debería ser un DTO.
  - AssetsListGetApi**Transformer**
    - Si procede, al resultado anterior se le puede aplicar alguna transformación antes de enviar la respuesta al cliente 
    - AssetsListGetConsoleTransformer
    - AssetsListGetTemplateTransformer
    - AssetsListErrorTransformer
  - AssetsListGet**Test**
    - Prueba unitaria del caso de uso
    - https://youtu.be/o0w-jYun6AU?t=1634 
  - AssetsList**Trait**
  - **AssetsListInterface**
  - Assets**Exception**
    - AssetsListGetException
    - AssetsListFilterException
    - [Name constructor en excepciones](https://youtu.be/J0SFLG5B3wo?t=439)
  - AssetsXxx**Enum**

- ### Otros
  - Al mínimo error nos salimos del contexto en el que estemos.
  - Evitamos comentarios. Para esto usamos variables metodos y clases con alto valor semantico
  - Código muerto. El código que queda obsoleto se elimina. La mejor linea de código es la que no se escribe y por ende no hay que mantener.
  ```php
  private function isValidPayload(array $data): bool
  {
    if (!$data) {
        return false;
    }
    if (!$userId = $data["user_id"]) {
        return false;
    }
    if (!DB::getUserId($userId)) {
        return false;
    }
    return true;
  }
  ```
  - No usamos literales planos o numericos (magic numbers) en clausulas de guarda, recurrimos a enumerados o constantes con valor semántico.
  - https://youtu.be/jNSQuqMW8sM?t=2799
  - Usamos comillas dobles ya que permiten la interpolación en lugar de la concatenación
  ```php
  $userName = "Eduardo";
  $lastName = "Acevedo";
  $welcomeMessage = "Hola {$userName} bienvenido";
  $fullName = "{$userName} {$lastName}";
  
  $data = [
    "$userName 1" => "xxx",
    "$userName 2" => "yyy",
  ];
  ``` 
  - Aplicamos tipado estricto tanto en argumentos de entrada como de retorno.
  - Los métodos que tengan un tipo de retorno deben empezar por **get**
  ```php
  private function getUserRolesByUuid(string $uuid): array
    
  private function changeUserRoles(array $newRoles, int $userId): void

  private function getFilesFromAzureByTypeOrFail(string $fileType): array
  ```
  - Los arrays los definimos en plural y con valor semántico. 
  ```php
  foreach ($assets as $asset)
  foreach ($roles as $role)
  ```
- [Calidad del código](https://youtu.be/jNSQuqMW8sM?t=2799)
- las variables se definen lo más cerca de donde se utilizan
- Usamos el operador ternario `$x==$y?"hola":"chao"`
- Como múcho nuestros métodos deberían admitir 2 argumentos en caso de ser más habrá que empaquetarlos en una clase
- No usamos `select * from tabla` siempre que sea posible solamente trabajamos con indices. Los datos completos solo se recuperan en el punto más cercando a la respuesta al cliente.
- No integramos código muerto