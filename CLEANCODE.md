## Manifiesto cleancode

- [Video Codely - De código acoplado al framework hasta microservicios pasando por DDD](https://youtu.be/o0w-jYun6AU)
  - [Repo esqueleto en DDD Codely](https://github.com/CodelyTV/php-ddd-example/tree/main/src/Mooc/Courses)
  - [Parte del código del video](https://github.com/eacevedof/prj_phptests/tree/master/examples/eventsourcing)

### BE

#### Esquema de datos
- Los nombres de las tablas y campos siempre se deben definir en Inglés.
- Los nombres de las tablas debemos considerarlos como un conjunto de datos desacoplable del core e identificarlas con un prefijo. Teniendo en perspectiva llevar esa funcionalidad a un micro-servicio.
- Un ejemplo son las tablas **assets_** y/o **bulk_**
- Los nombres se definen en plural (por seguir la convención del esquema heredado CEH)
- Las claves foraneas siguen el siguiente formato: **<nombre-de-tabla-destino>_id** (según CEH) un ejemplo es **assets_id**
- Si hay que incluir una tabla de idiomas esta debe terminar con el sufijo de la que se traduce **<nombre-de-tabla-principal>_tr**
  - Es importante que en estas solo existan los campos traducibles ninguna información más.
- Los campos **booleanos** se definen en formato pregunta: has_visibility, is_visible, is_blocked, etc.
- Creamos tablas 1:1 para aquellos casos donde tengamos que almacenar estructuras JSON. En la principal definimos todos los campos menos los tipo JSON

#### Esqueleto base de un controlador. Ejemplo: Caso de uso: Actualizar un Asset
- Todas las clases son [final - Ocramius](https://youtu.be/Gl9td0zGLhw?t=2278) y readonly por defecto
```php
final class AssetFullUpdateController
{
/**
 * HttpResponse nos facilita el formateo de respuestas JsonResponse
 * SentryTrait tiene métodos de envío al servicio de Sentry
 */
    use HttpResponse, SentryTrait;
  
    public function __construct(
        private readonly LanguageManagerService $languageManagerService,
/**
 * una instancia inyectada puede ser nula si esta es muy pesada (tiene atributos que ocupan espacio considerable en memoria)
 * el objetivo es liberar ese espacio seteando a null la variable. 
*/        
        private ?AssetFullUpdateDtoFromRequestBuilderService $assetFullUpdateDtoFromRequestBuilderService,
        private ?AssetFullUpdateValidator $assetFullUpdateValidator,
        private ?AssetFilesTagChangeValidator $assetFilesTagChangeValidator,
        private readonly AssetFullUpdateService $assetFullUpdateService
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
    /**
     * Aplicamos el principio "Tell, Don't Ask". Es decir ordenamos a los servicios que ejecuten su única responsabilidad
     * no usamos if por fuera. https://martinfowler.com/bliki/TellDontAsk.html
     * 
     * Este servicio se encarga de cargar el idioma a partir de la configuración seleccionada por
     * el usuario.
     * 
     * Esto hace que los mensajes que se configuren en la "Response" vayan traducidos.
     */
        $this->languageManagerService->loadLocaleByHeaderLanguage();
        try {
    /**
     * No usamos librerías de terceros para mapear un DTO a partir de la request.
     * Nuestros DTOs suelen cumplir un patrón básico:  app/DTO/AbstractDto.php que cumple
     * con los datos mínimos de logs de auditoría.
     * 
    */    
            $assetFullDto = $this->assetFullUpdateDtoFromRequestBuilderService->__invoke($request);
            $this->assetFullUpdateDtoFromRequestBuilderService = null;
    /**
     * Aquí ejecutamos "early error". Se valida el payload de entrada y se lanzan excepciones Ad-Hoc 
     * para aquellos casos en los que el DTO no cumple con las Reglas de negocio.
     * 
     * Es importante definir correctamente los códigos de error en las excepciones 
    */     
            $this->assetFullUpdateValidator->__invoke($assetFullDto);
            $this->assetFullUpdateValidator = null;
    
    /**
     * Una clase no debería superar las 400 líneas. Si es así es necesario partirla. 
     * En este caso el validador original de actualización se ha dividido en dos.
     */
            $this->assetFilesTagChangeValidator->__invoke($assetFullDto);
            $this->assetFilesTagChangeValidator = null;
    
    /**
     * El servicio que resuelve el caso de uso recibe como única entrada un DTO de solo lectura.
     * Esto nos asegura que no será cambiado a lo largo de todas las capas por las que tenga que pasar
     * dentro de la acción. 
     * 
     * Debemos 
     */
            $this->assetFullUpdateService->__invoke($assetFullDto);
    /**
    * si todo ha ido bien se envía un 200 y el nodo message, en caso de tener que enviar más datos
    * se apilan en el array por debajo de "message" 
    */
            return $this->send200Response([
                "message" => trans("asset-full-tr.success.asset-successfully-saved")
            ]);
        }
        catch (AbstractAssetFullException | AssetsFilesTagException $ex) {
    /**
     * En esta sección se captura todas aquellas excepciones que están relacionadas con el caso de uso a cubrir
     * Las de los validadores.
     */    
            return $this->sendResponseByCode($ex->getCode(), ["message" => $ex->getMessage()]);
        }
        catch (Exception $ex) {
    /**
     * En esta sección se captura todas aquellas excepciones que se escapan a las reglas de negocio estas se envían
     * a Sentry con el fin de tener visibilidad en los entornos
     */    
            $this->sendExceptionToSentry($ex);
            return $this->send500Response(["message" => trans("exceptions.unexpected_500")]);
        }
    }
```
- Evitamos el fuerte acomplamiento al **framework de turno**. Este es un componente reemplazable de infraestructura y no pertenece al dominio de nuestra aplicación.
  - Esto no solo cuenta para librerías propias del fw sino también de terceros. Hay que pensar que se puede quedar sin soporte.
  - [PHP-Frameworks-Bench](https://github.com/myaaghubi/PHP-Frameworks-Bench)

- ### Endpoints:
- Deberían ser user friendly y aplicando el formato slug en las urls
- Matizar la diferencia de los métodos: **update y patch**. **update** para datos completos de un recurso y **patch** para actualizaciones parciales.
- usamos guiones medios y siempre minúsculas
  - https://undominio.com/asset/update/parametro-1 (ok)
  - https://undominio.com/Asset/Update/Parametro_1 (nok)

- ### Encapsulación
  - Las clases deben ser **final** por defecto `final class AssetFullUpdateController, etc`
  - Procuramos no recurrir a la herencia siempre que sea posible. En su lugar optamos por el uso de Composición (usando el inyector de dependencias).
    - Otra opción son los [traits - Ocramius](https://youtu.be/Gl9td0zGLhw?t=2305) aunque tiene sus desventajas.
    - De forma resumida el fín es facilitar la implementación de tests unitarios. La composición nos da visibilidad de los componentes que intervienen y permiten ser "moqueados".
    - [Composición sobre herencia - Codely](https://www.youtube.com/watch?v=OyTPDFyGWRc)
    - [Relaciones entre objetos (UML) - UPM](https://youtu.be/jNSQuqMW8sM?t=263)

  - Por defecto todos sus **atributos** y **métodos** son [private - Ocramius](https://youtu.be/Gl9td0zGLhw?t=1567). 
    - Mantener un [método público - Ocramius](https://youtu.be/Gl9td0zGLhw?t=1406) tiene un costo mayor.

  - Como métodos públicos dispondremos el constructor y el método `__invoke()` (la carga semántica de la accíón recae en el nombre de la clase).
    - Este nombre ya indica de partida que nuestra clase tendrá una única responsabilidad. La **S** de SOLID.
  - En el constructor se hace la inyección de dependencias (no hacemos ninguna lógica solo asignamos) y con invoke se ejecuta la única lógica 
  para la que ha sido creada la clase. **AssetFullUpdate**

- ### Clases y su responsabilidad en una aplicación
  - Sufijo que identifica la responsabilidad
  - AssetFullUpdate**Controller**
    - Gestiona el punto de entrada, request y su resultado de post procesado response
    - [Ejemplo de Controlador en DDD - Codely](https://youtu.be/o0w-jYun6AU?t=1465)

  - AssetFullUpdate**Command** AssetFullUpdate**Dto**
    - DTO (Data Transfer Object). [Objeto inmutable - Ocramius](https://youtu.be/Gl9td0zGLhw?t=1110)
    - Es el payload mínimo de entrada (que conoce el handler). Se extrae de la request y que se pasará al handler.

  - AssetFullUpdate**CommandHandler** 
    - Es una capa de indirección más. Recupera el Command (DTO) anterior y lo descompone en sus primitivos para pasarlo al servicio 
    - Esta capa tiene sentido si trabajamos con un EventHandler por ejemplo.
    - [Ejemplo de CommandHandler en DDD - Codely](https://youtu.be/o0w-jYun6AU?t=1492)

  - AssetFullUpdate**Service**
    - [Porqué se separa el servicio del command handler? - Codely](https://youtu.be/-Cim-IgBoLA?t=2098) 
    - Application service. Encapsula el caso de uso que se pretende resolver. En el ejemplo, actualizar un asset.
    - La diferencia entre un command handler y un servicio de aplicación es que el segundo hace una lógica compleja que está estrechamente relacionada con el Dominio de la app.
    - [Ejemplo de un Application Service en DDD - Codely](https://youtu.be/o0w-jYun6AU?t=1561)

  - AssetFullUpdate**Dto**
    - Lo ideal es que cada vez que se ejecute el caso de uso, este, si tiene que devolver algo deberia ser un [objeto DTO - Ocramius](https://youtu.be/Gl9td0zGLhw?t=2459).
    - En nuestro caso para no meter otra capa de indirección nos vale con devolver tipos primitivos y/o arrays.
    - Optamos por arrays antes que las colecciones. Son más ligeros y hay funciones nativas como map, filter, reduce que nos permiten hacer operaciones de transformación.
    - El **DTO** de entrada suele tener un naming constructor **fromPrimitives(array $primitives)** puede que si el caso de uso no es complejo nos baste con este método.
    - Si la construcción implica hacer una lógica compleja debemos recurrir a un **builder** 
      - Ejemplo **/BulkTacticalRequestCreateAssetFullDtoBuilderService.php** 

  - AssetFullUpdate**Validator** AssetFullUpdate**CommandValidator**
    - En el servicio se validan las reglas de negocio que debe pasar el **comando** antes de ser invocado en el caso de uso
    - Een caso de no cumplir se lanza una excepción tipada
    - Se validan los tipos primitivos
    - Se hacen comprobaciones contra la bd

  - AssetFull**Repository**
    - Implementa [AssetFullRepositoryInterface](https://youtu.be/EInyOtPra44?t=250)
    - [Cuando usar Interfaces - Codely](https://youtu.be/uP1CoHtjALg?t=498)
    - No usamos métodos estáticos, ya que estos esconden lógica que a posteriori dificultará la **testabilidad**
    - Lo mismo ocurre con los **helpers** esas funciones que es una estratégia más propia de la progamación imperativa.

  - AssetFull**Provider**
    - Implementa AssetFullRepositoryInterface
    - Es equivalente a un repositorio, pero con la salvedad que el origen de los datos que abstrae es un **sistema externo**, un micro-servicio, una api de terceros, etc.

  - Asset**Entity** (extiende de [AggregateRoot - Codely](https://youtu.be/EInyOtPra44?t=173))
    - Sobre el [AggregateRoot - Ocramius](https://youtu.be/Gl9td0zGLhw?t=2695) 
    - El nombre siempre en singular, ya que una entidad es la representación única de un modelo de datos. 
    - [Sobre named constructors en lugar de usar new AssetEntity - Codely](https://youtu.be/J0SFLG5B3wo?t=142)
    - [Ejemplo de la entidad Aggregate en DDD - Codely](https://youtu.be/o0w-jYun6AU?t=1595)

  - AssetFullUpdated**Event**
    - Es un DTO inmutable.
    - El nombre de los eventos siempre acompañados de una acción en pasado. _Updated, Created, Removed, etc_

  - AssetFullUpdateApi**Transformer**
    - Si procede, al resultado anterior se le puede aplicar alguna transformación antes de enviar la respuesta al cliente 
    - AssetFullUpdateConsoleTransformer
    - AssetFullUpdateTemplateTransformer
    - AssetFullErrorTransformer

  - AssetFullUpdate**Test**
    - Prueba unitaria del caso de uso
    - [Ejemplo de test de caso de uso en DDD - Codely](https://youtu.be/o0w-jYun6AU?t=1634)

  - AssetFull**Trait**

  - **AssetFullInterface**

  - AbstractAssetFull**Exception**
    - AssetFullUpdateException
    - AssetFullFilterException
    - [Named Constructors I - Carlos Buenosvinos](https://youtu.be/LjEG7AR-MOg)

  - AssetsXxx**Enum**

- ### Otros puntos a tener en cuenta
  - Aplicamos el principio  **"Tell, Don't Ask"**
  - Trabajamos con [**early error** y con **early return** - Ocramius](https://youtu.be/Gl9td0zGLhw?t=2821).
    - Al mínimo error nos salimos del contexto en el que estamos.
    - Evitamos el `if () elseif (){} else {}` y el patrón **hadouken** [Programar sin else - Codely](https://youtu.be/FVxS28oyLuw)
  - Evitamos comentarios. Debe ser el último recurso. Para esto usamos variables métodos, constantes y clases con alto valor semántico
  ```php
  private function isValidAssetHead(array $assetHead): bool
  {
    /**
    * early return or return first
    */
    if (!$assetHead) {
        return false;
    }
    if (!$userId = $assetHead["user_id"]) {
        return false;
    }
    /*
    * el acceso a datos es el cuello de botella de toda app con persistencia.
    * procuramos asegurarnos de las condiciones ideales para ejecutar acciones de lectura y/o escritura.
    */
    if (!DB::getUserId($userId)) {
        return false;
    }
    return true;
  }
  ```
  - Los nombres de las variables deben estar en formato **$camelCase** no **$snake_case** 
  - No usamos literales planos o numericos (magic numbers) en clausulas de guarda, recurrimos a enumerados o constantes con valor semántico.
  - [Métricas de calidad del código - UCM](https://youtu.be/jNSQuqMW8sM?t=2799)
  - Usamos comillas dobles ya que permiten la interpolación en lugar de la concatenación
  ```php
  $userName = "Eduardo";
  $lastName = "Acevedo";
  $welcomeMessage = "Hola {$userName} bienvenido";
  $fullName = "{$userName} {$lastName}";
  
  $names = [
    "$userName 1" => "xxx",
    "$userName 2" => "yyy",
  ];
  ``` 
  - Aplicamos tipado estricto tanto en argumentos de entrada como de retorno [(no usamos **mixed**) - Ocramius](https://youtu.be/Gl9td0zGLhw?t=2124).
  - Los métodos que tengan un tipo de retorno deben empezar por **get** y si es un booleano la firma debe ser en forma de pregunta: **is, has, does, do, etc**
  ```php
  private function getUserRolesByUuid(string $uuid): array;
    
  private function changeUserRoles(array $newRoles, int $userId): void;

  private function getFilesFromAzureByTypeOrFail(string $fileType): array;
  
  private function doesUserHavePermissionByUserId(int $userId): bool;
  ```
  - Evitamos métodos porlimorficos y más si son públicos. [Avoid swtich parameters - Ocramius](https://youtu.be/Gl9td0zGLhw?t=1472)
  ```php
  //nok
  $actionType = "create"; //update
  public function myMethodChangeActionByType(int $userId, string $actionType): void;
  
  //ok
  public function myMethodDoActionOnCreate(int $userid): void;
  public function myMethodDoActionOnUpdate(int $userid): void;
  ```
  - Los arrays los definimos en plural y con valor semántico. 
  ```php
  foreach ($assets as $asset)
  foreach ($roles as $role)
  ```
- las variables se definen lo más cerca de donde se utilizan
```php
private function addUsersWithVisibility(array $users): void
{
    /*
     * Esta defininición no está en el punto más cercando a su utilización.
     * Estamos ocupando memoria que es probable que no se use
     * */
    $usersWithVisibility = [];
    if (count($users) > self::MAX_NUMBER_OF_USERS)
        return;
    
    if (count($users) < self::MIN_NUMBER_OF_USERS)
        return;
    
    // este es el punto más cercano a su uso
    $usersWithVisibility = [];
    foreach ($users as $user) {
        if ($user->profile === self::SUPERVISOR && $user->visibility)
            $usersWithVisibility[] = $user;
    }
    
    $this->withVisibility = array_map(fn()=> , $usersWithVisibility);
}
```
- Usamos el operador ternario `$x==$y?"hola":"chao"`
- Como mucho nuestros métodos deberían admitir **2 argumentos** en caso de ser más habrá que empaquetarlos en una clase (DTO o [ValueObject - Ocramius](https://youtu.be/Gl9td0zGLhw?t=2153))
```php
//nok
private function areAgesInRangeOrFail(int $age1, int $age2, int $age3): bool;

//ok
private function areAgesInRangeOrFail(array $ages): bool;
```
- No usamos `select * from tabla` siempre que sea posible solamente trabajamos con índices. Los datos completos solo se recuperan en el punto más cercando a la respuesta al cliente.
  - El `*` penaliza una query y más si esta incluye campos tipo **TEXT** debemos preguntar por indices (pks o fks) y en el punto más cercano a la respuesta es el lugar donde recuperamos **únicamente** los datos mínimos que rara vez son `*`
  ```php
  //nok
  $asset = Assets::whereId($assetId);
  //ok
  $asset = Assets::select(["id","asset_name"])->whereId($assetId);
  ```
- Evitamos usar las relaciones del ORM (métodos **with**)
  - [Desintoxicándonos de Eloquent - Codely](https://www.youtube.com/watch?v=EInyOtPra44) 
  - Esto procura evitar los *leaks de infraestructura*
  - Hay que evitar las interfaces fluidas: [Fluent interfaces - Ocramius](https://youtu.be/Gl9td0zGLhw)
  ```php
  //Aqui nuestra entidad TacticalRequestEntity estaria conociendo de infraestructura para obtener una tarea que al mismo tiempo repite 
  //el proceso para obtener el tipo.  Una entidad no tiene esta responsabilidad quien tiene acceso a los datos es el repositorio que es una abstracción
  //de la capa de Infra.
  $tacticalRequest->task->type->name
  ```
- No integramos [código muerto - Ocramius](https://youtu.be/Gl9td0zGLhw?t=2443). Principio YAGNI