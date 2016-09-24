pizzeria
========

A Symfony project created on September 23, 2016, 5:38 pm.


## Load fixtures

```bash
bin/console do:da:dr --force
bin/console do:da:cr
bin/console do:sc:up --force
bin/console doctrine:fixtures:load --fixtures=src/AppBundle/DataFixtures
```