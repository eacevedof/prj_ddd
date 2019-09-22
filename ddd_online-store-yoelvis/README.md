# [Youtube - Domain Driven Design (DDD) - Diseño guiado por el dominio - Evento de Endava by Yoelvis Mulen](https://www.youtube.com/watch?v=Mn4TFBXa_2g)
### [Repo original](https://github.com/ymulenll/OnlineStore/tree/develop)

## [Sumario](https://youtu.be/Mn4TFBXa_2g?t=46)
- ¿Qué es el diseño guiado por el dominio?
- ¿Cómo crear un modelo aislado y reutilizable que realmente represente el negocio?
- ¿Cómo manejar la complejidad y los cambios en los requerimientos?

## [Historia](https://youtu.be/Mn4TFBXa_2g?t=76)
- 2003 Libro Domain Driven Design by
  - [Eric Evans](https://twitter.com/ericevans0)
  - ![libro Eric Evans](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/377x500/ed7165248d59e52348b56ae78544d3f2/image.png)

## [¿Qué es el diseño guiado por el dominio?](https://youtu.be/Mn4TFBXa_2g?t=146)
  - **Dominio:**
    - Viene siendo el campo o area de la vida real que queremos llevar al diseño del software
    - Por ejemplo, una tienda virtual, todo ese negocio vendría a ser el dominio que vamos a desarrollar en software.
  - **Diseño guiado por dominio**
    - Enfoque del desarrollo centrado en el dominio
    - La lógica de negocio que se va a desarrollar
    - [**¿Dónde aplicarlo?**](https://youtu.be/Mn4TFBXa_2g?t=226)
      - ~Aplicaciones simples~
        - App a corto plazo (fastfood app)
      - ~Complejidad técnica~
        - Si hay una técnología especifica 
      - Complejidad en la lógica de negocio (App empresariales)
        - Un banco
    - [**Entender necesidades**](https://youtu.be/Mn4TFBXa_2g?t=312)
      - Las personas **expertos del dominio** nos marcan los requistos
      - Para esta comunicación entre **expertos** y **desarrolladores** se define un **lenguaje ubicuo**
      - Lenguaje que está en todas partes
        - Expertos llaman a una acción: compra de producto
        - Desarrolladores: Adquisición de recursos
        - El término definitivo para este proceso sería: **compra de producto**
        - [Este término lo usaríamos en todos lados:](https://youtu.be/Mn4TFBXa_2g?t=403)
          - ![donde se usaría](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/875x540/ca612d1c4dc2f4c3a911b19aacf20c7d/image.png)
          - Conversaciones
          - Documentación
          - Código fuente, variables, métodos
        - Es un lenguaje evolutivo
    - [Subdominios](https://youtu.be/Mn4TFBXa_2g?t=447)
      - Dividir el problema en partes más pequeñas
        - ![Sub-dominios](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/849x532/0359fc059363109a5d9ea800e15a28fb/image.png)
        - Ordenes, Catálogo, Envíos
      - [Contextos delimitados - Bounded contexts](https://youtu.be/Mn4TFBXa_2g?t=470)
        - ![bounded contexts](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/823x481/31a8aac13cff04c02b6fc1ab25b0adb8/image.png)
      - Subdominio: describe el sub-problema
      - Bounded Context: aporta solución a ese sub-problema
  
  ## [Parte estratégica](https://youtu.be/Mn4TFBXa_2g?t=556)
  - La anterior fué la parte analítica
  - **Asignar arquitecturas**
    - ![asignar arquitecturas](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/918x454/5318571a8a1c2657a3d29a3ea4d25cc0/image.png)
    - Para el catálogo concluimos que no necesitamos mayor operación que un simple CRUD
    - Para el shipping se usará una API
    - Para el Ordering se aplicará el patrón **Domain Model** la parte compleja (todo lo que se hace en amazon por ejemplo)
      - ![arquitecturas definidas](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/821x492/0254df2b3b2a6555b30ff545cbafa1ea/image.png)
    - [Arquitectura en capas](https://youtu.be/Mn4TFBXa_2g?t=697)
      - Qué es el patrón **Domain Model**
      - ![en capas](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/878x526/0464d30c7f5ac00c67f2cd8b543d4b3d/image.png)
      - Traducción de MVC a DDD (PADI)
      - Desventajas de MVC:
        - La lógica de negocio está acoplada a los datos (data layer)
        - La parte de negocio está distribuida por varias capas
      - La capa de presentación será la mimsma.
      - La capa de negocio se divide en dos partes:
        - Application Layer (orquestación de casos de uso)
        - Domain Layer (solo tendrémos la lógica de negocio)
          - Esta capa no tiene dependencias de ningúna otra. (app e infra dependen de ella)
      - La capa de infraestructura no solo va a ser el Data Layer, tambien contemplará los procesos de login, caching, self containers etc.
  ## [Estructura de proyectos](https://youtu.be/Mn4TFBXa_2g?t=873)
  - Arbol de carpetas y ficheros
    - ![arbol carpetas](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/535x422/402c5c08ee3fa58a8b562ab85333e66e/image.png)
    - Tenemos los **bounded contexts** Catalog y Ordering
    - **Ordering** al ser el más complejo lo dividimos en las 4 capas (PADI)
    - Web.MVC es la capa de presentación
## [Capas](https://youtu.be/Mn4TFBXa_2g?t=924)
- **Domain Layer**
  - ![D](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/843x214/cd47a88a8807e9c2adc8b1883d12b497/image.png)
  - Reglas de negocio
  - Delega detalles técnicos a la capa de infraestructura
- [**Diseño de interfaz**](https://youtu.be/Mn4TFBXa_2g?t=970)
  - ![P](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/650x494/ddf7f3f6b0e04711dbf1a3f0528ef5a0/image.png)

## [¿Cómo crear un modelo aislado y reutilizable que realmente represente el negocio?](https://youtu.be/Mn4TFBXa_2g?t=989)
- [**modelo**](https://youtu.be/Mn4TFBXa_2g?t=998)
  - Son las entidades y su relación
  - Se parece la capa de datos modelada, no es así, esto tiene una complejidad extra
  - ![entities](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/920x493/cb79b80abf927550a558a5fabcae59fd/image.png)
    - clientes, pedido, lineas de pedido, producto
  - [Las entidades no solo van a tener datos](https://youtu.be/Mn4TFBXa_2g?t=1060)
    - ![entity order](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/607x387/205d30ddad620557342a37373edd4c6a/image.png)
    - Todos los metodos presentes tienen una **alta cohesión** 
      - `new Order(), AddOrderItem(item), MarkAsShipped(), Cancel()`
  - [Agregados](https://youtu.be/Mn4TFBXa_2g?t=1123)
    - Con esto se simplifica el modelo del dominio
    - ![Agregados](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/705x519/f25bb614e990138d252ef486678862ad/image.png)
    - Son como reglas
    - Nos restringe la existencia de entidades dependiendo de otras
    - Debemos de tener todas las relaciones a travez de la entidad raiz (modelo estrella)
    - Por ejemplo, la relación producto-orderitem no existiría, sería producto-order
    - ![wrong relation](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/745x496/f5d4f847ac9037a55d611d573ce6a3bd/image.png)
    - ![agregados](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/837x515/bac411f77da160b3ca23d113a2f9f4eb/image.png)
    - Configuración de OrderAggregate
      - ![conf OrderAggregate](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/763x403/c0503bfc13e9b0de2f34319e3eaa6d2e/image.png)
      - **IOrderRepository** Repo Interface
      - **Order** Aggregate root
      - **OrderItem** Child Entity
      - **OrderState**  Enum type (menu en la orden)
  - **Show me the code**
    - [Order Img](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/975x529/d4f363a596ebb5d25deb83eb94c1d7c1/image.png)
    ```c#
    /*
    - solo se van a poder crear pedidos usando el constructor ya que los metodos set son privados
    - de esta manera se garantiza la consistencia en la entidad
    - en esta capa no se persistiran los pedidos (infrastructure ignore)
    - con el IAggregateRoot se obliga a que solo se persistan los objetos que implementen esta interface
    - de modo que no se pueda persistir un OrderItem por separado, así obligo que pasen el filtro del root
    - al ser OrderItem IEnumerable obliga que no se inyecte objetos OrderItem por otro lado ya que solo
    devolverá los items recuperados por _orderItems

    */

    //Entity tiene el campo id
    public class Order: Entity, IAggregateRoot
    {
      public Order(Customer oBuyer)
      {
        Buyer = oBuyer;
        Date = DateTime.UtcNow;
        State = OrderState.Pending;
      }

      //este constructor está protegido ya que lo requiere Entity Framework
      protected Order()
      {}

      public OrderState State {get; private set;}
      public DateTime Date {get; private set;}
      public Customer Buyer {get; private set;}
      ...
      public IEnumerable<OrderItem> OrderItem => _orderItems.AsReadOnly();

      public void AddOrderItem(int quantity, Product oProduct)
      {
        var existingItemForProduct = _orderItmes.SingleOrDefault(item => item.Product.id == oProduct.id);
        //si existe el producto en el listado, actualiza la cantidad
        if(existingItemForProduct != null)
        {
          existingItemForProduct.AddUnits(quantity);
        }
        //si no existe
        else
        {
          //create new item
          var orderItem = new OrderItem(this,quantity,oProduct);
          _orderItems.add(orderItem);
        }
      }

      //aplicamos el método con el lenguaje ubicuo
      public Order MarkAsShipped()
      {
        //regla de negocio:
        //si el estado no es pendiente, no se puede marcar como realizado
        if (State != OrderState.Pending)
          //con esta excepción se garantiza la consistencia de la entidad, es decir, que esté en 
          //un estado válido
          throw new InvalidOperationException("Can't mark as shipped an order that is not pending.");
        
        State = OrderState.shipped;
        return this;
      }

    }//public class Order

    /*
    - https://youtu.be/Mn4TFBXa_2g?t=1726
    - esta no es un agregate root ya que no va a persistir ella sola
    */
    public class OrderItem: Entity
    {
      public Product Product {get; private set;}
      public Order Order{get; private set;}
      protected OrderItem(){}
      public OrderItem(Order order, int quantity, Product product)
      {
        if(quantity<=0)
        {
          //otra vez garantizamos que se cumpla la regla de negocio
          throw new OrderingDomainException("Invalid quantity of units");
        }

        Order = order;
        Quantity = quantity;
        Product = product
      }
    }
    ```
    - [Repository Interfaces](https://youtu.be/Mn4TFBXa_2g?t=1757)
    - Capa de dominio
    ```c#
    //Se le indica que el objeto que reciba la interface sea de tipo Aggregate
    public interface IRepository<T> where T: IAggregateRoot
    {}

    /*
    - gestor del crud
    - solo se le va a indicar que es lo que hara para persistir
    - esta será implementada en infraestructura
    */
    public interface IOrderRepository: IRepository<Order>
    {
      void Add(Order order);
      void Update(Order order);
      Order Get(int orderId);
    }

    ```
    - [Pendiente](https://youtu.be/Mn4TFBXa_2g?t=1844)
      - No tocará estos temas :( por cuestión de tiempo
        - Objetos de valor (value objects)
        - Servicios de dominio 
        - Eventos de dominio
- [**Infrastructure Layer**](https://youtu.be/Mn4TFBXa_2g?t=1884)
  - Entity framework ORM
  - ![entity](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/909x480/d263d26df113271e4d4614e2fb08160c/image.png)
  - Se puede configurar las relaciones en los atributos o crear los mapeos aparte
  - carpeta **Mappings**
  - [Ejemplo de mapeo en entity:](https://youtu.be/Mn4TFBXa_2g?t=1977)
    - `public class OrderItemMap:IEntityTypeConfiguration<OrderItem>`
    - usando fluentAPI
    - ![entity mappings](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/1015x441/a1ebf1f938312c2beb8cb470c36a1894/image.png)
  ```c#
  public class OrderRepository: IOrderRepository
  {
    //contexto de entity framework
    private readonly OrderingContext _context;
    
    public OrderRepository(OrderingContext context){}

    public void Add(Order order)
    {
      _context.Orders.Add(order)
      _context.SaveChanges();
    }

  }
  ```
- [**Application Layer**](https://youtu.be/Mn4TFBXa_2g?t=2082)
  - ![app](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/514x355/06c9e3dd265fcf18ac14d5fa66c6b5f5/image.png)
  - Será como un controlador, utilizará Domain e Infrastructure
  ```c#
  //IOrdersService.cs
  using Ordering.Application.InputModels;
  using Ordering.Application.ViewModel;

  namespace Ordering.Application
  {
    public interface IOrdersService
    {
        OrderPlacedViewModel PlaceOrder(ShoppingCartInputModel shoppingCartInputModel);
    }
  }


  using System.Globalization;
  using Ordering.Application.ExternalServices;
  using Ordering.Application.InputModels;
  using Ordering.Application.ViewModel;
  using Ordering.Domain.Model.OrderAggregate;

  namespace Ordering.Application
  {
    public class OrdersService : IOrdersService
    {
      private readonly IOrderRepository _orderRepository;
      private readonly IShippingService _shippingService;

      public OrdersService(IOrderRepository orderRepository, IShippingService shippingService)
      {
        _orderRepository = orderRepository;
        _shippingService = shippingService;
      }

      public OrderPlacedViewModel PlaceOrder(ShoppingCartInputModel cart)
      {
        // 1. Create order in memory.
        var order = new Order(cart.ShoppingCart.Buyer);

        foreach (var item in cart.ShoppingCart.Items)
        {
          order.AddOrderItem(item.Quantity, item.Product);
        }

        // 2 Store order
        _orderRepository.Add(order);

        // 3. Ship
        var shipmentDetails = _shippingService.SendRequestForDelivery(order);

        // 4. Prepare view model
        var viewModel = new OrderPlacedViewModel
        {
          OrderId = order.Id.ToString(CultureInfo.InvariantCulture),
          ShippingDetails = shipmentDetails
        };

        return viewModel;
      }
    }
  }  
  ```
- [**Presentation Layer**](https://youtu.be/Mn4TFBXa_2g?t=2220)  
  - La vista se comunica con application
  - ![presentation layer](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/768x541/eab11f23777754c2c63f6d91b4a1729d/image.png)
  ```c#
  using System;
  using System.Collections.Generic;
  using System.Linq;
  using System.Threading.Tasks;
  using Microsoft.AspNetCore.Mvc;
  using Ordering.Application;
  using Ordering.Application.InputModels;

  namespace Web.MVC.Controllers
  {
    public class OrderController : Controller
    {
      private readonly IOrdersService _ordersService;

      protected OrderController(IOrdersService ordersService)
      {
        _ordersService = ordersService;
      }

      public IActionResult PlaceTheOrder()
      {
        var cart = RetrieveCurrentShoppingCart();
        var viewModel = _ordersService.PlaceOrder(cart);
        return View("OrderPlaced", viewModel);
      }

      private ShoppingCartInputModel RetrieveCurrentShoppingCart()
      {
        throw new NotImplementedException();
      }
    }//class
    
  }//namespace
  ```
## [¿Cómo manejar la complejidad y los cambios en los requerimientos?](https://youtu.be/Mn4TFBXa_2g?t=2298)
- ![resumen](https://trello-attachments.s3.amazonaws.com/5d85fbb425740b29d72cedbb/914x517/0009a442ce2f13ff8673ba914086b368/image.png)

## [Tarea: Variantes del patrón: Modelo de dominio](https://youtu.be/Mn4TFBXa_2g?t=2534)
- Command-Query Responsability Segregation
- Event Sourcing

## [Youtube - Diseño guiado por el dominio by Yoelvis Mulen @ .NET Conf UY v2018](https://youtu.be/sQw5vnjdLok)
