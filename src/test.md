## buildArray()
The buildArray function registers new api endpoints.
```php
buildArray($target, $key, $default)
```
### Parameters

<ul>
    <li><b>target</b> <i>(array/object) (Required)</i> </li>
    <li><b>key</b> <i>(string) (Required)</i> </li>
    <li><b>default</b> <i>(string) (Optional)</i> </li>
</ul>

### Example
```php
endpoints()->buildArray('iroh', '/iroh-route', [
    'methods'             => 'POST',
    'callback'            => 'iroh_example_function',
    'permission_callback' => '__return_true',
])->buildArray('iroh', '/iroh-route-1', [
    'methods'             => 'GET',
    'callback'            => 'iroh_example_function',
    'permission_callback' => '__return_true',
])->addTheActions();

function iroh_example_function()
{
    return wp_send_json('iroh', 200);
}

```