<p>You are using the following route:<br><code>'<?=$route?>'</code></p>

<p>The router contains the following routes.</p>
<ul>
<?php foreach($routes as $route) {
    echo "<li><code>'" . $route->getRule() . "'</code></li>";
}?>
</ul>

<p>The router contains the following internal routes.</p>
<ul>
<?php foreach($internalRoutes as $route) {
    echo "<li><code>'" . $route->getRule() . "'</code></li>";
}?>
</ul>

<p>The following controllers are loaded as services in <code>$di</code>.</p>
<ul>
<?php foreach($services as $service) {
    if (strpos($service, "Controller") !== false) {
        echo "<li><code>" . $service . "</code></li>";
    }
}?>
</ul>
