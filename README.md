# CloudBase | Plugin Skeleton

A template project for creating CloudBase plugins.

```sh
composer create-project cloudbase/skeleton my-plugin
```

---

## Routes & Controllers

### Controllers

Your plugin controllers need to be defined inside `config/services.yaml` - a default definition has been created
for you which will more often than not require no changes - unless you'd like your controllers to live outside
your plugins `src/Controllers` directory:

```yaml
  CloudBase\Skeleton\Controller\:
    resource: '../src/Controller'
    tags: [ 'controller.service_arguments' ]
    autowire: true
    public: true
```

### Routes

Your controllers are responsible for defining their own routes as **attributes**. See the example controller provided 
at `src/Controller/PluginController.php`.

Your controller methods **must** return a `Symfony\Component\HttpFoundation\Response` object.

You can render plain text by returning a `new Response()`:

```php
return new Response('Hello, world!', 200);
```

### Templates

CloudBase uses Latte as its templating engine. You can return rendered Latte templates:

```php
return $this->renderedLatteResponse('@vendor/package/index');
```

The above code will render your plugins `views/index.latte` template.