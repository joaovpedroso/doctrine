<?php

require_once __DIR__ . "/App/Config/doctrine.php";

$entityManager = getEntityManager();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);